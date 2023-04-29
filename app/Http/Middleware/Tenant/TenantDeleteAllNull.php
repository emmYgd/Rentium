<?php

namespace App\Http\Middleware\Tenant;

use Illuminate\Http\Request;

use Closure;
use App\Models\Tenant;

class TenantDeleteAllNull
{
	//use BuyerAccessAbstraction;

	public function handle(Request $request, Closure $next)
	{
		$response = $next($request);
		//delete all collections where unique_buyer_id and buyer_password == null;
        $deleteKeysValues = [
            'unique_tenant_id' => null,
            'tenant_password' => null
        ];
	
      	Tenant::where($deleteKeysValues)->delete();
        return $response;
	}
	
}