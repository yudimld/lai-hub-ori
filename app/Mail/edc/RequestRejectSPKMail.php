<?php

namespace App\Mail\Edc;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestRejectSPKMail extends Mailable
{
    use Queueable, SerializesModels;

    public $spkNumber;

    public function __construct($spkNumber)
    {
        $this->spkNumber = (string) $spkNumber; // Pastikan menjadi string
    }

    public function build()
    {
        return $this->view('email.edc.notifyRequestReject')
                    ->subject('Permintaan Persetujuan Penolakan SPK')
                    ->with([
                        'spkNumber' => $this->spkNumber,
                    ]);
    }
}
