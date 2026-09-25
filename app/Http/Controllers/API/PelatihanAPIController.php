<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\PelatihanBundle;
use App\Models\PelatihanParticipant;
use App\Models\PelatihanSubParticipant;
use App\Models\PelatihanReferral;
use App\Models\PelatihanAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelatihanAPIController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::whereIn('status', ['active', 'Active', 'aktif', 'Aktif'])
            ->with(['bundles', 'participants.bundle', 'participants.subParticipants'])
            ->latest()
            ->get()
            ->values()
            ->map(function ($p) {
                return [
                    'id'                => $p->id,
                    'title'             => $p->title,
                    'slug'              => $p->slug,
                    'batch'             => $p->batch,
                    'description'       => $p->description,
                    'start_date'        => $p->start_date,
                    'end_date'          => $p->end_date,
                    'start_time'        => $p->start_time,
                    'end_time'          => $p->end_time,
                    'location'          => $p->location,
                    'price'             => $p->price,
                    'quota'             => $p->quota,
                    'quota_remaining'   => $p->quota_remaining,
                    'participants_count'=> $p->used_quota,
                    'image'             => $p->image ? asset('storage/pelatihans/' . $p->image) : null,
                    'whatsapp_contact'  => $p->whatsapp_contact,
                    'email_contact'     => $p->email_contact,
                    'status'            => $p->status,
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data'    => $pelatihans,
        ]);
    }

    public function show($slug)
    {
        $cleanSlug = trim(urldecode($slug));
        $pelatihan = Pelatihan::with(['questions', 'bundles', 'participants.bundle', 'participants.subParticipants'])
            ->where(function ($query) use ($cleanSlug) {
                $query->where('slug', $cleanSlug)
                      ->orWhere('id', $cleanSlug);
                if (preg_match('/-(\d+)$/', $cleanSlug, $matches)) {
                    $query->orWhere('id', $matches[1]);
                }
            })
            ->whereIn('status', ['active', 'Active', 'aktif', 'Aktif', 'closed'])
            ->first();

        if (!$pelatihan) {
            return response()->json(['success' => false, 'message' => 'Pelatihan tidak ditemukan.'], 404);
        }

        $questions = $pelatihan->questions->map(function ($q) {
            return [
                'id'                      => $q->id,
                'question'                => $q->question,
                'type'                    => $q->type,
                'options'                 => $q->options,
                'is_required'             => $q->is_required,
                'sort_order'              => $q->sort_order,
                'conditional_on_question' => $q->conditional_on_question,
                'conditional_on_value'    => $q->conditional_on_value,
            ];
        });

        $bundles = $pelatihan->bundles->map(function ($b) {
            return [
                'id'              => $b->id,
                'name'            => $b->name,
                'person_count'    => $b->person_count,
                'bundle_price'    => (float) $b->bundle_price,
                'price_per_person'=> $b->price_per_person,
                'description'     => $b->description,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'id'               => $pelatihan->id,
                'title'            => $pelatihan->title,
                'slug'             => $pelatihan->slug,
                'batch'            => $pelatihan->batch,
                'description'      => $pelatihan->description,
                'start_date'       => $pelatihan->start_date,
                'end_date'         => $pelatihan->end_date,
                'start_time'       => $pelatihan->start_time,
                'end_time'         => $pelatihan->end_time,
                'location'         => $pelatihan->location,
                'price'            => $pelatihan->price,
                'bank_name'        => $pelatihan->bank_name,
                'bank_account'     => $pelatihan->bank_account,
                'bank_holder'      => $pelatihan->bank_holder,
                'quota'            => $pelatihan->quota,
                'quota_remaining'  => $pelatihan->quota_remaining,
                'participants_count'=> $pelatihan->used_quota,
                'image'            => $pelatihan->image ? asset('storage/pelatihans/' . $pelatihan->image) : null,
                'whatsapp_contact' => $pelatihan->whatsapp_contact,
                'email_contact'    => $pelatihan->email_contact,
                'questions'        => $questions,
                'bundles'          => $bundles,
            ],
        ]);
    }

    public function checkReferral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'             => 'required|string',
            'pelatihan_id'     => 'required|exists:pelatihans,id',
            'bundle_id'        => 'nullable|exists:pelatihan_bundles,id',
            'collective_count' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $referral = PelatihanReferral::where('code', strtoupper(trim($request->code)))
            ->where('pelatihan_id', $request->pelatihan_id)
            ->first();

        if (!$referral) {
            return response()->json(['success' => false, 'message' => 'Kode referral tidak ditemukan.'], 404);
        }

        if (!$referral->isAvailable()) {
            return response()->json(['success' => false, 'message' => 'Kode referral sudah tidak aktif atau habis digunakan.'], 422);
        }

        $pelatihan     = Pelatihan::find($request->pelatihan_id);
        $count         = max(1, (int) $request->input('collective_count', 1));
        $basePrice     = (float) $pelatihan->price;

        if ($request->bundle_id) {
            $bundle    = PelatihanBundle::find($request->bundle_id);
            $basePrice = $bundle ? (float) $bundle->bundle_price : $basePrice;
        } else {
            $basePrice = $basePrice * $count;
        }

        $discount   = $referral->calculateDiscount($basePrice);
        $finalPrice = max(0, $basePrice - $discount);

        return response()->json([
            'success' => true,
            'data'    => [
                'code'            => $referral->code,
                'partner_name'    => $referral->partner_name,
                'discount_type'   => $referral->discount_type,
                'discount_value'  => $referral->discount_value,
                'discount_amount' => $discount,
                'original_price'  => $basePrice,
                'final_price'     => $finalPrice,
            ],
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelatihan_id'              => 'required|exists:pelatihans,id',
            'bundle_id'                 => 'nullable|exists:pelatihan_bundles,id',
            'full_name'                 => 'required|string|max:255',
            'name_for_certificate'      => 'required|string|max:255',
            'gender'                    => 'nullable|string|max:20',
            'birth_place'               => 'nullable|string|max:100',
            'birth_date'                => 'nullable|date',
            'age'                       => 'nullable|integer|min:1|max:120',
            'email'                     => 'required|email|max:255',
            'whatsapp'                  => 'required|string|max:20',
            'domicile'                  => 'required|string',
            'institution_name'          => 'required|string|max:255',
            'institution_level'         => 'required',
            'institution_city'          => 'nullable|string|max:100',
            'role_in_institution'       => 'required|string|max:255',
            'skill_to_improve'          => 'nullable|string',
            'had_previous_training'     => 'required|boolean',
            'registration_type'         => 'required|in:individu,kolektif',
            'collective_count'          => 'nullable|integer|min:1',
            'collective_coordinator'    => 'nullable|string|max:255',
            'sub_participants'          => 'nullable|array',
            'sub_participants.*.full_name'             => 'required_with:sub_participants|string|max:255',
            'sub_participants.*.name_for_certificate'  => 'required_with:sub_participants|string|max:255',
            'sub_participants.*.gender'                => 'nullable|string|max:20',
            'sub_participants.*.birth_place'           => 'nullable|string|max:100',
            'sub_participants.*.birth_date'            => 'nullable|date',
            'sub_participants.*.age'                   => 'nullable|integer|min:1|max:120',
            'sub_participants.*.email'                 => 'nullable|email|max:255',
            'sub_participants.*.whatsapp'              => 'nullable|string|max:20',
            'sub_participants.*.domicile'              => 'nullable|string',
            'sub_participants.*.institution_name'      => 'nullable|string|max:255',
            'sub_participants.*.institution_level'     => 'nullable',
            'sub_participants.*.institution_city'      => 'nullable|string|max:100',
            'sub_participants.*.role_in_institution'   => 'nullable|string|max:255',
            'sub_participants.*.skill_to_improve'      => 'nullable|string',
            'sub_participants.*.had_previous_training' => 'nullable|boolean',
            'referral_code'             => 'nullable|string|max:50',
            'referral_giver_name'       => 'nullable|string|max:255',
            'payment_sender_name'       => 'nullable|string|max:255',
            'payment_date'              => 'nullable|date',
            'payment_proof'             => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'needs_invoice'             => 'required|boolean',
            'invoice_name'              => 'nullable|string|max:255',
            'answers'                   => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $pelatihan = Pelatihan::findOrFail($request->pelatihan_id);

        if ($pelatihan->status !== 'active') {
            return response()->json(['success' => false, 'message' => 'Pendaftaran pelatihan ini sudah ditutup.'], 422);
        }

        $bundle         = null;
        $bundleName     = null;
        $requestedSeats = 1;

        if ($request->bundle_id) {
            $bundle = PelatihanBundle::where('pelatihan_id', $pelatihan->id)->where('is_active', true)->find($request->bundle_id);
            if ($bundle) {
                $bundleName     = $bundle->name;
                $originalPrice  = (float) $bundle->bundle_price;
                $requestedSeats = max((int) $bundle->person_count, (int) ($request->collective_count ?: 1));
            } else {
                $originalPrice  = (float) $pelatihan->price;
            }
        } elseif ($request->registration_type === 'kolektif') {
            $subCount       = is_array($request->sub_participants) ? count($request->sub_participants) : 0;
            $requestedSeats = max((int) ($request->collective_count ?: 1), $subCount + 1);
            $originalPrice  = (float) $pelatihan->price * $requestedSeats;
        } else {
            $originalPrice  = (float) $pelatihan->price;
        }

        if ($pelatihan->quota !== null && $pelatihan->quota_remaining !== null) {
            if ($pelatihan->quota_remaining <= 0) {
                return response()->json(['success' => false, 'message' => 'Maaf, kuota pelatihan ini sudah penuh.'], 422);
            }
            if ($pelatihan->quota_remaining < $requestedSeats) {
                return response()->json([
                    'success' => false,
                    'message' => "Maaf, sisa kuota yang tersedia hanya {$pelatihan->quota_remaining} kursi, tidak mencukupi untuk {$requestedSeats} orang peserta."
                ], 422);
            }
        }

        $referralId     = null;
        $discountAmount = 0;
        $finalPrice     = $originalPrice;

        if ($request->referral_code) {
            $referral = PelatihanReferral::where('code', strtoupper(trim($request->referral_code)))
                ->where('pelatihan_id', $pelatihan->id)
                ->first();

            if ($referral && $referral->isAvailable()) {
                $discountAmount = $referral->calculateDiscount($originalPrice);
                $finalPrice     = max(0, $originalPrice - $discountAmount);
                $referralId     = $referral->id;
            }
        }

        $registrationCode = 'JD-' . strtoupper(substr($pelatihan->batch ?? 'BTH', 0, 3)) . '-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

        $paymentProofName = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $file->storeAs('public/payment_proofs', $file->hashName());
            $paymentProofName = $file->hashName();
        }

        // Auto calculate age if birth_date provided and age empty
        $age = $request->age;
        if (empty($age) && $request->filled('birth_date')) {
            try {
                $age = Carbon::parse($request->birth_date)->age;
            } catch (\Throwable $e) {}
        }

        $participant = PelatihanParticipant::create([
            'pelatihan_id'          => $pelatihan->id,
            'referral_id'           => $referralId,
            'bundle_id'             => $bundle ? $bundle->id : null,
            'bundle_name'           => $bundleName,
            'registration_code'     => $registrationCode,
            'referral_code'         => $request->referral_code ? strtoupper(trim($request->referral_code)) : null,
            'referral_giver_name'   => $request->referral_giver_name,
            'full_name'             => $request->full_name,
            'name_for_certificate'  => $request->name_for_certificate,
            'gender'                => $request->gender,
            'birth_place'           => $request->birth_place,
            'birth_date'            => $request->birth_date,
            'age'                   => $age,
            'email'                 => $request->email,
            'whatsapp'              => $request->whatsapp,
            'domicile'              => $request->domicile,
            'institution_level'     => $request->institution_level,
            'institution_name'      => $request->institution_name,
            'institution_city'      => $request->institution_city,
            'role_in_institution'   => $request->role_in_institution,
            'skill_to_improve'      => $request->skill_to_improve,
            'had_previous_training' => $request->had_previous_training,
            'registration_type'     => ($bundle && (int)$bundle->person_count > 1) ? 'kolektif' : $request->registration_type,
            'collective_count'      => $requestedSeats,
            'collective_coordinator'=> $request->collective_coordinator,
            'payment_sender_name'   => $request->payment_sender_name,
            'payment_date'          => $request->payment_date,
            'payment_proof'         => $paymentProofName,
            'needs_invoice'         => $request->needs_invoice,
            'invoice_name'          => $request->invoice_name,
            'original_price'        => $originalPrice,
            'discount_amount'       => $discountAmount,
            'final_price'           => $finalPrice,
            'status'                => 'pending',
        ]);

        if (($request->registration_type === 'kolektif' || $bundle) && $request->has('sub_participants') && is_array($request->sub_participants)) {
            foreach ($request->sub_participants as $sub) {
                $subAge = $sub['age'] ?? null;
                if (empty($subAge) && !empty($sub['birth_date'])) {
                    try {
                        $subAge = Carbon::parse($sub['birth_date'])->age;
                    } catch (\Throwable $e) {}
                }

                PelatihanSubParticipant::create([
                    'participant_id'        => $participant->id,
                    'full_name'             => $sub['full_name'],
                    'name_for_certificate'  => $sub['name_for_certificate'],
                    'gender'                => $sub['gender'] ?? null,
                    'birth_place'           => $sub['birth_place'] ?? null,
                    'birth_date'            => $sub['birth_date'] ?? null,
                    'age'                   => $subAge,
                    'email'                 => $sub['email'] ?? null,
                    'whatsapp'              => $sub['whatsapp'] ?? null,
                    'domicile'              => $sub['domicile'] ?? null,
                    'institution_name'      => $sub['institution_name'] ?? ($participant->institution_name ?? null),
                    'institution_level'     => $sub['institution_level'] ?? ($participant->institution_level ?? null),
                    'institution_city'      => $sub['institution_city'] ?? ($participant->institution_city ?? null),
                    'role_in_institution'   => $sub['role_in_institution'] ?? null,
                    'skill_to_improve'      => $sub['skill_to_improve'] ?? null,
                    'had_previous_training' => $sub['had_previous_training'] ?? null,
                ]);
            }
        }

        if ($request->has('answers') && is_array($request->answers)) {
            foreach ($request->answers as $questionId => $answerValue) {
                if (is_array($answerValue)) {
                    $answerValue = implode(', ', $answerValue);
                }
                PelatihanAnswer::create([
                    'participant_id' => $participant->id,
                    'question_id'    => $questionId,
                    'answer'         => $answerValue,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil! Kode registrasi Anda: ' . $registrationCode . '. Admin akan menghubungi Anda untuk konfirmasi.',
            'data'    => [
                'registration_code' => $registrationCode,
                'full_name'         => $participant->full_name,
                'email'             => $participant->email,
                'original_price'    => $originalPrice,
                'discount_amount'   => $discountAmount,
                'final_price'       => $finalPrice,
                'bundle'            => $bundleName,
                'status'            => 'pending',
            ],
        ], 201);
    }

    public function checkStatus($registrationCode)
    {
        $participant = PelatihanParticipant::with('pelatihan')
            ->where('registration_code', trim($registrationCode))
            ->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'message' => 'Kode pendaftaran tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'registration_code'  => $participant->registration_code,
                'full_name'          => $participant->full_name,
                'email'              => $participant->email,
                'event'              => $participant->pelatihan ? $participant->pelatihan->title : '-',
                'original_price'     => (float) $participant->original_price,
                'final_price'        => (float) $participant->final_price,
                'discount_amount'    => (float) $participant->discount_amount,
                'bundle'             => $participant->bundle_name,
                'status'             => $participant->status,
                'admin_note'         => $participant->admin_note,
                'certificate_file'   => $participant->certificate_file ? asset('storage/certificates/' . $participant->certificate_file) : null,
                'certificate_sent_at'=> $participant->certificate_sent_at,
                'sertifikat_dikirim' => !empty($participant->certificate_sent_at),
            ],
        ]);
    }
}
