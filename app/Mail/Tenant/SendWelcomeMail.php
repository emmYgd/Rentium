<?php

namespace App\Mail\Tenant;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class SendWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $tenant_request;

    public function __construct(Request $tenant_request)
    {
        //init:
        $this->tenant_request = $tenant_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Welcome Mail for {$this->tenant_request->tenant_first_name} {$this->tenant_request->tenant_last_name} ")
                    ->view('tenant.welcome-greeting');//view is inside the resources/views folder...
    }
}
