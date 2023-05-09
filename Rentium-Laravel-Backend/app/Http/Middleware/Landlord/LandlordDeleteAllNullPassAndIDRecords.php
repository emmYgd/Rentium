<?php

namespace App\Http\Middleware\Landlord;

use Illuminate\Http\Request;

use Closure;
use App\Services\Traits\ModelAbstraction\Landlord\LandlordAccessAbstraction;

final class LandlordDeleteAllNullPassAndIDRecords
{
	use LandlordAccessAbstraction;

	public function handle(Request $request, Closure $next)
	{
		//Before:
		//Pass to next stack:
		$response = $next($request);
		
		
		//After:
		//delete all collections where unique_landlord_id and landlord_password == null;
        $deleteKeysValues = [
            'unique_landlord_id' => '',
            'landlord_password' => ''
        ];

		//This is to clear the database of all partially saved user data after requests:
		//$this?->LandlordDeleteAllNullService($deleteKeysValues);
		
        return $response;
	}
	
}