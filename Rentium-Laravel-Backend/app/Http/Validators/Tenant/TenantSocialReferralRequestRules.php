<?php

namespace App\Http\Controllers\Validators;

trait TenantSocialReferallRequestRules 
{
    protected function generateUniqueReferralLinkRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
        ];

        return $rules;
    }

    //admin can change the referral bonus to any amount after each successful referral transaction...
    protected function getReferralBonusRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
        ];

        return $rules;
    }

    protected function useReferralLinkRules(): array
    {
        //set validation rules:
        $rules = [
            
        ];

        return $rules;
    }
}