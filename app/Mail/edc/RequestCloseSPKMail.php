<?php

namespace App\Mail\Edc;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestCloseSPKMail extends Mailable
{
    use Queueable, SerializesModels;

    public $spkNumber;

    public function __construct($spkNumber)
    {
        $this->spkNumber = (string) $spkNumber;
    }

    public function build()
    {
        return $this->view('email.edc.notifyRequestClose')
                    ->subject('SPK Anda Diminta untuk Di Closed')
                    ->with([
                        'spkNumber' => $this->spkNumber,
                    ]);
    }
}
