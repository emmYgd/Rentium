<?php

namespace App\Listeners\Tenant;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use App\Events\Tenant\PassResetTokenWasFormed;
use App\Mail\Tenant\SendPasswordResetMail; 


class EmailTenantAboutPassReset
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
     * @param  \App\Events\Tenant\PassResetTokenSent  $event
     * @return void
     */
    public function handle(PassResetTokenWasFormed $event)
    {
        $tenant_request = $event->request;
        $tenant_mail = $event->request->tenant_email;
        $pass_reset_token = $event->pass_reset_token;

        //Invoke mail object:
        Mail::to($tenant_mail)->send(new SendPasswordResetMail($tenant_request, $pass_reset_token));
    }
}
