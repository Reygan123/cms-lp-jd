<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\PelatihanParticipant;
use App\Models\PelatihanReferral;
use App\Models\PelatihanAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelatihanAPIController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::where('status', 'active')
            ->withCount('participants')
            ->latest()
            ->get()
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
                    'participants_count'=> $p->participants_count,
                    'image'             => $p->image ? asset('storage/pelatihans/' . $p->image) : null,
                    'whatsapp_contact'  => $p->whatsapp_contact,
                    'email_contact'     => $p->email_contact,
                    'status'            => $p->status,
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $pelatihans,
        ]);
    }

    public function show($slug)
    {
        $pelatihan = Pelatihan::with('questions')->where('slug', $slug)->where('status', 'active')->first();

        if (!$pelatihan) {
            return response()->json(['success' => false, 'message' => 'Pelatihan tidak ditemukan.'], 404);
        }

        $questions = $pelatihan->questions->map(function ($q) {
            return [
                'id'                     => $q->id,
                'question'               => $q->question,
                'type'                   => $q->type,
                'options'                => $q->options,
                'is_required'            => $q->is_required,
                'sort_order'             => $q->sort_order,
                'conditional_on_question'=> $q->conditional_on_question,
                'conditional_on_value'   => $q->conditional_on_value,
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
                'image'            => $pelatihan->image ? asset('storage/pelatihans/' . $pelatihan->image) : null,
                'whatsapp_contact' => $pelatihan->whatsapp_contact,
                'email_contact'    => $pelatihan->email_contact,
                'questions'        => $questions,
            ],
        ]);
    }

    public function checkReferral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'        => 'required|string',
            'pelatihan_id'=> 'required|exists:pelatihans,id',
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

        $pelatihan = Pelatihan::find($request->pelatihan_id);
        $discount = $referral->calculateDiscount((float) $pelatihan->price);
        $finalPrice = max(0, (float) $pelatihan->price - $discount);

        return response()->json([
            'success' => true,
            'data'    => [
                'code'           => $referral->code,
                'partner_name'   => $referral->partner_name,
                'discount_type'  => $referral->discount_type,
                'discount_value' => $referral->discount_value,
                'discount_amount'=> $discount,
                'original_price' => $pelatihan->price,
                'final_price'    => $finalPrice,
            ],
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelatihan_id'          => 'required|exists:pelatihans,id',
            'full_name'             => 'required|string|max:255',
            'name_for_certificate'  => 'required|string|max:255',
            'email'                 => 'required|email|max:255',
            'whatsapp'              => 'required|string|max:20',
            'domicile'              => 'required|string',
            'institution_level'     => 'required|string|max:100',
            'institution_name'      => 'required|string|max:255',
            'role_in_institution'   => 'required|string|max:255',
            'skill_to_improve'      => 'nullable|string',
            'had_previous_training' => 'required|boolean',
            'registration_type'     => 'required|in:individu,kolektif',
            'collective_count'      => 'nullable|integer|min:1',
            'collective_coordinator'=> 'nullable|string|max:255',
            'referral_code'         => 'nullable|string|max:50',
            'referral_giver_name'   => 'nullable|string|max:255',
            'payment_sender_name'   => 'nullable|string|max:255',
            'payment_date'          => 'nullable|date',
            'payment_proof'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'needs_invoice'         => 'required|boolean',
            'invoice_name'          => 'nullable|string|max:255',
            'answers'               => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $pelatihan = Pelatihan::findOrFail($request->pelatihan_id);

        if ($pelatihan->status !== 'active') {
            return response()->json(['success' => false, 'message' => 'Pendaftaran pelatihan ini sudah ditutup.'], 422);
        }

        $referralId = null;
        $discountAmount = 0;
        $originalPrice = (float) $pelatihan->price;
        $finalPrice = $originalPrice;

        if ($request->referral_code) {
            $referral = PelatihanReferral::where('code', strtoupper(trim($request->referral_code)))
                ->where('pelatihan_id', $pelatihan->id)
                ->first();

            if ($referral && $referral->isAvailable()) {
                $discountAmount = $referral->calculateDiscount($originalPrice);
                $finalPrice = max(0, $originalPrice - $discountAmount);
                $referralId = $referral->id;
            }
        }

        $registrationCode = 'JD-' . strtoupper(substr($pelatihan->batch ?? 'BTH', 0, 3)) . '-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

        $paymentProofName = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $file->storeAs('public/payment_proofs', $file->hashName());
            $paymentProofName = $file->hashName();
        }

        $participant = PelatihanParticipant::create([
            'pelatihan_id'          => $pelatihan->id,
            'referral_id'           => $referralId,
            'registration_code'     => $registrationCode,
            'referral_code'         => $request->referral_code ? strtoupper(trim($request->referral_code)) : null,
            'referral_giver_name'   => $request->referral_giver_name,
            'full_name'             => $request->full_name,
            'name_for_certificate'  => $request->name_for_certificate,
            'email'                 => $request->email,
            'whatsapp'              => $request->whatsapp,
            'domicile'              => $request->domicile,
            'institution_level'     => $request->institution_level,
            'institution_name'      => $request->institution_name,
            'role_in_institution'   => $request->role_in_institution,
            'skill_to_improve'      => $request->skill_to_improve,
            'had_previous_training' => $request->had_previous_training,
            'registration_type'     => $request->registration_type,
            'collective_count'      => $request->collective_count,
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
            'data' => [
                'registration_code' => $participant->registration_code,
                'full_name'         => $participant->full_name,
                'email'             => $participant->email,
                'event'             => $participant->pelatihan ? $participant->pelatihan->title : '-',
                'original_price'    => (float) $participant->original_price,
                'final_price'       => (float) $participant->final_price,
                'discount_amount'   => (float) $participant->discount_amount,
                'potongan_didapat'  => (float) $participant->discount_amount,
                'status'            => $participant->status,
                'admin_note'        => $participant->admin_note,
                'certificate_file'  => $participant->certificate_file ? asset('storage/certificates/' . $participant->certificate_file) : null,
                'certificate_sent_at'=> $participant->certificate_sent_at,
                'sertifikat_dikirim'=> !empty($participant->certificate_sent_at),
            ],
        ]);
    }
}
