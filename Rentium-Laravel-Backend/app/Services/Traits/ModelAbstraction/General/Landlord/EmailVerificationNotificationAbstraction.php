<?php

namespace App\Services\Traits\ModelAbstraction\General\Landlord;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Events\Dispatcher;

use App\Services\Traits\ModelAbstraction\Landlord\LandlordAccessAbstraction;
//use App\Services\Traits\Utilities\GenerateLinksService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;
use App\Services\Traits\Utilities\PassHashVerifyService;

use App\Events\Landlord\LandlordHasRegistered;


trait EmailVerificationNotificationAbstraction
{
    use LandlordAccessAbstraction;
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

        //redirect if landlord is verified:
        $email_was_verified = $this->LandlordConfirmVerifiedStateService($request);
        if ($email_was_verified) {
            throw new \Exception("Email was already verified!");
        }

        //else:
        // form verification token:
        //$verify_link = $this->GenerateRegisterVerifyToken($url_title, $other_url_params);
        $verify_token = $this?->genUniqueNumericId();

        //insert this verification token in the database:
        $queryKeysValues = [
            'landlord_email' => $request->landlord_email,
            'landlord_phone_number' => $request->landlord_phone_number,
        ];
        $newKeysValues = [
            //production:
            //'verify_token' => $this->CustomHashPassword(verify_token),
            //test:
            'verify_token' => $verify_token,
        ];
        $landlord_was_updated = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
        if (!$landlord_was_updated) {
            return false;
        }

        //read this landlord's unique id:
        $unique_landlord_id = $this?->LandlordReadSpecificService($queryKeysValues)->unique_landlord_id;
        if (!$unique_landlord_id) 
        {
            return false;
        }

        //use event to create and send mailing instance:
        event(new LandlordHasRegistered($request, $verify_token));

        //redirect()->intended(RouteServiceProvider::HOME);
        return $unique_landlord_id;
    }
}
