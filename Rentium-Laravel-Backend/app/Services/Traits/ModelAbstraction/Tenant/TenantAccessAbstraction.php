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
		$foundDetail  = $this?->TenantReadSpecificService($queryKeysValues);

		//get the login state:
		$login_status = $foundDetail ['is_logged_in'];
		return $login_status;
	}


	protected function TenantLogoutService(Request $request): bool
	{
		$queryKeysValues = [
			'unique_tenant_id' => $request?->unique_tenant_id
		];
		$newKeysValues = [
			'is_logged_in' => false
		];
		$was_logged_out = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);

		return $was_logged_out;
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
		$tenant_username_or_email = $request?->tenant_username_or_email;
		
		//query KeyValue Pair:
		//first check for email:
		$queryKeysValues = [
			'tenant_email' => $tenant_username_or_email,
		];
		$foundDetail = $this?->TenantReadSpecificService($queryKeysValues);
		if(!$foundDetail)
		{
			//query KeyValue Pair:
			$queryKeysValues = [
				'tenant_username' => $tenant_username_or_email,
			];
			$foundDetail = $this?->TenantReadSpecificService($queryKeysValues);
			if(!$foundDetail)
			{
				throw new Exception("Failed login attempt. Invalid Email or Username Provided!");
			}
		}

		//else: continue with password Auth
		//verify password against the hashed password in the database:
        $dbHashedPass = $foundDetail->tenant_password;
		$requestPass = $request->tenant_password;
		$was_pass_verified = $this?->CustomVerifyPassword($requestPass, $dbHashedPass);
		if(!$was_pass_verified)
		{
			throw new Exception("Failed login attempt. Invalid Password Provided!");
		}
		//else:
        return $foundDetail;
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