<?php

namespace App\Http\Middleware\Landlord;

use Illuminate\Http\Request;

use App\Services\Traits\ModelAbstraction\Landlord\LandlordAccessAbstraction;

use Closure;

final class LandlordEnsureLogoutState
{
	use LandlordAccessAbstraction;

	public function handle(Request $request, Closure $next)
	{
		/*let's say a user is logged in on a specific device previously...
			Then he used another browser or device to log out, 
			if he comes back to use the application on the former browser, 
      they should be logged out immediately:*/ 
    //Before:
    try
    {
      $is_logged_in = $this?->LandlordConfirmLoginStateService($request);

      if($is_logged_in)
      {
        //log user out:
        $logout_status_was_ensured = $this?->LandlordLogoutService($request);
        if(!$logout_status_was_ensured)
        {
          throw new \Exception('Could not logout landlord!');
        }
      }
    }
    catch(\Exception $ex)
    {
      $status = [
        'code' => 0,
        'serverStatus' => 'LogOutFailure!',
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