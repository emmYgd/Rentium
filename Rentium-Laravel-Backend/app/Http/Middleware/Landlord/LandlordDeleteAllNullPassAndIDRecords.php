<?php

namespace App\Http\Middleware\Landlord;

use Illuminate\Http\Request;

use Closure;
use App\Services\Traits\ModelAbstractions\Landlord\LandlordAccessAbstraction;

final class LandlordDeleteAllNull
{
	use LandlordAccessAbstraction;

	public function handle(Request $request, Closure $next)
	{
		//Before:
		//delete all collections where unique_landlord_id and landlord_password == null;
        $deleteKeysValues = [
            'unique_landlord_id' => 'null',
            'landlord_password' => 'null'
        ];

		$this?->LandlordDeleteAllNullService($deleteKeysValues);

		//After:
		//Pass to next stack:
		$response = $next($request);
        return $response;
	}
	
}