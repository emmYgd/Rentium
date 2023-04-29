<?php

namespace App\Http\Middleware\Landlord;

use Illuminate\Http\Request;

use App\Services\Traits\Landlord\VerifyEmailAbstraction;

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
        $landlord_email = $request?->landlord_email;
        $landlord_unique_id = $request?->unique_landlord_id;
        try
        {
            if(!$landlord_unique_id)
            {
                $landlord_was_verified_using_email = $this?->LandlordConfirmVerifiedStateViaEmail($landlord_email);
                if(!$landlord_was_verified_using_email)
                {
                    throw new \Exception("You are not verified yet! Follow the link sent to your mail to activate your account!");
                }
            }

            if(!$landlord_email)
            {
                $landlord_was_verified_using_id = $this?->LandlordConfirmVerifiedStateViaId($landlord_unique_id);
                /*if(!$landlord_was_verified_using_id)
                {
                    throw new \Exception("You are not verified yet! Follow the link sent to your mail to activate your account!");
                }*/
            }
           
        }
        catch(\Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'VerifyFailure!',
                'short_description' => $ex->getMessage(),
                //'state' => $landlord_was_verified_using_id
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