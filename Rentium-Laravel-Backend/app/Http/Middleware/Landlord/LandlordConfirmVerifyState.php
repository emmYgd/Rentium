<?php

namespace App\Http\Middleware\Landlord;

use Illuminate\Http\Request;

use App\Services\Traits\ModelAbstraction\General\Landlord\VerifyEmailAbstraction;

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
        $unique_landlord_id = $request?->unique_landlord_id;

        try
        {
            if($unique_landlord_id)
            {
                $landlord_was_verified = $this?->LandlordConfirmVerifiedStateService($request);
                if(!$landlord_was_verified)
                {
                    throw new \Exception("You are not verified yet! Please enter the 6-digit token sent to your mail to activate your account!");
                }
            }

        }
        catch(\Exception $ex)
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