<?php

namespace App\Services\Traits\ModelAbstraction\General\Tenant ;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Events\Dispatcher;

use App\Services\Traits\ModelAbstraction\Tenant\TenantAccessAbstraction;
//use App\Services\Traits\Utilities\GenerateLinksService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;
use App\Services\Traits\Utilities\PassHashVerifyService;

use App\Events\Tenant\TenantHasRegistered;


trait EmailVerificationNotificationAbstraction
{
    use TenantAccessAbstraction;
    //use GenerateLinksService;
    use ComputeUniqueIDService;
    use PassHashVerifyService;
    
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function SendVerificationReqMail(Request $request): bool | string
    {
        //init:
        //$update_status = false;

        //redirect if tenant is verified:
        $email_was_verified = $this->TenantConfirmVerifiedStateService($request);
        if($email_was_verified)
        {
            throw new \Exception("Email was already verified!");
        }
        //else:
            // form verification token:
            //$verify_link = $this->GenerateRegisterVerifyToken($url_title, $other_url_params);
            $verify_token = $this?->genUniqueNumericId();

            //insert this verification token in the database:
            $queryKeysValues = [
                'tenant_email' => $request->tenant_email,
                'tenant_phone_number' => $request->tenant_phone_number,
            ];
            $newKeysValues = [
                //production:
                //'verify_token' => $this->CustomHashPassword(verify_token),
                //test:
                'verify_token' => $verify_token,
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

            //use event to create and send mailing instance:
            event(new TenantHasRegistered($request, $verify_token));
       
            return $unique_tenant_id;
    }
}
