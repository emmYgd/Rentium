<?php

namespace App\Mail\Landlord;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class SendRegisterVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $landlord_request;
    public $verify_token;

    public function __construct(Request $landlord_request, string $verify_token)
    {
        //init:
        $this->landlord_request = $landlord_request;
        $this->verify_token = $verify_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Verification Mail for {$this->landlord_request->landlord_full_name}")
                    ->view('landlord.verification-request');
    }
}
