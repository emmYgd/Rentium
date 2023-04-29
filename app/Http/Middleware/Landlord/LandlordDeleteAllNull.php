<?php

namespace App\Http\Middleware\Landlord;

use Illuminate\Http\Request;

use Closure;
use App\Models\Landlord;

class LandlordDeleteAllNull
{
	//use LandlordAccessAbstraction;

	public function handle(Request $request, Closure $next)
	{
		$response = $next($request);
		//delete all collections where unique_landlord_id and landlord_password == null;
        $deleteKeysValues = [
            'unique_landlord_id' => null,
            'landlord_password' => null
        ];
	
      	Landlord::where($deleteKeysValues)->delete();
        return $response;
	}
	
}