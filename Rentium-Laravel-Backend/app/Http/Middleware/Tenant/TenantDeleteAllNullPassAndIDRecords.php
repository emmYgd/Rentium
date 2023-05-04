<?php

namespace App\Http\Middleware\Tenant;

use Illuminate\Http\Request;

use Closure;
use App\Services\Traits\ModelAbstraction\Tenant\TenantAccessAbstraction;

final class TenantDeleteAllNullPassAndIDRecords
{
	use TenantAccessAbstraction;

	public function handle(Request $request, Closure $next)
	{
		//Before:
		//Pass to next stack:
		$response = $next($request);
		
		
		//After:
		//delete all collections where unique_tenant_id and tenant_password == null;
        $deleteKeysValues = [
            'unique_tenant_id' => '',
            'tenant_password' => ''
        ];

		//This is to clear the database of all partially saved user data after requests:
		//$this?->TenantDeleteAllNullService($deleteKeysValues);
		
        return $response;
	}
	
}