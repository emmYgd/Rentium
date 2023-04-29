<?php

namespace App\Mail\Landlord;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

use App\Services\Traits\ModelAbstractions\Landlord\LandlordAccessAbstraction;

class SendPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;
    use LandlordAccessAbstraction;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $landlord_request;
    public $pass_reset_link;
    public $landlordModel;

    public function __construct(Request $landlord_request, string $pass_reset_link)
    {
        //init:
        $this->landlord_request = $landlord_request;
        $this->pass_reset_link = $pass_reset_link;

        // Use this landlord request object to get the names of the landlord:
        $queryKeysValues = [
            'landlord_email' => $landlord_request->landlord_email
        ];
        $this->landlordModel = $this?->LandlordReadSpecificService($queryKeysValues);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Password Reset Mail for {$this->landlordModel->landlord_first_name} {$this->landlordModel->landlord_last_name}")
                    ->view('landlord.password-reset');
    }
}
