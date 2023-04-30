<?php

namespace App\Services\Traits\Utilities;

use Illuminate\Support\Facades\Hash;

trait PassHashVerifyService
{
	protected function CustomHashPassword(string $reqPass): string
    {
    	$firstPass = Hash::make($reqPass);
    	/*$secondPass = Hash::make($reqPass);
		$thirdPass = Hash::make($reqPass);
    	$finalHashedPass = Hash::make($firstPass . $secondPass . $thirdPass);*/

    	return $firstPass;
    }

	protected function CustomVerifyPassword(string $password, string $hash): bool
	{
		//Check for equality:
		if(!Hash::check($password, $hash))
		{
			return false;
		}
		return true;
	}

}