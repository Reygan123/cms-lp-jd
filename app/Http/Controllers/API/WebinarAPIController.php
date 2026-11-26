<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WebinarRegistration;
use App\Services\DuitkuService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WebinarAPIController extends Controller
{
    protected DuitkuService $duitkuService;

    public function __construct(DuitkuService $duitkuService)
    {
        $this->duitkuService = $duitkuService;
    }

    /**
     * Register participant for a webinar episode.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'episode_id'      => 'required|string',
            'full_name'       => 'required|string|max:255',
            'whatsapp'        => 'required|string|max:30',
            'email'           => 'required|email|max:255',
            'pricing_type'    => 'required|string|in:free_donation,paid,bundling,donasi',
            'transfer_amount' => 'nullable|numeric|min:0',
            'donation_amount' => 'nullable|numeric|min:0',
            'payment_method'  => 'nullable|string',
            'ig_username'     => 'nullable|string|max:100',
            'ig_proof_file'   => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi formulir gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $pricingType = $request->pricing_type;
        $donationAmount = (float) ($request->donation_amount ?? 0);
        $transferAmount = (float) ($request->transfer_amount ?? 0);
        $totalAmount = $transferAmount > 0 ? $transferAmount : $donationAmount;

        // If free_donation with 0 amount, IG proof is mandatory
        if ($pricingType === 'free_donation' && $totalAmount <= 0) {
            if (!$request->hasFile('ig_proof_file') && empty($request->ig_proof_preview)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Untuk pendaftaran gratis / donasi Rp 0, wajib mengunggah screenshot bukti follow Instagram @jatidiri.app.',
                ], 422);
            }
        }

        // Handle IG proof upload
        $igProofPath = null;
        if ($request->hasFile('ig_proof_file')) {
            $file = $request->file('ig_proof_file');
            $filename = 'ig_proof_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/webinar_ig_proofs', $filename);
            $igProofPath = asset('storage/' . str_replace('public/', '', $path));
        } elseif (!empty($request->ig_proof_preview)) {
            $igProofPath = $request->ig_proof_preview;
        }

        // Generate Order ID
        $orderId = 'JD-WEB-' . strtoupper(Str::random(6)) . rand(10, 99);

        // Determine Episode Title
        $episodeTitles = [
            'ep-1'     => 'Ep 1: Mengurai Overthinking & Stress',
            'ep-2'     => 'Ep 2: Career & Talent Mapping',
            'ep-3'     => 'Ep 3: Emotional Resilience & Self-Worth',
            'all-pass' => 'All-Access Chapter Pass (Semua Episode)',
        ];
        $episodeTitle = $episodeTitles[$request->episode_id] ?? ($request->episode_title ?: 'Webinar Jatidiri');

        $isFree = ($totalAmount <= 0);
        $status = $isFree ? 'PAID' : 'PENDING';
        $expiryTime = Carbon::now()->addHours(24);

        $duitkuRef = null;
        $paymentUrl = null;
        $vaNumber = null;
        $qrString = null;

        // If paid, request Duitku inquiry
        if (!$isFree) {
            $paymentMethod = $request->payment_method ?: 'QRIS';
            $customer = [
                'name'  => $request->full_name,
                'email' => $request->email,
                'phone' => $request->whatsapp,
            ];

            $duitkuRes = $this->duitkuService->createInquiry(
                $orderId,
                (int) $totalAmount,
                $paymentMethod,
                $episodeTitle,
                $customer,
                [
                    'episode_id' => $request->episode_id,
                    'email'      => $request->email,
                    'whatsapp'   => $request->whatsapp,
                ]
            );

            if (!empty($duitkuRes['success'])) {
                $duitkuRef  = $duitkuRes['reference'];
                $paymentUrl = $duitkuRes['payment_url'];
                $vaNumber   = $duitkuRes['va_number'];
                $qrString   = $duitkuRes['qr_string'];
            } else {
                Log::warning('Duitku Inquiry returned error, using fallback VA/QRIS:', ['orderId' => $orderId, 'res' => $duitkuRes]);
                // If Duitku inquiry fails, generate fallback virtual account so user isn't stuck
                if ($paymentMethod === 'QRIS') {
                    $qrString = '00020101021226670016ID.CO.DUITKU.WWW01189360091800000000005204581253033605802ID5912JATIDIRI APP6007BANDUNG62070703A016304' . strtoupper(substr(md5($orderId), 0, 4));
                } else {
                    $prefix = ($paymentMethod === 'BCA_VA') ? '8808' : (($paymentMethod === 'MANDIRI_VA') ? '8870' : '8810');
                    $vaNumber = $prefix . rand(1000000000, 9999999999);
                }
            }
        }

        // Save to Database
        $registration = WebinarRegistration::create([
            'order_id'           => $orderId,
            'chapter_id'         => $request->chapter_id ?: 'chapter-1',
            'episode_id'         => $request->episode_id,
            'episode_title'      => $episodeTitle,
            'pricing_type'       => $pricingType,
            'full_name'          => $request->full_name,
            'whatsapp'           => $request->whatsapp,
            'email'              => $request->email,
            'category'           => $request->category ?: 'Umum',
            'institution'        => $request->institution ?: '-',
            'biggest_challenge'  => $request->biggest_challenge ?: '-',
            'speaker_question'   => $request->speaker_question ?: '-',
            'ig_username'        => $request->ig_username ?: null,
            'ig_proof_file'      => $igProofPath,
            'donation_amount'    => $donationAmount,
            'total_amount'       => $totalAmount,
            'payment_channel'    => $request->payment_method ?: ($isFree ? 'FREE' : 'QRIS'),
            'payment_status'     => $status,
            'duitku_reference'   => $duitkuRef,
            'duitku_payment_url' => $paymentUrl,
            'va_number'          => $vaNumber,
            'qr_string'          => $qrString,
            'paid_at'            => $isFree ? Carbon::now() : null,
            'expiry_time'        => $expiryTime,
        ]);

        return response()->json([
            'success' => true,
            'message' => $isFree ? 'Pendaftaran berhasil dikonfirmasi!' : 'Invoice pembayaran berhasil dibuat.',
            'data'    => [
                'order_id'           => $registration->order_id,
                'episode_id'         => $registration->episode_id,
                'episode_title'      => $registration->episode_title,
                'pricing_type'       => $registration->pricing_type,
                'full_name'          => $registration->full_name,
                'email'              => $registration->email,
                'whatsapp'           => $registration->whatsapp,
                'total_amount'       => (float) $registration->total_amount,
                'payment_status'     => $registration->payment_status,
                'payment_channel'    => $registration->payment_channel,
                'va_number'          => $registration->va_number,
                'qr_string'          => $registration->qr_string,
                'duitku_payment_url' => $registration->duitku_payment_url,
                'duitku_reference'   => $registration->duitku_reference,
                'expiry_time'        => $registration->expiry_time ? $registration->expiry_time->toIso8601String() : null,
                'wa_group_url'       => 'https://chat.whatsapp.com/IadppAYsFzL9Bcqm4WzwgA',
                'ig_proof_url'       => $registration->ig_proof_file,
            ],
        ]);
    }

    /**
     * Check transaction status on Duitku & update local state.
     */
    public function checkStatus($orderId)
    {
        $registration = WebinarRegistration::where('order_id', $orderId)->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan.',
            ], 404);
        }

        // If already paid, return directly
        if ($registration->payment_status === 'PAID') {
            return response()->json([
                'success' => true,
                'data'    => $registration,
            ]);
        }

        // Check real-time with Duitku
        $statusCheck = $this->duitkuService->checkTransactionStatus($orderId);

        if (!empty($statusCheck['is_paid'])) {
            $registration->update([
                'payment_status' => 'PAID',
                'paid_at'        => Carbon::now(),
            ]);
        } elseif (!empty($statusCheck['is_expired'])) {
            $registration->update([
                'payment_status' => 'EXPIRED',
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => $registration->fresh(),
        ]);
    }

    /**
     * Webhook callback listener for Duitku notifications.
     */
    public function callback(Request $request)
    {
        $params = $request->all();
        Log::info('Duitku Callback Received:', $params);

        if (!$this->duitkuService->validateCallback($params)) {
            Log::warning('Duitku Callback Invalid Signature:', $params);
            return response('Invalid Signature', 400);
        }

        $merchantOrderId = $params['merchantOrderId'] ?? null;
        $resultCode      = $params['resultCode'] ?? null;

        if ($merchantOrderId && $resultCode === '00') {
            $registration = WebinarRegistration::where('order_id', $merchantOrderId)->first();
            if ($registration) {
                $registration->update([
                    'payment_status' => 'PAID',
                    'paid_at'        => Carbon::now(),
                ]);
                Log::info("Webinar Order {$merchantOrderId} successfully marked as PAID via Callback");
            }
        }

        return response('OK', 200);
    }

    /**
     * Get all webinar transactions for admin dashboard.
     */
    public function getAdminTransactions(Request $request)
    {
        $query = WebinarRegistration::query()->latest();

        if ($request->filled('episode_id')) {
            $query->where('episode_id', $request->episode_id);
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%")
                  ->orWhere('order_id', 'like', "%{$search}%");
            });
        }

        $transactions = $query->get();

        return response()->json([
            'success' => true,
            'data'    => $transactions,
        ]);
    }

    public function getActiveWebinar()
    {
        $webinar = \App\Models\Webinar::with(['episodes' => function ($q) {
            $q->where('status', 'active')->orderBy('sort_order', 'asc');
        }])->where('status', 'active')->first();

        if (!$webinar) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada webinar aktif.',
            ], 404);
        }

        $episodes = $webinar->episodes->map(function ($ep) {
            return [
                'id' => $ep->code,
                'episode_number' => $ep->episode_number,
                'title' => $ep->title,
                '_translation' => $ep->_translation,
                'description' => $ep->description,
                'date_label' => $ep->date_label,
                'time_label' => $ep->time_label,
                'pricing_type' => $ep->pricing_type,
                'price' => (float) $ep->price,
                'original_price' => $ep->original_price ? (float) $ep->original_price : null,
                'requires_ig_proof' => (bool) $ep->requires_ig_proof,
                'assessment_voucher_included' => (bool) $ep->assessment_voucher_included,
                'features' => $ep->features ?: [],
            ];
        })->values()->toArray();

        $episodes[] = [
            'id' => 'all-pass',
            'episode_number' => 0,
            'title' => __('content.all_access_title'),
            'description' => __('content.all_access_description', ['chapter' => $webinar->chapter_number]),
            'date_label' => __('content.all_sessions'),
            'time_label' => __('content.full_schedule'),
            'pricing_type' => 'paid',
            'price' => (float) $webinar->all_access_price,
            'original_price' => $webinar->all_access_original_price ? (float) $webinar->all_access_original_price : null,
            'requires_ig_proof' => false,
            'assessment_voucher_included' => true,
            'features' => [
                __('content.all_episodes', ['chapter' => $webinar->chapter_number]),
                __('content.assessment_voucher'),
                __('content.recordings'),
                __('content.slides'),
                __('content.counseling_priority'),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $webinar->code,
                'chapter_number' => $webinar->chapter_number,
                'title' => $webinar->title,
                '_translation' => $webinar->_translation,
                'description' => $webinar->description,
                'main_speaker' => [
                    'name' => $webinar->speaker_name,
                    'title' => $webinar->speaker_title,
                    'photo' => $webinar->speaker_photo ? asset('storage/' . $webinar->speaker_photo) : null,
                ],
                'all_access_price' => (float) $webinar->all_access_price,
                'all_access_original_price' => (float) $webinar->all_access_original_price,
                'wa_group_url' => $webinar->wa_group_url,
                'episodes' => $episodes,
            ],
        ]);
    }

    public function markPaid($orderId)
    {
        $registration = WebinarRegistration::where('order_id', $orderId)->first();

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        $registration->update([
            'payment_status' => 'PAID',
            'paid_at'        => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status pembayaran berhasil diubah menjadi Lunas (PAID).',
            'data'    => $registration->fresh(),
        ]);
    }
}

