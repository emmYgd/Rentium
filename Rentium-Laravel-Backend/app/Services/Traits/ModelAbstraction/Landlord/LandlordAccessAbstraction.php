<?php

namespace App\Services\Traits\ModelAbstraction\Landlord;

use Illuminate\Http\Request;

use App\Models\Landlord\Landlord;
use App\Services\Traits\ModelCRUD\Landlord\LandlordCRUD;
use App\Services\Traits\Utilities\PassHashVerifyService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


trait LandlordAccessAbstraction
{	
	//inherits all their methods:
	use LandlordCRUD;
	use ComputeUniqueIDService;
	use PassHashVerifyService;

	protected function LandlordConfirmLoginStateService(Request $request) : bool | null
	{
		$foundDetail = $this->LandlordFoundDetailService($request);
		if(!$foundDetail)
		{
			throw new \Exception("Cannot find Landlord details");
		}
		//get the login state:
		$login_status = $foundDetail?->is_logged_in;
		return $login_status;
	}

	protected function LandlordConfirmVerifiedStateService(Request $request) : bool
	{
		$foundDetail = $this->LandlordFoundDetailService($request);
		if(!$foundDetail)
		{
			throw new \Exception("Cannot find Landlord details");
		}
		//get the login state:
		$verified_status = $foundDetail?->is_email_verified;
		return $verified_status;
	}
	
	protected function LandlordLogoutService(Request $request): bool
	{
		//init:
		$queryKeysValues = array();

		$unique_landlord_id = $request?->unique_landlord_id;
		$landlord_email = $request?->landlord_email;

		if($unique_landlord_id)
		{
			$queryKeysValues = [
				'unique_landlord_id' => $unique_landlord_id,
			];
		}

		if($landlord_email)
		{
			$queryKeysValues = [
				'landlord_email' => $landlord_email,
			];
		}

		$newKeysValues = [
			'is_logged_in' => false
		];

		$was_logout_status_ensured = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);

		return $was_logout_status_ensured;
	}


	protected function LandlordRegisterService(Request $request): bool
	{
		$newKeyValues = $request?->all();
		//create new landlord:
		$were_details_saved = $this?->LandlordCreateAllService($newKeyValues);
		return $were_details_saved;
	}


	protected function LandlordDeleteSpecificService($deleteKeysValues): bool
	{
		$were_details_deleted = $this?->LandlordDeleteSpecificService($deleteKeysValues);
		return $were_details_deleted;
	}


	protected function LandlordAuthenticateService(Request $request) : Landlord | null
	{
		$landlord_email_or_phone_number = $request?->landlord_email_or_phone_number;
		
		//query KeyValue Pair:
		//first check for email:
		$queryKeysValues = [
			'landlord_email' => $landlord_email_or_phone_number,
		];
		$foundDetail = $this?->LandlordReadSpecificService($queryKeysValues);
		if(!$foundDetail)
		{
			//query KeyValue Pair:
			$queryKeysValues = [
				'landlord_phone_number' => $landlord_email_or_phone_number,
			];
			$foundDetail = $this?->LandlordReadSpecificService($queryKeysValues);
			if(!$foundDetail)
			{
				throw new \Exception("Failed login attempt. Invalid Email or Phone Number Provided!");
			}
		}

		//else: continue with password Auth
		//verify password against the hashed password in the database:
        $dbHashedPass = $foundDetail->landlord_password;
		$requestPass = $request->landlord_password;
		$was_pass_verified = $this?->CustomVerifyPassword($requestPass, $dbHashedPass);
		if(!$was_pass_verified)
		{
			throw new \Exception("Failed login attempt. Invalid Password Provided!");
		}
		//else:
        return $foundDetail;
    }


	protected function LandlordFoundDetailService(Request $request): Landlord | bool | null
	{
		//init:
		$queryKeysValues = array();
		$foundDetail = null;

		$unique_landlord_id = $request?->unique_landlord_id;
		$landlord_email = $request?->landlord_email;
		$landlord_phone_number = $request?->landlord_phone_number;

		$landlord_email_or_phone_number = $request?->landlord_email_or_phone_number;

		if($unique_landlord_id)
		{
			$queryKeysValues = [
				'unique_landlord_id' => $unique_landlord_id,
			];
			$foundDetail = $this?->LandlordReadSpecificService($queryKeysValues);
			if(!$foundDetail)
			{
				return false;
			}
		}

		if($landlord_email)
		{
			$queryKeysValues = [
				'landlord_email' => $landlord_email,
			];
			$foundDetail = $this?->LandlordReadSpecificService($queryKeysValues);
			if(!$foundDetail)
			{
				return false;
			}
		}

		if($landlord_phone_number)
		{
			$queryKeysValues = [
				'landlord_phone_number' => $landlord_phone_number,
			];
			$foundDetail = $this?->LandlordReadSpecificService($queryKeysValues);
			if(!$foundDetail)
			{
				return false;
			}
		}

		if($landlord_email_or_phone_number)
		{
			$queryKeysValues = [
				'landlord_email' => $landlord_email_or_phone_number
			];
			$foundDetail = $this?->LandlordReadSpecificService($queryKeysValues);
			if(!$foundDetail)
			{
				$queryKeysValues = [
					'landlord_phone_number' => $landlord_email_or_phone_number
				];
				$foundDetail = $this?->LandlordReadSpecificService($queryKeysValues);
				if(!$foundDetail)
				{
					return false;
				}
			}
		}

		return $foundDetail;
	}


    protected function LandlordDeleteAllNullService($deleteKeysValues): bool
    {
    	//get all null valued collections:
    	$were_all_null_deleted = $this?->LandlordDeleteSpecificService($deleteKeysValues);
    	return $were_all_null_deleted;
    }


	protected function LandlordUpdatePasswordService(Request $request): bool
	{
		$email_or_username = $request?->email_or_username;
        $new_pass = $request?->new_password;

		//hash password before save:
        $hashedPass = $this?->HashPassword($new_pass);

        //query KeyValue Pair:
        $queryKeysValues = [
			'email' => $email_or_username
		];
		
		$newKeysValues = [
			'password' => $hashedPass
		];

		//attempt at email, then password:
        $password_was_updated = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
        if(!$password_was_updated)
		{
        	$queryKeysValues = [
				'username' => $email_or_username
			];	
        	$password_was_updated = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
			if(!$password_was_updated)
			{
				return false;
			}
		}

        return true;
	}

}

?>