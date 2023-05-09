<?php

namespace App\Http\Middleware\Tenant;

use Illuminate\Http\Request;

use Closure;
use App\Services\Traits\ModelAbstraction\Tenant\TenantAccessAbstraction;

final class DestroyTokenAfterLogout
{
	use TenantAccessAbstraction;

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
        	$tenantObject = $this?->TenantFoundDetailService($request);

			//query params:
			$queryKeysValues = [
				'tokenable_id' => $tenantObject?->id
			];
        	//use object to delete token:
        	$tenant_token_was_deleted = $tenantObject?->tokens()?->where($queryKeysValues)?->delete();
			if(!$tenant_token_was_deleted)
			{
				$queryKeysValues = ['unique_tenant_id' => $request?->unique_tenant_id];
				$newKeysValues = [ 'is_logged_in' => true];

				//restore this user back to a logged in user:
				$login_status_was_updated = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);
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