<?php

namespace App\Services\Traits\ModelAbstraction\General\Tenant;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Services\Traits\ModelAbstraction\Tenant\TenantAccessAbstraction;

trait VerifyEmailAbstraction 
{
    use TenantAccessAbstraction;
    /**
     * Mark the authenticated tenant's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
    protected function TenantConfirmVerifiedStateViaEmail(string $tenant_email) : bool
	{
        $queryKeysValues = [
            'tenant_email' => $tenant_email
        ];
		$detailsFoundViaEmail = $this?->TenantReadSpecificService($queryKeysValues);
		//get the verified state:
		$verified_status = $detailsFoundViaEmail['is_email_verified'];

		return $verified_status;
	}

    protected function TenantConfirmVerifiedStateViaUsername(string $tenant_username) : bool
	{
        $queryKeysValues = [
            'tenant_username' => $tenant_username
        ];
		$detailsFoundViaUsername = $this?->TenantReadSpecificService($queryKeysValues);
		//get the verified state:
		$verified_status = $detailsFoundViaUsername ['is_email_verified'];

		return $verified_status;
	}

    protected function TenantConfirmVerifiedStateViaId(string $unique_tenant_id): bool
    {
        $queryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id
        ];
        $detailsFoundViaId = $this?->TenantReadSpecificService($queryKeysValues);
        //get the verified state:
        $verified_status = $detailsFoundViaId['is_email_verified'];

        return $verified_status;
    }

    protected function TenantChangeVerifiedState(string $unique_tenant_id): bool
    {
        $queryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id
        ];
        $newKeysValues = ['is_email_verified' => true];
		$is_verified = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);

        return $is_verified;
    }

}
