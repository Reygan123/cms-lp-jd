<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProposalRequest;
use App\Services\WatzapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProposalAPIController extends Controller
{
    protected WatzapService $watzapService;

    public function __construct(WatzapService $watzapService)
    {
        $this->watzapService = $watzapService;
    }

    /**
     * Store proposal lead request submitted by user/school PIC from the Landing Page
     */
    public function requestProposal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'institution_type' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'pic_name' => 'required|string|max:150',
            'pic_title' => 'nullable|string|max:100',
            'pic_phone' => 'required|string|max:30',
            'pic_email' => 'required|email|max:150',
            'target_audience' => 'nullable|string|max:100',
            'estimated_participants' => 'nullable|integer|min:1',
            'test_needs' => 'nullable|array',
            'package_type' => 'nullable|string|max:50',
            'special_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Terdapat kesalahan pada data yang Anda masukkan.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $validator->validated();
            $data['source'] = 'web_lead';
            $data['status'] = 'pending';
            $data['institution_type'] = $data['institution_type'] ?? 'sma';
            $data['package_type'] = $data['package_type'] ?? 'school_advance';
            $data['proposal_number'] = ProposalRequest::generateNextProposalNumber();

            $priceMap = [
                // Jatidiri Sekolah
                'school_starter' => 35000,
                'school_advance' => 145000,
                'school_ultimate' => 245000,
                'starter' => 35000,
                'advance' => 145000,
                'ultimate' => 245000,

                // Jatidiri Kampus
                'campus_efisien' => 75000,
                'campus_komprehensif' => 150000,
                'campus_pmb_seleksi' => 250000,

                // Jatidiri Corporate
                'corp_basic' => 350000,
                'corp_professional' => 650000,
                'corp_leader' => 1200000,
                'corp_wellness' => 250000,

                // Custom
                'custom' => 145000,
            ];
            $data['price_per_participant'] = $priceMap[$data['package_type']] ?? 145000;
            $participants = $data['estimated_participants'] ?? 100;
            $data['total_estimated_budget'] = $data['price_per_participant'] * $participants;

            $proposal = ProposalRequest::create($data);

            // Send notification to Admin via WhatsApp
            $adminPhone = config('services.proposal.admin_wa', '081234567890');
            $waMsg = "🔔 *PERMOHONAN PROPOSAL JATIDIRI BARU (WEB LEAD)*\n\n"
                   . "• *Sekolah/Mitra:* {$proposal->school_name}\n"
                   . "• *PIC:* {$proposal->pic_name} ({$proposal->pic_title})\n"
                   . "• *No. WA:* {$proposal->pic_phone}\n"
                   . "• *Email:* {$proposal->pic_email}\n"
                   . "• *Paket:* " . strtoupper($proposal->package_type) . " ({$participants} Peserta)\n"
                   . "• *Catatan:* " . ($proposal->special_notes ?: '-') . "\n\n"
                   . "👉 Buka CMS untuk tinjau & generate proposal:\n"
                   . url('/admin/proposal/' . $proposal->id);

            $this->watzapService->send($adminPhone, $waMsg);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan proposal berhasil diajukan! Tim konsultan Jatidiri.app akan segera menyiapkan penawaran resmi untuk institusi Anda.',
                'data' => [
                    'id' => $proposal->id,
                    'proposal_number' => $proposal->proposal_number,
                    'school_name' => $proposal->school_name,
                    'pic_name' => $proposal->pic_name,
                ]
            ], 201);

        } catch (\Throwable $e) {
            Log::error('Error submitting proposal request: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kendala pada sistem saat memproses permohonan. Silakan coba beberapa saat lagi atau hubungi kami via WhatsApp.',
            ], 500);
        }
    }
}
