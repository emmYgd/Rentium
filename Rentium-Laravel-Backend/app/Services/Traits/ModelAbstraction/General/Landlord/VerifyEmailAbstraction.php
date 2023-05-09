<?php

namespace App\Services\Traits\ModelAbstraction\General\Landlord;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Services\Traits\ModelAbstraction\Landlord\LandlordAccessAbstraction;
use App\Services\Traits\Utilities\PassHashVerifyService;

trait VerifyEmailAbstraction 
{
    use LandlordAccessAbstraction;
    use PassHashVerifyService;

    /**
     * Mark the authenticated landlord's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
     protected function LandlordConfirmVerifiedStateService(Request $request) : bool
     {
         $queryKeysValues = [
             'unique_landlord_id' => $request?->unique_landlord_id
         ];
         $foundDetail = $this?->LandlordReadSpecificService($queryKeysValues);
 
         //get the login state:
         $verified_status = $foundDetail?->is_email_verified;
         return $verified_status;
     }
 
     protected function LandlordChangeVerifiedStateService(Request $request) : bool
     {
         $queryKeysValues = [
             'unique_landlord_id' => $request?->unique_landlord_id,
            //production:
            //'verify_token' => $this->CustomHashPassword($request->verify_token);
            //test:
            'verify_token' => $request->verify_token
         ];
         $newKeysValues = [
             'is_email_verified' => true,
         ];
 
         //update:
         $was_status_updated = $this->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
         if(!$was_status_updated)
         {
             return false;
         }
 
         return true;
     }
}
