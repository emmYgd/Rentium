<?php

namespace App\Listeners\Landlord;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use App\Events\Landlord\PassResetLinkWasFormed;
use App\Mail\Landlord\SendPasswordResetMail; 


class EmailLandlordAboutReset
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
     * @param  \App\Events\Landlord\PassResetLinkSent  $event
     * @return void
     */
    public function handle(PassResetLinkWasFormed $event)
    {
        $landlord_request = $event->request;
        $landlord_mail = $event->request->landlord_email;
        $pass_reset_link = $event->pass_reset_link;

        //Invoke mail object:
        Mail::to($landlord_mail)->send(new SendPasswordResetMail($landlord_request, $pass_reset_link));
    }
}
