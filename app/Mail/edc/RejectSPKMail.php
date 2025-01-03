<?php

namespace App\Mail\Edc;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectSPKMail extends Mailable
{
    use Queueable, SerializesModels;

    public $spkNumber;

    public function __construct($spkNumber)
    {
        $this->spkNumber = (string) $spkNumber; // Konversi eksplisit ke string
    }

    public function build()
    {
        return $this->view('email.edc.notifyRejected')
                    ->subject('SPK Anda Telah Ditolak')
                    ->with([
                        'spkNumber' => $this->spkNumber,
                    ]);
    }
}
