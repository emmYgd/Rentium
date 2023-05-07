<?php

namespace App\Services\Traits\ModelAbstraction\General\Tenant ;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Events\Dispatcher;

use App\Services\Traits\ModelAbstraction\Tenant\TenantAccessAbstraction;
//use App\Services\Traits\Utilities\GenerateLinksService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

use App\Events\Tenant\TenantHasRegistered;


trait EmailVerificationNotificationAbstraction
{
    use TenantAccessAbstraction;
    //use GenerateLinksService;
    use ComputeUniqueIDService;
    
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function SendVerificationReqMail(Request $request): bool | str
    {
        //redirect if tenant is verified:
        $email_was_verified = $this->TenantDetailsFoundService($request)->is_email_verified;

        if(!$email_was_verified) 
        {
            // form verification token:
            //$verify_link = $this->GenerateRegisterVerifyToken($url_title, $other_url_params);
            $verify_token = $this?->genUniqueNumericId();

            //use event to create and send mailing instance:
            event(new TenantHasRegistered($request, $verify_token));

            //insert this verification token in the database:
            $queryKeysValues = [
                'tenant_email' => $request->tenant_email,
                'tenant_phone_number' => $request->tenant_phone_number,
            ];
            $newKeysValues = [
                'verify_token' => $verify_token,
            ];
            $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);

            return  $verify_token;//true;
        }

        //redirect()->intended(RouteServiceProvider::HOME);
        return true;
    }
}
