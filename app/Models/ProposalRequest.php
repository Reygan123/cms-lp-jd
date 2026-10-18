<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_number',
        'source',
        'school_name',
        'institution_type',
        'city',
        'pic_name',
        'pic_title',
        'pic_phone',
        'pic_email',
        'target_audience',
        'estimated_participants',
        'test_needs',
        'package_type',
        'price_per_participant',
        'total_estimated_budget',
        'budget_source',
        'urgency_purpose',
        'special_notes',
        'status',
        'ai_model_used',
        'generated_proposal_data',
        'customized_content',
        'pdf_path',
        'sent_at',
    ];

    protected $casts = [
        'test_needs' => 'array',
        'generated_proposal_data' => 'array',
        'customized_content' => 'array',
        'price_per_participant' => 'decimal:2',
        'total_estimated_budget' => 'decimal:2',
        'sent_at' => 'datetime',
    ];

    /**
     * Generate standard official proposal number: [Urutan]/JTD-EDU/[BulanRomawi]/[Tahun]
     */
    public static function generateNextProposalNumber(): string
    {
        $year = date('Y');
        $month = (int) date('m');
        $romans = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $monthRoman = $romans[$month] ?? 'X';

        $lastProposal = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $nextNum = $lastProposal ? ($lastProposal->id + 1) : 1;
        $padded = str_pad((string)$nextNum, 3, '0', STR_PAD_LEFT);

        return "{$padded}/JTD-EDU/{$monthRoman}/{$year}";
    }

    /**
     * Status label badge helper
     */
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending' => ['label' => 'Menunggu AI Generate', 'class' => 'badge-warning text-dark'],
            'draft_generated' => ['label' => 'Draf AI Siap', 'class' => 'badge-info'],
            'reviewed' => ['label' => 'Sudah Direview Admin', 'class' => 'badge-primary'],
            'sent' => ['label' => 'Terkirim ke Email PIC', 'class' => 'badge-success'],
            default => ['label' => ucfirst($this->status), 'class' => 'badge-secondary'],
        };
    }

    /**
     * Get active proposal data (customized content if admin edited, otherwise generated AI content)
     */
    public function getActiveContentAttribute(): ?array
    {
        return $this->customized_content ?: $this->generated_proposal_data;
    }

    /**
     * Human-friendly package name label
     */
    public function getPackageLabelAttribute(): string
    {
        return match(strtolower($this->package_type ?? '')) {
            'school_starter', 'starter' => 'School Starter',
            'school_advance', 'advance' => 'School Advance',
            'school_ultimate', 'ultimate' => 'School Ultimate',
            'campus_efisien' => 'Kampus Efisien',
            'campus_komprehensif' => 'Kampus Komprehensif',
            'campus_pmb_seleksi', 'pmb' => 'PMB & Kedokteran',
            'corp_basic' => 'Corp Basic Fit',
            'corp_professional' => 'Corp Professional',
            'corp_leader' => 'Corp Leader Insight',
            'corp_wellness' => 'Corp WorkWell',
            'custom' => 'Custom Package',
            default => strtoupper(str_replace('_', ' ', $this->package_type ?? 'Advance')),
        };
    }

    /**
     * Category of institution (sekolah / kampus / corporate)
     */
    public function getInstitutionCategoryAttribute(): string
    {
        $val = strtolower($this->institution_type ?? '');
        if (in_array($val, ['universitas', 'fk_kedokteran', 'pmb_kampus', 'politeknik'])) {
            return 'kampus';
        }
        if (in_array($val, ['corporate', 'bumn_instansi', 'rumah_sakit', 'csr_filantropi'])) {
            return 'corporate';
        }
        return 'sekolah';
    }
}
