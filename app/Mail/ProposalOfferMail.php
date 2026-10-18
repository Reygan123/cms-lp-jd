<?php

namespace App\Mail;

use App\Models\ProposalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalOfferMail extends Mailable
{
    use Queueable, SerializesModels;

    public ProposalRequest $proposal;
    public string $pdfContent;
    public string $pdfFileName;

    /**
     * Create a new message instance.
     */
    public function __construct(ProposalRequest $proposal, string $pdfContent, string $pdfFileName)
    {
        $this->proposal = $proposal;
        $this->pdfContent = $pdfContent;
        $this->pdfFileName = $pdfFileName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject("Proposal Penawaran Kerja Sama Jatidiri.app - {$this->proposal->school_name}")
            ->view('admin.proposal.mail')
            ->attachData($this->pdfContent, $this->pdfFileName, [
                'mime' => 'application/pdf',
            ]);
    }
}
