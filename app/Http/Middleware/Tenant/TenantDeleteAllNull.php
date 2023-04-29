<?php

namespace App\Http\Middleware\Tenant;

use Illuminate\Http\Request;

use Closure;
use App\Services\Traits\ModelAbstractions\Tenant\TenantAccessAbstraction;

final class TenantDeleteAllNull
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

		$this?->TenantDeleteAllNullService($deleteKeysValues);

		//After:
		//Pass to next stack:
		$response = $next($request);
        return $response;
	}
	
}