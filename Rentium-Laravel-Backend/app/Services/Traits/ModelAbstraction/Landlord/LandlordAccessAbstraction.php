<?php

namespace App\Services\Traits\ModelAbstraction\Landlord;

use Illuminate\Http\Request;

use App\Services\Traits\ModelCRUD\Landlord\LandlordCRUD;
use App\Services\Traits\Utilities\PassHashVerifyService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

trait LandlordAccessAbstraction
{	
	//inherits all their methods:
	use LandlordCRUD;
	use ComputeUniqueIDService;
	use PassHashVerifyService;

	protected function LandlordConfirmLoginStateService(Request $request) : bool
	{

		$queryKeysValues = ['unique_landlord_id' => $request?->unique_landlord_id];
		$detailsFound = $this?->LandlordReadSpecificService($queryKeysValues);

		//get the login state:
		$login_status = $detailsFound['is_logged_in'];
		return $login_status;
	}

	protected function LandlordLogoutService(Request $request): bool
	{
		$queryKeysValues = ['unique_landlord_id' => $request?->unique_landlord_id];
		$newKeysValues = ['is_logged_in' => false];
		$has_logged_out = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);

		return $has_logged_out;
	}

	protected function LandlordRegisterService(Request $request): bool
	{
		$newKeyValues = $request?->all();
		//create new landlord:
		$is_details_saved = $this?->LandlordCreateAllService($newKeyValues);
		return $is_details_saved;
	}

	protected function LandlordDeleteSpecificService($deleteKeysValues): bool
	{
		$is_details_deleted = $this?->LandlordDeleteSpecificService($deleteKeysValues);
		return $is_details_deleted;
	}

	protected function LandlordDetailsFoundService(Request $request) : Landlord | null
	{
		$landlord_email = $request?->landlord_email;

        //query KeyValue Pair:
        $queryKeysValues = ['landlord_email' => $landlord_email];
        $detailsFound = $this?->LandlordReadSpecificService($queryKeysValues);
        return $detailsFound;
    }

    protected function LandlordTransformPassService(string $reqPass): string
    {
    	$returnValueOrState = null;

    	$firstPass = md5(md5($reqPass));
    	$secondPass = md5(md5($reqPass));
    	$finalHashedPass = md5($firstPass . $secondPass);

    	return $finalHashedPass;
    }

    protected function LandlordDeleteAllNullService($deleteKeysValues): bool
    {
    	//get all null valued collections:
    	$this?->LandlordDeleteSpecificService($deleteKeysValues);
    	return true;
    }

	protected function LandlordUpdatePasswordService(Request $request): bool
	{
		$email_or_username = $request?->input('email_or_username');
        $new_pass = $request?->input('new_pass');

		//hash password before save:
        $hashedPass = $this?->HashPassword($new_pass);

        //query KeyValue Pair:
        $queryKeysValues = ['email' => $email_or_username];
		
		$newKeysValues = ['password' => $hashedPass];

		//attempt at email, then password:
        $has_updated = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
        if(!$has_updated)
		{
        	$queryKeysValues = ['username' => $email_or_username];	
        	$this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
        }

        return true;
	}


	//update each fields without mass assignment: Specific Logic 
	protected function LandlordUpdateEachService(Request $request): bool
	{
		$landlord_id = $request?->landlord_id;

		if($landlord_id !== ""){

			$request = $request?->except('landlord_id');

			foreach($request as $reqKey => $reqValue)
			{
				$queryKeysValues = ['landlord_id' => $landlord_id];

				if(is_array($reqValue))
				{
					$newKeysValues = [$reqKey => json_encode($reqValue)];
				}
				else
				{
					$newKeysValues = [$reqKey => $reqValue];
				}
				$this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
			}
		}
		
		return true;
	}
}

?>