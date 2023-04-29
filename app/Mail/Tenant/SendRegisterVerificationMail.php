<?php

namespace App\Mail\Tenant;

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

    public $tenant_request;
    public $verify_link;

    public function __construct(Request $tenant_request, string $verify_link)
    {
        //init:
        $this->tenant_request = $tenant_request;
        $this->verify_link = $verify_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Verification Mail for {$this->tenant_request->tenant_first_name} {$this->tenant_request->tenant_last_name} ")
                    ->view('tenant.verification-request');
    }
}
