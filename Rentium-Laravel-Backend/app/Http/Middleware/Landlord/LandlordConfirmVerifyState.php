<?php

namespace App\Http\Middleware\Landlord;

use Illuminate\Http\Request;

use App\Services\Traits\ModelAbstractions\General\Landlord\VerifyEmailAbstraction;

use Closure;

final class LandlordConfirmVerifyState
{
	use VerifyEmailAbstraction;

	public function handle(Request $request, Closure $next)
	{
        //init:
        $landlord_was_verified = false;
        
		/**/ 
        //Before:

        //check if token has been generated
        $unique_landlord_id = $request?->landlord_email_or_username;
        try
        {
            if(!$landlord_unique_id)
            {
                $landlord_was_verified = $this?->LandlordConfirmVerifiedStateService($unique_landlord_id);
                if(!$landlord_was_verified)
                {
                    throw new Exception("You are not verified yet! Please enter the 6-digit token sent to your mail to activate your account!");
                }
            }

            if(!$landlord_email_or_username)
            {
                $landlord_was_verified_using_id = $this?->LandlordConfirmVerifiedStateViaId($landlord_unique_id);
                if(!$landlord_was_verified_using_id)
                {
                    throw new Exception("You are not verified yet! Follow the link sent to your mail to activate your account!");
                }
            }
           
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'VerifyFailure!',
                'short_description' => $ex->getMessage(),
            ];

            return response()->json($status, 403);
        }

        //After:
        //Pass to next stack:
        $response = $next($request);

        //Release response to frontend:
        return $response;
	}
	
}