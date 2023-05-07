<?php

namespace App\Listeners\Tenant;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use App\Events\Tenant\TenantHasRegistered;
use App\Mail\Tenant\SendRegisterVerificationMail; 

class EmailTenantAboutVerification
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
     * @param  \App\Events\Tenant\TenantRegistered  $event
     * @return void
     */
    public function handle(TenantHasRegistered $event)
    {
        $tenant_request = $event->request;
        $tenant_mail = $event->request->tenant_email;
        $verify_token = $event->verify_token;
        
        Mail::to($tenant_mail)->send(new SendRegisterVerificationMail($tenant_request, $verify_token));
    }
}
