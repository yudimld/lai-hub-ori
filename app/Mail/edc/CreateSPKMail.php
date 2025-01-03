<?php

namespace App\Mail\Edc;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateSPKMail extends Mailable
{
    use Queueable, SerializesModels;

    public $spkNumber;
    public $message;

    public function __construct($spkNumber, $message)
    {
        $this->spkNumber = (string) $spkNumber; // Pastikan menjadi string
        $this->message = (string) $message;     // Pastikan menjadi string
    }

    public function build()
    {
        return $this->view('email.edc.notifyManager')
                    ->subject('SPK Baru Dibuat')
                    ->with([
                        'spkNumber' => $this->spkNumber,
                        'message' => $this->message,
                    ]);
    }
}
