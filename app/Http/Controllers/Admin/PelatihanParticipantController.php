<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\PelatihanParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PelatihanParticipantController extends Controller
{
    public function index(Request $request, $pelatihanId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        $query = PelatihanParticipant::with('referral')
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
        $participant = PelatihanParticipant::with(['answers.question', 'referral'])
            ->where('pelatihan_id', $pelatihanId)
            ->findOrFail($participantId);
        return view('admin.pelatihan.participant.show', compact('pelatihan', 'participant'));
    }

    public function approve(Request $request, $pelatihanId, $participantId)
    {
        $participant = PelatihanParticipant::where('pelatihan_id', $pelatihanId)->findOrFail($participantId);
        $participant->update([
            'status'     => 'approved',
            'admin_note' => $request->admin_note,
        ]);

        if ($participant->referral_id) {
            $participant->referral->increment('used_count');
        }

        return redirect()->back()->with(['success' => 'Peserta berhasil disetujui!']);
    }

    public function reject(Request $request, $pelatihanId, $participantId)
    {
        $participant = PelatihanParticipant::where('pelatihan_id', $pelatihanId)->findOrFail($participantId);
        $participant->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
        ]);
        return redirect()->back()->with(['success' => 'Peserta berhasil ditolak!']);
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

    public function destroy($pelatihanId, $participantId)
    {
        $participant = PelatihanParticipant::where('pelatihan_id', $pelatihanId)->findOrFail($participantId);
        if ($participant->payment_proof) {
            Storage::disk('local')->delete('public/payment_proofs/' . $participant->payment_proof);
        }
        if ($participant->certificate_file) {
            Storage::disk('local')->delete('public/certificates/' . $participant->certificate_file);
        }
        $participant->delete();
        return response()->json(['status' => 'success']);
    }
}
