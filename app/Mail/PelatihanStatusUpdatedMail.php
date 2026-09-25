<?php

namespace App\Mail;

use App\Models\PelatihanParticipant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PelatihanStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public PelatihanParticipant $participant;
    public string $waGroupLink;

    public function __construct(PelatihanParticipant $participant)
    {
        $this->participant = $participant;
        $this->waGroupLink = config('services.pelatihan.wa_group_link', '');
    }

    public function build()
    {
        return $this
            ->subject('Status Pendaftaran Diperbarui — ' . $this->participant->pelatihan->title)
            ->view('admin.pelatihan.mail.status_updated');
    }
}
