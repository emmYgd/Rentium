<?php

namespace App\Mail\Landlord;

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

    public $landlord_request;

    public function __construct(Request $landlord_request)
    {
        //init:
        $this->landlord_request = $landlord_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Welcome Mail for {$this->landlord_request->landlord_first_name} {$this->landlord_request->landlord_last_name} ")
                    ->view('landlord.welcome-greeting');
    }
}
