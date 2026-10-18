<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProposalRequest;
use App\Services\GeminiProposalService;
use App\Services\WatzapService;
use App\Mail\ProposalOfferMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProposalController extends Controller
{
    protected GeminiProposalService $geminiService;
    protected WatzapService $watzapService;

    public function __construct(GeminiProposalService $geminiService, WatzapService $watzapService)
    {
        $this->geminiService = $geminiService;
        $this->watzapService = $watzapService;
    }

    /**
     * Display list of proposal requests
     */
    public function index(Request $request)
    {
        $query = ProposalRequest::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('school_name', 'like', "%{$search}%")
                  ->orWhere('pic_name', 'like', "%{$search}%")
                  ->orWhere('proposal_number', 'like', "%{$search}%")
                  ->orWhere('pic_phone', 'like', "%{$search}%");
            });
        }

        $proposals = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => ProposalRequest::count(),
            'pending' => ProposalRequest::where('status', 'pending')->count(),
            'draft' => ProposalRequest::where('status', 'draft_generated')->count(),
            'sent' => ProposalRequest::where('status', 'sent')->count(),
        ];

        return view('admin.proposal.index', compact('proposals', 'stats'));
    }

    /**
     * Show form for creating a new proposal manually by Admin
     */
    public function create()
    {
        $nextProposalNumber = ProposalRequest::generateNextProposalNumber();
        return view('admin.proposal.create', compact('nextProposalNumber'));
    }

    /**
     * Store newly created proposal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'proposal_number' => 'nullable|string|max:50',
            'school_name' => 'required|string|max:255',
            'institution_type' => 'required|string|max:50',
            'city' => 'nullable|string|max:100',
            'pic_name' => 'required|string|max:150',
            'pic_title' => 'nullable|string|max:100',
            'pic_phone' => 'required|string|max:30',
            'pic_email' => 'required|email|max:150',
            'target_audience' => 'nullable|string|max:100',
            'estimated_participants' => 'nullable|integer|min:1',
            'test_needs' => 'nullable|array',
            'package_type' => 'required|string|max:50',
            'price_per_participant' => 'nullable|numeric|min:0',
            'budget_source' => 'nullable|string|max:50',
            'urgency_purpose' => 'nullable|string|max:255',
            'special_notes' => 'nullable|string',
        ]);

        $validated['source'] = 'admin_manual';
        $validated['proposal_number'] = $validated['proposal_number'] ?: ProposalRequest::generateNextProposalNumber();
        
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

        if (empty($validated['price_per_participant'])) {
            $validated['price_per_participant'] = $priceMap[$validated['package_type']] ?? 145000;
        }

        $participants = $validated['estimated_participants'] ?: 100;
        $validated['total_estimated_budget'] = $validated['price_per_participant'] * $participants;

        $proposal = ProposalRequest::create($validated);

        // If admin clicked "Save & Generate AI"
        if ($request->input('action') === 'save_and_generate') {
            return $this->processAiGeneration($proposal);
        }

        return redirect()->route('admin.proposal.index')
            ->with('success', "Permohonan proposal untuk {$proposal->school_name} berhasil disimpan.");
    }

    /**
     * Show proposal workspace / preview
     */
    public function show(ProposalRequest $proposal)
    {
        $content = $proposal->active_content;
        return view('admin.proposal.show', compact('proposal', 'content'));
    }

    /**
     * Edit proposal content workspace
     */
    public function edit(ProposalRequest $proposal)
    {
        $content = $proposal->active_content;
        return view('admin.proposal.edit', compact('proposal', 'content'));
    }

    /**
     * Update proposal details & customized content
     */
    public function update(Request $request, ProposalRequest $proposal)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'pic_name' => 'required|string|max:150',
            'pic_title' => 'nullable|string|max:100',
            'pic_phone' => 'required|string|max:30',
            'pic_email' => 'required|email|max:150',
            'price_per_participant' => 'nullable|numeric|min:0',
            'estimated_participants' => 'nullable|integer|min:1',
            'status' => 'required|string|in:pending,draft_generated,reviewed,sent',
            'custom_content' => 'nullable|array',
        ]);

        $proposal->school_name = $validated['school_name'];
        $proposal->pic_name = $validated['pic_name'];
        $proposal->pic_title = $validated['pic_title'];
        $proposal->pic_phone = $validated['pic_phone'];
        $proposal->pic_email = $validated['pic_email'];
        $proposal->price_per_participant = $validated['price_per_participant'] ?? $proposal->price_per_participant;
        $proposal->estimated_participants = $validated['estimated_participants'] ?? $proposal->estimated_participants;
        $proposal->total_estimated_budget = $proposal->price_per_participant * $proposal->estimated_participants;
        $proposal->status = $validated['status'];

        if ($request->filled('custom_content')) {
            $proposal->customized_content = $request->custom_content;
        }

        $proposal->save();

        return redirect()->route('admin.proposal.show', $proposal->id)
            ->with('success', 'Naskah proposal berhasil diperbarui.');
    }

    /**
     * Trigger AI Generation on an existing proposal
     */
    public function generateAi(ProposalRequest $proposal)
    {
        return $this->processAiGeneration($proposal);
    }

    /**
     * Internal processor for AI generation
     */
    protected function processAiGeneration(ProposalRequest $proposal)
    {
        try {
            $generated = $this->geminiService->generateProposal($proposal);
            $proposal->generated_proposal_data = $generated;
            $proposal->customized_content = null; // reset customized to fresh AI
            $proposal->status = 'draft_generated';
            $proposal->ai_model_used = config('services.gemini.model', 'gemini-2.5-flash');
            $proposal->save();

            return redirect()->route('admin.proposal.edit', $proposal->id)
                ->with('success', 'Draf proposal AI berhasil dibuat! Anda dapat meninjau dan mengedit isi naskah.');
        } catch (\Throwable $e) {
            Log::error('Error generating proposal AI: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghasilkan proposal dengan AI: ' . $e->getMessage());
        }
    }

    /**
     * Preview or Download PDF
     */
    public function previewPdf(ProposalRequest $proposal)
    {
        $content = $proposal->active_content;

        if (empty($content)) {
            // Auto generate if not generated yet
            $content = $this->geminiService->generateProposal($proposal);
            $proposal->generated_proposal_data = $content;
            $proposal->status = 'draft_generated';
            $proposal->save();
        }

        $pdf = Pdf::loadView('admin.proposal.pdf', [
            'proposal' => $proposal,
            'content' => $content,
        ])->setPaper('a4', 'portrait');

        $fileName = 'Proposal_Jatidiri_' . str_replace(' ', '_', $proposal->school_name) . '.pdf';

        return request()->has('download') 
            ? $pdf->download($fileName) 
            : $pdf->stream($fileName);
    }

    /**
     * Dedicated direct download endpoint for Proposal PDF
     */
    public function downloadPdf(ProposalRequest $proposal)
    {
        request()->merge(['download' => 1]);
        return $this->previewPdf($proposal);
    }

    /**
     * Export all proposals / request data report to CSV for Admin
     */
    public function exportReport(Request $request)
    {
        $query = ProposalRequest::query()->latest();

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }
        if ($request->filled('source')) {
            $query->bySource($request->source);
        }

        $proposals = $query->get();

        $filename = 'Rekap_Laporan_Proposal_Jatidiri_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($proposals) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'Nomor Proposal',
                'Nama Institusi / Sekolah',
                'Tipe Lembaga',
                'Kota / Wilayah',
                'Nama PIC',
                'Jabatan PIC',
                'No. WhatsApp PIC',
                'Email PIC',
                'Tipe Paket',
                'Estimasi Peserta',
                'Harga per Siswa (IDR)',
                'Total Anggaran (IDR)',
                'Status',
                'Sumber Permohonan',
                'Tanggal Masuk',
                'Tanggal Terkirim',
            ]);

            foreach ($proposals as $idx => $p) {
                fputcsv($file, [
                    $idx + 1,
                    $p->proposal_number,
                    $p->school_name,
                    strtoupper($p->institution_type),
                    $p->city ?: '-',
                    $p->pic_name,
                    $p->pic_title ?: '-',
                    $p->pic_phone,
                    $p->pic_email,
                    strtoupper($p->package_type),
                    $p->estimated_participants,
                    $p->price_per_participant,
                    $p->total_estimated_budget,
                    $p->status,
                    $p->source === 'web_lead' ? 'Web Landing Page' : 'Input Manual Admin',
                    $p->created_at ? $p->created_at->format('Y-m-d H:i') : '-',
                    $p->sent_at ? $p->sent_at->format('Y-m-d H:i') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Dispatch Proposal PDF to PIC's Email
     */
    public function sendEmail(ProposalRequest $proposal)
    {
        try {
            $content = $proposal->active_content;
            if (empty($content)) {
                $content = $this->geminiService->generateProposal($proposal);
                $proposal->generated_proposal_data = $content;
                $proposal->save();
            }

            $pdf = Pdf::loadView('admin.proposal.pdf', [
                'proposal' => $proposal,
                'content' => $content,
            ])->setPaper('a4', 'portrait');

            $fileName = 'Proposal_Kerjasama_Jatidiri_' . preg_replace('/[^A-Za-z0-9_]/', '_', $proposal->school_name) . '.pdf';
            $pdfContent = $pdf->output();

            Mail::to($proposal->pic_email)->send(new ProposalOfferMail($proposal, $pdfContent, $fileName));

            $proposal->status = 'sent';
            $proposal->sent_at = now();
            $proposal->save();

            // Send notification to PIC via WhatsApp if configured
            $waMessage = "Halo Bapak/Ibu {$proposal->pic_name} ({$proposal->school_name}), proposal penawaran resmi Program Asesmen Psikologi Digital Jatidiri.app (No. {$proposal->proposal_number}) telah kami kirimkan ke email {$proposal->pic_email}. Silakan memeriksa kotak masuk atau folder spam Anda. Salam hangat, Tim Jatidiri.app.";
            $this->watzapService->send($proposal->pic_phone, $waMessage);

            return redirect()->back()
                ->with('success', "Proposal berhasil dikirim ke email {$proposal->pic_email} dan notifikasi WA telah diteruskan.");
        } catch (\Throwable $e) {
            Log::error('Error sending proposal email: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }

    /**
     * Delete proposal request
     */
    public function destroy(ProposalRequest $proposal)
    {
        $school = $proposal->school_name;
        $proposal->delete();

        return redirect()->route('admin.proposal.index')
            ->with('success', "Data proposal {$school} telah dihapus.");
    }
}
