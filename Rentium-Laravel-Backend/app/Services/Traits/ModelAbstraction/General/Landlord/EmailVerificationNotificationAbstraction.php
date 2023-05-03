<?php

namespace App\Services\Traits\ModelAbstraction\General;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Events\Dispatcher;

use App\Services\Traits\ModelAbstractions\Landlord\LandlordAccessAbstraction;
use App\Services\Traits\Utilities\GenerateLinksService;

use App\Events\Landlord\LandlordHasRegistered;


trait EmailVerificationNotificationAbstraction
{
    use LandlordAccessAbstraction;
    use GenerateLinksService;
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function SendVerificationReqMail(Request $request, string $url_title, array $other_url_params)/*:
        bool*/
    {
        //redirect if landlord is verified:
        $email_was_verified = $this->LandlordDetailsFoundService($request)->is_email_verified;

        if(!$email_was_verified) 
        {
            // form verification url:
            $verify_link = $this->GenerateRegisterVerifyLink($url_title, $other_url_params);
            //use event to create and send mailing instance:
            event(new LandlordHasRegistered($request, $verify_link));

            return  $verify_link;//true;
        }

        //redirect()->intended(RouteServiceProvider::HOME);
        return true;
    }
}
