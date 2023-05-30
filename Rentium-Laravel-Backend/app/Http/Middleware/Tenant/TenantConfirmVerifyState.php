<?php

namespace App\Http\Middleware\Tenant;

use Illuminate\Http\Request;

use App\Services\Traits\ModelAbstraction\General\Tenant\VerifyEmailAbstraction;

use Closure;

final class TenantConfirmVerifyState
{
	use VerifyEmailAbstraction;

	public function handle(Request $request, Closure $next)
	{
        //init:
        $tenant_was_verified = false;
        
		/**/ 
        //Before:

        //check if token has been generated

        try
        {
            if($request)
            {
                $tenant_was_verified = $this?->TenantConfirmVerifiedStateService($request);
                if(!$tenant_was_verified)
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