<?php

namespace App\Mail;

use App\Models\PelatihanParticipant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PelatihanParticipantRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public PelatihanParticipant $participant;

    public function __construct(PelatihanParticipant $participant)
    {
        $this->participant = $participant;
    }

    public function build()
    {
        return $this
            ->subject('Pembaruan Status Pendaftaran — ' . $this->participant->pelatihan->title)
            ->view('admin.pelatihan.mail.rejected');
    }
}
