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
    public $verify_link;

    public function __construct(Request $landlord_request, string $verify_link)
    {
        //init:
        $this->landlord_request = $landlord_request;
        $this->verify_link = $verify_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Verification Mail for {$this->landlord_request->landlord_first_name} {$this->landlord_request->landlord_last_name} ")
                    ->view('landlord.verification-request');
    }
}
