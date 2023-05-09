<?php

namespace App\Listeners\Landlord;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use App\Events\Landlord\LandlordHasRegistered;
use App\Mail\Landlord\SendRegisterVerificationMail; 

class EmailLandlordAboutVerification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Landlord\LandlordRegistered  $event
     * @return void
     */
    public function handle(LandlordHasRegistered $event)
    {
        $landlord_request = $event->request;
        $landlord_mail = $event->request->landlord_email;
        $verify_token = $event->verify_token;
        
        Mail::to($landlord_mail)->send(new SendRegisterVerificationMail($landlord_request, $verify_token));
    }
}
