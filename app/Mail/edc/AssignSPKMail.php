<?php

namespace App\Mail\Edc;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssignSPKMail extends Mailable
{
    use Queueable, SerializesModels;

    public $spkNumber;
    public $message;

    public function __construct($spkNumber, $message)
    {
        $this->spkNumber = is_string($spkNumber) ? $spkNumber : (string) $spkNumber;
        $this->message = is_string($message) ? $message : (string) $message;
    }
    
    public function build()
    {
        logger()->info('AssignSPKMail build data', [
            'spkNumber' => $this->spkNumber,
            'message' => $this->message,
            'spkNumberType' => gettype($this->spkNumber),
            'messageType' => gettype($this->message),
        ]);
    
        return $this->view('email.edc.notifyUserAssigned')
                    ->subject('SPK Telah Di-Assigned')
                    ->with([
                        'spkNumber' => $this->spkNumber,
                        'message' => $this->message,
                    ]);
    }
     
}

