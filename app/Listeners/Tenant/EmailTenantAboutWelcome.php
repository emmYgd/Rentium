<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\TenantHasRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use App\Mail\Tenant\SendWelcomeMail;

class EmailTenantAboutWelcome
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
        $tenant_mail = $event->request->tenant_email;
        $tenant_request = $event->request;
        
        Mail::to($tenant_mail)->send(new SendWelcomeMail($tenant_request));
    }
}
