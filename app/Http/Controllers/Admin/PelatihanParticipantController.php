<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PelatihanParticipantApprovedMail;
use App\Mail\PelatihanParticipantRejectedMail;
use App\Mail\PelatihanStatusUpdatedMail;
use App\Models\Pelatihan;
use App\Models\PelatihanParticipant;
use App\Models\PelatihanSubParticipant;
use App\Services\WatzapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PelatihanParticipantController extends Controller
{
    protected WatzapService $watzap;

    public function __construct(WatzapService $watzap)
    {
        $this->watzap = $watzap;
    }

    public function index(Request $request, $pelatihanId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        $query = PelatihanParticipant::with('referral', 'bundle')
            ->where('pelatihan_id', $pelatihanId);

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->q) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('full_name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('registration_code', 'like', '%' . $keyword . '%')
                    ->orWhere('whatsapp', 'like', '%' . $keyword . '%');
            });
        }

        $participants = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'all'      => PelatihanParticipant::where('pelatihan_id', $pelatihanId)->count(),
            'pending'  => PelatihanParticipant::where('pelatihan_id', $pelatihanId)->where('status', 'pending')->count(),
            'approved' => PelatihanParticipant::where('pelatihan_id', $pelatihanId)->where('status', 'approved')->count(),
            'rejected' => PelatihanParticipant::where('pelatihan_id', $pelatihanId)->where('status', 'rejected')->count(),
        ];

        return view('admin.pelatihan.participant.index', compact('pelatihan', 'participants', 'counts'));
    }

    public function show($pelatihanId, $participantId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        $participant = PelatihanParticipant::with(['answers.question', 'referral', 'bundle', 'subParticipants'])
            ->where('pelatihan_id', $pelatihanId)
            ->findOrFail($participantId);
        return view('admin.pelatihan.participant.show', compact('pelatihan', 'participant'));
    }

    public function approve(Request $request, $pelatihanId, $participantId)
    {
        $participant = PelatihanParticipant::with('pelatihan')->where('pelatihan_id', $pelatihanId)->findOrFail($participantId);
        $previousStatus = $participant->status;

        $participant->update([
            'status'     => 'approved',
            'admin_note' => $request->admin_note,
        ]);

        if ($participant->referral_id) {
            $participant->referral->increment('used_count');
        }

        $this->sendNotification($participant, 'approved');

        return redirect()->back()->with(['success' => 'Peserta berhasil disetujui dan notifikasi terkirim!']);
    }

    public function reject(Request $request, $pelatihanId, $participantId)
    {
        $participant = PelatihanParticipant::with('pelatihan')->where('pelatihan_id', $pelatihanId)->findOrFail($participantId);

        if ($participant->status === 'approved' && $participant->referral_id) {
            $participant->referral->decrement('used_count');
        }

        $participant->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        $this->sendNotification($participant, 'rejected');

        return redirect()->back()->with(['success' => 'Peserta berhasil ditolak dan notifikasi terkirim!']);
    }

    public function updateStatus(Request $request, $pelatihanId, $participantId)
    {
        $this->validate($request, [
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $participant = PelatihanParticipant::with('pelatihan', 'referral')->where('pelatihan_id', $pelatihanId)->findOrFail($participantId);
        $previousStatus = $participant->status;
        $newStatus      = $request->status;

        if ($previousStatus === $newStatus) {
            return redirect()->back()->with(['info' => 'Status tidak berubah.']);
        }

        if ($previousStatus === 'approved' && $newStatus !== 'approved') {
            if ($participant->referral_id) {
                $participant->referral->decrement('used_count');
            }
        }

        if ($newStatus === 'approved' && $previousStatus !== 'approved') {
            if ($participant->referral_id) {
                $participant->referral->increment('used_count');
            }
        }

        $participant->update([
            'status'     => $newStatus,
            'admin_note' => $request->admin_note ?? $participant->admin_note,
        ]);

        $this->sendNotification($participant, 'status_updated');

        return redirect()->back()->with(['success' => 'Status diperbarui dan notifikasi terkirim!']);
    }

    public function uploadCertificate(Request $request, $pelatihanId, $participantId)
    {
        $this->validate($request, [
            'certificate_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $participant = PelatihanParticipant::where('pelatihan_id', $pelatihanId)->findOrFail($participantId);

        if ($participant->certificate_file) {
            Storage::disk('local')->delete('public/certificates/' . $participant->certificate_file);
        }

        $file = $request->file('certificate_file');
        $file->storeAs('public/certificates', $file->hashName());
        $participant->update(['certificate_file' => $file->hashName()]);

        return redirect()->back()->with(['success' => 'Sertifikat berhasil diunggah!']);
    }

    public function sendCertificate($pelatihanId, $participantId)
    {
        $participant = PelatihanParticipant::where('pelatihan_id', $pelatihanId)->findOrFail($participantId);

        if (!$participant->certificate_file) {
            return redirect()->back()->with(['error' => 'Sertifikat belum diunggah!']);
        }

        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        $filePath = storage_path('app/public/certificates/' . $participant->certificate_file);

        Mail::send('admin.pelatihan.mail.certificate', [
            'participant' => $participant,
            'pelatihan'   => $pelatihan,
        ], function ($message) use ($participant, $pelatihan, $filePath) {
            $message->to($participant->email, $participant->name_for_certificate)
                ->subject('E-Sertifikat ' . $pelatihan->title . ' - ' . ($pelatihan->batch ?? ''))
                ->attach($filePath, [
                    'as'   => 'Sertifikat_' . str_replace(' ', '_', $participant->name_for_certificate) . '.pdf',
                    'mime' => 'application/pdf',
                ]);
        });

        $participant->update(['certificate_sent_at' => now()]);

        return redirect()->back()->with(['success' => 'Sertifikat berhasil dikirim ke ' . $participant->email]);
    }

    public function uploadSubCertificate(Request $request, $pelatihanId, $participantId, $subId)
    {
        $this->validate($request, [
            'certificate_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $sub = PelatihanSubParticipant::where('participant_id', $participantId)->findOrFail($subId);

        if ($sub->certificate_file) {
            Storage::disk('local')->delete('public/certificates/' . $sub->certificate_file);
        }

        $file = $request->file('certificate_file');
        $file->storeAs('public/certificates', $file->hashName());
        $sub->update(['certificate_file' => $file->hashName()]);

        return redirect()->back()->with(['success' => 'Sertifikat sub-peserta berhasil diunggah!']);
    }

    public function sendSubCertificate($pelatihanId, $participantId, $subId)
    {
        $participant = PelatihanParticipant::with('pelatihan')->where('pelatihan_id', $pelatihanId)->findOrFail($participantId);
        $sub = PelatihanSubParticipant::where('participant_id', $participantId)->findOrFail($subId);

        if (!$sub->certificate_file) {
            return redirect()->back()->with(['error' => 'Sertifikat sub-peserta ' . $sub->full_name . ' belum diunggah!']);
        }

        if (!$sub->email) {
            return redirect()->back()->with(['error' => 'Email sub-peserta ' . $sub->full_name . ' tidak tersedia!']);
        }

        $filePath = storage_path('app/public/certificates/' . $sub->certificate_file);
        $pelatihan = $participant->pelatihan;

        Mail::send('admin.pelatihan.mail.certificate', [
            'participant' => (object) [
                'name_for_certificate' => $sub->name_for_certificate,
                'email'                => $sub->email,
            ],
            'pelatihan' => $pelatihan,
        ], function ($message) use ($sub, $pelatihan, $filePath) {
            $message->to($sub->email, $sub->name_for_certificate)
                ->subject('E-Sertifikat ' . $pelatihan->title . ' - ' . ($pelatihan->batch ?? ''))
                ->attach($filePath, [
                    'as'   => 'Sertifikat_' . str_replace(' ', '_', $sub->name_for_certificate) . '.pdf',
                    'mime' => 'application/pdf',
                ]);
        });

        $sub->update(['certificate_sent_at' => now()]);

        return redirect()->back()->with(['success' => 'Sertifikat ' . $sub->name_for_certificate . ' berhasil dikirim!']);
    }

    public function sendAllSubCertificates($pelatihanId, $participantId)
    {
        $participant = PelatihanParticipant::with('pelatihan', 'subParticipants')->where('pelatihan_id', $pelatihanId)->findOrFail($participantId);
        $sent  = 0;
        $fails = [];

        foreach ($participant->subParticipants as $sub) {
            if (!$sub->certificate_file) {
                $fails[] = $sub->full_name . ' (sertifikat belum upload)';
                continue;
            }
            if (!$sub->email) {
                $fails[] = $sub->full_name . ' (email tidak ada)';
                continue;
            }

            $filePath  = storage_path('app/public/certificates/' . $sub->certificate_file);
            $pelatihan = $participant->pelatihan;

            Mail::send('admin.pelatihan.mail.certificate', [
                'participant' => (object) ['name_for_certificate' => $sub->name_for_certificate, 'email' => $sub->email],
                'pelatihan'   => $pelatihan,
            ], function ($message) use ($sub, $pelatihan, $filePath) {
                $message->to($sub->email, $sub->name_for_certificate)
                    ->subject('E-Sertifikat ' . $pelatihan->title)
                    ->attach($filePath, [
                        'as'   => 'Sertifikat_' . str_replace(' ', '_', $sub->name_for_certificate) . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
            });

            $sub->update(['certificate_sent_at' => now()]);
            $sent++;
        }

        $msg = "{$sent} sertifikat berhasil dikirim.";
        if ($fails) {
            $msg .= ' Gagal: ' . implode(', ', $fails);
        }

        return redirect()->back()->with(['success' => $msg]);
    }

    public function export(Request $request, $pelatihanId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);

        $query = PelatihanParticipant::with(['answers.question', 'referral', 'bundle', 'subParticipants'])
            ->where('pelatihan_id', $pelatihanId);

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $participants = $query->latest()->get();

        $questions = $pelatihan->questions()->orderBy('sort_order')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="peserta_' . $pelatihan->slug . '_' . date('Ymd') . '.csv"',
        ];

        $callback = function () use ($participants, $questions) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            $header = [
                'Kode Registrasi', 'Tipe Peserta', 'Nama Lengkap', 'Nama Gelar Sertifikat',
                'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Usia',
                'Email', 'WhatsApp', 'Domisili',
                'Nama Lembaga', 'Jenjang Lembaga (Q4)', 'Kota Lembaga', 'Jabatan',
                'Keterampilan Diperkuat', 'Pernah Pelatihan',
                'Tipe Daftar', 'Jml Kolektif', 'Koordinator',
                'Paket Bundling', 'Kode Referral', 'Mitra Referral',
                'Pengirim Bayar', 'Tgl Bayar', 'Harga Asal', 'Diskon', 'Total Bayar',
                'Butuh Invoice', 'Nama Invoice',
                'Status Verifikasi', 'Catatan Admin', 'Tgl Daftar',
            ];

            foreach ($questions as $q) {
                $header[] = $q->question;
            }

            fputcsv($out, $header);

            foreach ($participants as $p) {
                $row = [
                    $p->registration_code,
                    'Peserta Utama',
                    $p->full_name,
                    $p->name_for_certificate,
                    $p->gender ?? '',
                    $p->birth_place ?? '',
                    $p->birth_date ? \Carbon\Carbon::parse($p->birth_date)->format('d/m/Y') : '',
                    $p->age ?? '',
                    $p->email,
                    $p->whatsapp,
                    $p->domicile ?? '',
                    $p->institution_name ?? '',
                    $p->institution_level ?? '',
                    $p->institution_city ?? '',
                    $p->role_in_institution ?? '',
                    $p->skill_to_improve ?? '',
                    $p->had_previous_training ? 'Pernah' : 'Belum',
                    $p->registration_type,
                    $p->collective_count ?? '',
                    $p->collective_coordinator ?? '',
                    $p->bundle ? $p->bundle->name : ($p->bundle_name ?? ''),
                    $p->referral_code ?? '',
                    $p->referral ? $p->referral->partner_name : '',
                    $p->payment_sender_name ?? '',
                    $p->payment_date ? \Carbon\Carbon::parse($p->payment_date)->format('d/m/Y') : '',
                    'Rp' . number_format($p->original_price, 0, ',', '.'),
                    $p->discount_amount > 0 ? 'Rp' . number_format($p->discount_amount, 0, ',', '.') : '0',
                    'Rp' . number_format($p->final_price, 0, ',', '.'),
                    $p->needs_invoice ? 'Ya' : 'Tidak',
                    $p->invoice_name ?? '',
                    $p->status_label,
                    $p->admin_note ?? '',
                    $p->created_at->format('d/m/Y H:i'),
                ];

                foreach ($questions as $q) {
                    $answer = $p->answers->firstWhere('question_id', $q->id);
                    $row[]  = $answer ? $answer->answer : '';
                }

                fputcsv($out, $row);

                if ($p->registration_type === 'kolektif' && $p->subParticipants->count() > 0) {
                    foreach ($p->subParticipants as $sub) {
                        $subRow = [
                            '  └ ' . $p->registration_code,
                            'Peserta Kolektif',
                            $sub->full_name,
                            $sub->name_for_certificate,
                            $sub->gender ?? '',
                            $sub->birth_place ?? '',
                            $sub->birth_date ? \Carbon\Carbon::parse($sub->birth_date)->format('d/m/Y') : '',
                            $sub->age ?? '',
                            $sub->email ?? '',
                            $sub->whatsapp ?? '',
                            $sub->domicile ?? ($p->domicile ?? ''),
                            $sub->institution_name ?? ($p->institution_name ?? ''),
                            $sub->institution_level ?? ($p->institution_level ?? ''),
                            $sub->institution_city ?? ($p->institution_city ?? ''),
                            $sub->role_in_institution ?? '',
                            $sub->skill_to_improve ?? '',
                            !is_null($sub->had_previous_training) ? ($sub->had_previous_training ? 'Pernah' : 'Belum') : '',
                            'Kolektif',
                            '',
                            $p->full_name . ' (' . $p->registration_code . ')',
                            $p->bundle ? $p->bundle->name : ($p->bundle_name ?? ''),
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $p->status_label,
                            $sub->certificate_file ? 'Sertifikat diupload' : '',
                            $sub->created_at ? $sub->created_at->format('d/m/Y H:i') : '',
                        ];

                        // Empty cells for dynamic questions for sub-participant
                        foreach ($questions as $q) {
                            $subRow[] = '';
                        }

                        fputcsv($out, $subRow);
                    }
                }
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy($pelatihanId, $participantId)
    {
        $participant = PelatihanParticipant::where('pelatihan_id', $pelatihanId)->findOrFail($participantId);

        if ($participant->status === 'approved' && $participant->referral_id) {
            $participant->referral->decrement('used_count');
        }

        if ($participant->payment_proof) {
            Storage::disk('local')->delete('public/payment_proofs/' . $participant->payment_proof);
        }
        if ($participant->certificate_file) {
            Storage::disk('local')->delete('public/certificates/' . $participant->certificate_file);
        }

        foreach ($participant->subParticipants as $sub) {
            if ($sub->certificate_file) {
                Storage::disk('local')->delete('public/certificates/' . $sub->certificate_file);
            }
        }

        $participant->delete();
        return response()->json(['status' => 'success']);
    }

    protected function sendNotification(PelatihanParticipant $participant, string $type): void
    {
        $waGroupLink = config('services.pelatihan.wa_group_link', '');
        $pelatihan   = $participant->pelatihan;

        $waMsg = '';

        if ($type === 'approved') {
            $waMsg  = "Halo {$participant->name_for_certificate} 👋\n\n";
            $waMsg .= "✅ *Pendaftaran Anda DITERIMA!*\n";
            $waMsg .= "Pelatihan: *{$pelatihan->title}*\n";
            if ($pelatihan->batch) $waMsg .= "Batch: {$pelatihan->batch}\n";
            $waMsg .= "Kode Registrasi: *{$participant->registration_code}*\n\n";
            if ($waGroupLink) {
                $waMsg .= "Silakan bergabung ke Grup WhatsApp peserta:\n{$waGroupLink}\n\n";
            }
            $waMsg .= "Sampai bertemu di pelatihan! 🎓\n— Tim Jatidiri";

        } elseif ($type === 'rejected') {
            $waMsg  = "Halo {$participant->name_for_certificate},\n\n";
            $waMsg .= "⚠️ Kami mohon maaf, pendaftaran Anda untuk *{$pelatihan->title}* tidak dapat kami proses.\n";
            if ($participant->admin_note) {
                $waMsg .= "Keterangan: {$participant->admin_note}\n";
            }
            $contact = $pelatihan->whatsapp_contact ?? 'Admin';
            $waMsg .= "\nUntuk informasi lebih lanjut, silakan hubungi admin di {$contact}\n— Tim Jatidiri";

        } else {
            $waMsg  = "Halo {$participant->name_for_certificate},\n\n";
            $waMsg .= "📋 Status pendaftaran Anda untuk *{$pelatihan->title}* telah diperbarui menjadi: *{$participant->status_label}*\n";
            if ($participant->admin_note) {
                $waMsg .= "Catatan: {$participant->admin_note}\n";
            }
            if ($participant->status === 'approved' && $waGroupLink) {
                $waMsg .= "\nBergabung ke Grup WhatsApp:\n{$waGroupLink}\n";
            }
            $waMsg .= "\n— Tim Jatidiri";
        }

        // 1. Kirim Email (terisolasi dalam try-catch)
        if (!empty($participant->email)) {
            try {
                if ($type === 'approved') {
                    Mail::to($participant->email)->send(new PelatihanParticipantApprovedMail($participant));
                } elseif ($type === 'rejected') {
                    Mail::to($participant->email)->send(new PelatihanParticipantRejectedMail($participant));
                } else {
                    Mail::to($participant->email)->send(new PelatihanStatusUpdatedMail($participant));
                }
                \Illuminate\Support\Facades\Log::info("Pelatihan email sent to {$participant->email} ({$type})");
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Pelatihan email notification failed for {$participant->email}: " . $e->getMessage());
            }
        }

        // 2. Kirim WhatsApp via Watzap (terisolasi dalam try-catch)
        if (!empty($participant->whatsapp) && !empty($waMsg)) {
            try {
                $sent = $this->watzap->send($participant->whatsapp, $waMsg);
                if ($sent) {
                    \Illuminate\Support\Facades\Log::info("Pelatihan WhatsApp sent to {$participant->whatsapp} ({$type})");
                } else {
                    \Illuminate\Support\Facades\Log::warning("Pelatihan WhatsApp failed to send to {$participant->whatsapp}");
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Pelatihan WhatsApp notification exception for {$participant->whatsapp}: " . $e->getMessage());
            }
        }
    }
}
