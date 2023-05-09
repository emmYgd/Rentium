<?php

namespace App\Mail\Tenant;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

use App\Services\Traits\ModelAbstractions\Tenant\TenantAccessAbstraction;

class SendPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;
    use TenantAccessAbstraction;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $tenant_request;
    public $pass_reset_link;
    public $tenantModel;

    public function __construct(Request $tenant_request, string $pass_reset_token)
    {
        //init:
        $this->tenant_request = $tenant_request;
        $this->pass_reset_token = $pass_reset_token;

        // Use this tenant request object to get the names of the tenant:
        $queryKeysValues = [
            'tenant_email' => $tenant_request?->tenant_email
        ];
        $this->tenantModel = $this?->TenantReadSpecificService($queryKeysValues);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this?->subject("Password Reset Mail for {$this?->tenantModel?->tenant_full_name}")
                    ?->view('tenant.password-reset');
    }
}
