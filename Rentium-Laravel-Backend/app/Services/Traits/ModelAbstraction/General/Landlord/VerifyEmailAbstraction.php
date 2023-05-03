<?php

namespace App\Services\Traits\ModelAbstractions\General\Landlord;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Services\Traits\ModelAbstractions\Landlord\LandlordAccessAbstraction;

trait VerifyEmailAbstraction 
{
    use LandlordAccessAbstraction;
    /**
     * Mark the authenticated landlord's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
    protected function LandlordConfirmVerifiedStateViaEmail(string $landlord_email) : bool
	{
        $queryKeysValues = [
            'landlord_email' => $landlord_email
        ];
		$detailsFoundViaEmail = $this?->LandlordReadSpecificService($queryKeysValues);
		//get the verified state:
		$verified_status = $detailsFoundViaEmail['is_email_verified'];

		return $verified_status;
	}

    protected function LandlordConfirmVerifiedStateViaUsername(string $landlord_username) : bool
	{
        $queryKeysValues = [
            'landlord_username' => $landlord_username
        ];
		$detailsFoundViaUsername = $this?->LandlordReadSpecificService($queryKeysValues);
		//get the verified state:
		$verified_status = $detailsFoundViaUsername ['is_email_verified'];

		return $verified_status;
	}

    protected function LandlordConfirmVerifiedStateViaId(string $unique_landlord_id): bool
    {
        $queryKeysValues = [
            'unique_landlord_id' => $unique_landlord_id
        ];
        $detailsFoundViaId = $this?->LandlordReadSpecificService($queryKeysValues);
        //get the verified state:
        $verified_status = $detailsFoundViaId['is_email_verified'];

        return $verified_status;
    }

    protected function LandlordChangeVerifiedState(string $unique_landlord_id): bool
    {
        $queryKeysValues = [
            'unique_landlord_id' => $unique_landlord_id
        ];
        $newKeysValues = ['is_email_verified' => true];
		$is_verified = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);

        return $is_verified;
    }

}
