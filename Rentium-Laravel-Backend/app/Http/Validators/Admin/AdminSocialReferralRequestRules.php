<?php

namespace App\Http\Controllers\Validators;

trait AdminExtrasRequestRules {


    protected function updateReferralDetailsRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
            'is_referral_prog_activated' => 'required | bool',
            'referral_bonus_currency' => 'required | string',
            'referral_bonus' => 'required | numeric',
        ];
        return $rules;
    }


    protected function fetchReferralDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
        ];

        return $rules;
    }


    protected function disableReferralRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
        ];

        return $rules;
    }

}