<?php

namespace App\Services\Traits\ModelAbstraction\General\Landlord;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Events\Dispatcher;

use App\Services\Traits\ModelAbstraction\Landlord\LandlordAccessAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;
use App\Services\Traits\Utilities\PassHashVerifyService;

use App\Events\Landlord\PassResetTokenWasFormed;

trait PasswordResetNotificationAbstraction
{
    use LandlordAccessAbstraction;
    use ComputeUniqueIDService;
    use PassHashVerifyService;

    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */

    protected function LandlordSendPasswordResetMailService(Request $request): bool | string
    {
        //init:
        $update_status = false;

        //redirect if landlord is verified:
        $landlord_detail_via_email = $this?->LandlordFoundDetailService($request);

        if(!$landlord_detail_via_email) 
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
                'landlord_email' => $request->landlord_email,
            ];
            $newKeysValues = [
                //production:
                //'pass_reset_token' => $this->CustomHashPassword($pass_reset_token),
                //test:
                'pass_reset_token' => $pass_reset_token,
            ];
            $landlord_was_updated = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
            if(!$landlord_was_updated)
            {
                return false;
            }

            //read this landlord's unique id:
            $unique_landlord_id = $this?->LandlordReadSpecificService($queryKeysValues)->unique_landlord_id;
            if(!$unique_landlord_id)
            {
                return false;
            }

        //redirect()->intended(RouteServiceProvider::HOME);
        return $unique_landlord_id;
    }
}
