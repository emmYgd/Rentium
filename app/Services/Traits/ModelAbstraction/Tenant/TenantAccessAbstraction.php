<?php

namespace App\Services\Traits\ModelAbstraction\Tenant;

use Illuminate\Http\Request;

use App\Models\Tenant;
use App\Services\Traits\ModelCRUD\TenantCRUD;
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

		$queryKeysValues = ['unique_tenant_id' => $request?->unique_tenant_id];
		$detailsFound = $this?->TenantReadSpecificService($queryKeysValues);

		//get the login state:
		$login_status = $detailsFound['is_logged_in'];
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

	protected function TenantDetailsFoundService(Request $request) : Tenant | null
	{
		$tenant_email = $request?->tenant_email;

        //query KeyValue Pair:
        $queryKeysValues = ['tenant_email' => $tenant_email];
        $were_details_found = $this?->TenantReadSpecificService($queryKeysValues);
        return $were_details_found;
    }


    protected function TenantDeleteAllNullService($deleteKeysValues): bool
    {
    	//get all null valued collections:
    	$were_null_deleted = $this?->TenantDeleteSpecificService($deleteKeysValues);
    	return $were_null_deleted;
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