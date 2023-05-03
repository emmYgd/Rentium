<?php

namespace App\Listeners\Landlord;

use App\Events\Landlord\LandlordHasRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use App\Mail\Landlord\SendWelcomeMail;

class EmailLandlordAboutWelcome
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
        $landlord_mail = $event->request->landlord_email;
        $landlord_request = $event->request;
        
        Mail::to($landlord_mail)->send(new SendWelcomeMail($landlord_request));
    }
}
