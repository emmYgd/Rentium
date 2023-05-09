<?php

namespace App\Services\Traits\ModelAbstraction\General\Tenant;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Events\Dispatcher;

use App\Services\Traits\ModelAbstraction\Tenant\TenantAccessAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;
use App\Services\Traits\Utilities\PassHashVerifyService;

use App\Events\Tenant\PassResetTokenWasFormed;

trait PasswordResetNotificationAbstraction
{
    use TenantAccessAbstraction;
    use ComputeUniqueIDService;
    use PassHashVerifyService;

    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */

    protected function TenantSendPasswordResetMailService(Request $request): bool | string
    {
        //init:
        $update_status = false;

        //redirect if tenant is verified:
        $tenant_detail_via_email = $this?->TenantFoundDetailService($request);

        if(!$tenant_detail_via_email) 
        {
            return false;
        }
        //else:
            // form password reset token:
            $pass_reset_token = $this?->genUniqueNumericId();

            //use event to create and send mailing instance:
            event(new PassResetTokenWasFormed($request, $pass_reset_token));

            //insert this verification token in the database:
            $queryKeysValues = [
                'tenant_email' => $request->tenant_email,
            ];
            $newKeysValues = [
                 //production:
                //'pass_reset_token' => $this->CustomHashPassword($pass_reset_token),
                //test:
                'pass_reset_token' => $pass_reset_token,
            ];
            $tenant_was_updated = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);
            if(!$tenant_was_updated)
            {
                return false;
            }

            //read this tenant's unique id:
            $unique_tenant_id = $this?->TenantReadSpecificService($queryKeysValues)->unique_tenant_id;
            if(!$unique_tenant_id)
            {
                return false;
            }

        //redirect()->intended(RouteServiceProvider::HOME);
        return $unique_tenant_id;
    }
}
