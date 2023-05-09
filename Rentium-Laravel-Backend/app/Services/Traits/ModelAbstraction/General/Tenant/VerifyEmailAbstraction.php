<?php

namespace App\Services\Traits\ModelAbstraction\General\Tenant;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Services\Traits\ModelAbstraction\Tenant\TenantAccessAbstraction;
use App\Services\Traits\Utilities\PassHashVerifyService;

trait VerifyEmailAbstraction 
{
    use TenantAccessAbstraction;
    use PassHashVerifyService;

    /**
     * Mark the authenticated tenant's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
     protected function TenantConfirmVerifiedStateService(Request $request) : bool
     {
         $queryKeysValues = [
             'unique_tenant_id' => $request?->unique_tenant_id
         ];
         $foundDetail = $this?->TenantReadSpecificService($queryKeysValues);
 
         //get the login state:
         $verified_status = $foundDetail?->is_email_verified;
         return $verified_status;
     }
 
     protected function TenantChangeVerifiedStateService(Request $request) : bool
     {
        $queryKeysValues = [
            'unique_tenant_id' => $request?->unique_tenant_id,
            //production:
            //'verify_token' => $this->CustomHashPassword($request->verify_token);
            //test:
             'verify_token' => $request->verify_token
        ];
         $newKeysValues = [
             'is_email_verified' => true,
         ];
 
         //update:
         $was_status_updated = $this->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);
         if(!$was_status_updated)
         {
             return false;
         }
 
         return true;
     }
}
