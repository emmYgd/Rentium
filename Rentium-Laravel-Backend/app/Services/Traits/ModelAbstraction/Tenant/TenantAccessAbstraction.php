<?php

namespace App\Services\Traits\ModelAbstraction\Tenant;

use Illuminate\Http\Request;

use App\Models\Tenant\Tenant;
use App\Services\Traits\ModelCRUD\Tenant\TenantCRUD;
use App\Services\Traits\Utilities\PassHashVerifyService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


trait TenantAccessAbstraction
{	
	//inherits all their methods:
	use TenantCRUD;
	use ComputeUniqueIDService;
	use PassHashVerifyService;


	protected function TenantConfirmLoginStateService(Request $request) : bool
	{
		$queryKeysValues = [
			'unique_tenant_id' => $request?->unique_tenant_id
		];
		$foundDetail = $this?->TenantReadSpecificService($queryKeysValues);

		//get the login state:
		$login_status = $foundDetail?->is_logged_in;
		return $login_status;
	}


	protected function TenantLogoutService(Request $request): bool
	{
		//init:
		$queryKeysValues = array();

		$unique_tenant_id = $request?->unique_tenant_id;
		$tenant_email = $request?->tenant_email;

		if($unique_tenant_id)
		{
			$queryKeysValues = [
				'unique_tenant_id' => $unique_tenant_id,
			];
		}

		if($tenant_email)
		{
			$queryKeysValues = [
				'tenant_email' => $tenant_email,
			];
		}

		$newKeysValues = [
			'is_logged_in' => false
		];

		$was_logout_status_ensured = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);

		return $was_logout_status_ensured;
	}


	protected function TenantRegisterService(Request $request): bool
	{
		$newKeyValues = $request?->all();
		//create new tenant:
		$were_details_saved = $this?->TenantCreateAllService($newKeyValues);
		return $were_details_saved;
	}


	protected function TenantDeleteSpecificService($deleteKeysValues): bool
	{
		$were_details_deleted = $this?->TenantDeleteSpecificService($deleteKeysValues);
		return $were_details_deleted;
	}


	protected function TenantAuthenticateService(Request $request) : Tenant | null
	{
		$tenant_email_or_phone_number = $request?->tenant_email_or_phone_number;
		
		//query KeyValue Pair:
		//first check for email:
		$queryKeysValues = [
			'tenant_email' => $tenant_email_or_phone_number,
		];
		$foundDetail = $this?->TenantReadSpecificService($queryKeysValues);
		if(!$foundDetail)
		{
			//query KeyValue Pair:
			$queryKeysValues = [
				'tenant_phone_number' => $tenant_email_or_phone_number,
			];
			$foundDetail = $this?->TenantReadSpecificService($queryKeysValues);
			if(!$foundDetail)
			{
				throw new \Exception("Failed login attempt. Invalid Email or Phone Number Provided!");
			}
		}

		//else: continue with password Auth
		//verify password against the hashed password in the database:
        $dbHashedPass = $foundDetail->tenant_password;
		$requestPass = $request->tenant_password;
		$was_pass_verified = $this?->CustomVerifyPassword($requestPass, $dbHashedPass);
		if(!$was_pass_verified)
		{
			throw new \Exception("Failed login attempt. Invalid Password Provided!");
		}
		//else:
        return $foundDetail;
    }


	protected function TenantFoundDetailService(Request $request): Tenant | bool
	{
		//init:
		$queryKeysValues = array();
		$foundDetail = null;

		$unique_tenant_id = $request?->unique_tenant_id;
		$tenant_email = $request?->tenant_email;
		$tenant_phone_number = $request?->tenant_phone_number;

		$tenant_email_or_phone_number = $request?->tenant_email_or_phone_number;

		if($unique_tenant_id)
		{
			$queryKeysValues = [
				'unique_tenant_id' => $unique_tenant_id,
			];
		}

		if($tenant_email)
		{
			$queryKeysValues = [
				'tenant_email' => $tenant_email,
			];
		}

		if(!$tenant_phone_number)
		{
			$queryKeysValues = [
				'tenant_phone_number' => $tenant_phone_number,
			];
		}

		if($tenant_email_or_phone_number)
		{
			$queryKeysValues = [
				'tenant_email' => $tenant_email_or_phone_number
			];
			$foundDetail = $this?->TenantReadSpecificService($queryKeysValues);
			if(!$foundDetail)
			{
				$queryKeysValues = [
					'tenant_phone_number' => $tenant_email_or_phone_number
				];
				$foundDetail = $this?->TenantReadSpecificService($queryKeysValues);
				if(!$foundDetail)
				{
					return false;
				}
			}
		}
		
		$foundDetail = $this?->TenantReadSpecificService($queryKeysValues);
		if(!$foundDetail)
		{
			return false;
		}

		//finally, get the login state:
		$login_status = $foundDetail?->is_logged_in;
		return $login_status;
	}


    protected function TenantDeleteAllNullService($deleteKeysValues): bool
    {
    	//get all null valued collections:
    	$were_all_null_deleted = $this?->TenantDeleteSpecificService($deleteKeysValues);
    	return $were_all_null_deleted;
    }


	protected function TenantUpdatePasswordService(Request $request): bool
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
        $password_was_updated = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);
        if(!$password_was_updated)
		{
        	$queryKeysValues = [
				'username' => $email_or_username
			];	
        	$password_was_updated = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);
			if(!$password_was_updated)
			{
				return false;
			}
		}

        return true;
	}


}

?>