<?php

namespace App\Http\Middleware\Tenant;

use Illuminate\Http\Request;

use Closure;
use App\Services\Traits\ModelAbstractions\Tenant\TenantAccessAbstraction;

final class TenantDeleteAllNullPassAndIDRecords
{
	use TenantAccessAbstraction;

	public function handle(Request $request, Closure $next)
	{
		//Before:
		//delete all collections where unique_tenant_id and tenant_password == null;
        $deleteKeysValues = [
            'unique_tenant_id' => 'null',
            'tenant_password' => 'null'
        ];

		//This is to clear the database of all partially saved user data:

		$this?->TenantDeleteAllNullService($deleteKeysValues);

		//After:
		//Pass to next stack:
		$response = $next($request);
        return $response;
	}
	
}