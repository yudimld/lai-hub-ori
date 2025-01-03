<?php

namespace App\Mail\Edc;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CloseSPKMail extends Mailable
{
    use Queueable, SerializesModels;

    public $spkNumber;

    /**
     * Create a new message instance.
     */
    public function __construct($spkNumber)
    {
        $this->spkNumber = $spkNumber;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('email.edc.notifyClosedSPK')
                    ->subject('SPK Telah Ditutup')
                    ->with([
                        'spkNumber' => $this->spkNumber,
                    ]);
    }
}
