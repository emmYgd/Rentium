<?php

namespace App\Http\Middleware\Landlord;

use Illuminate\Http\Request;

use Closure;
use App\Services\Traits\ModelAbstractions\Landlord\LandlordAccessAbstraction;

final class DestroyTokenAfterLogout
{
	use LandlordAccessAbstraction;

	public function handle(Request $request, Closure $next)
	{
		//Before:
		//After:
		//Pass to next stack:
		$response = $next($request);

        //Delete all Auth header token from db after logout:
        //get the user object:
		try
		{
        	$landlordObject = $this?->LandlordFoundDetailService($request);

			//query params:
			$queryKeysValues = [
				'tokenable_id' => $landlordObject?->id
			];
        	//use object to delete token:
        	$landlord_token_was_deleted = $landlordObject?->tokens()?->where($queryKeysValues)?->delete();
			if(!$landlord_token_was_deleted)
			{
				$queryKeysValues = [
					'unique_landlord_id' => $request?->unique_landlord_id
				];
				$newKeysValues = [ 'is_logged_in' => true];

				//restore this user back to a logged in user:
				$login_status_was_updated = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
				if($login_status_was_updated)
				{
					throw new Exception("Failed to Logout: Auth Bearer Token cannot be deleted!");
				}
			}
		}
		catch(Exception $ex)
		{
			$status = [
				'code' => 0,
				'serverStatus' => 'LogoutFailure!',
				'short_description' => $ex->getMessage()
			];
			return response()->json($status, 400);
		}

        return $response;
	}
	
}