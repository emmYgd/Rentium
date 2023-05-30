<?php

namespace App\Http\Validators\Landlord;

trait LandlordAccessRequestRules 
{
	protected function registerRules(): array
    {
		//set validation rules:
        $rules = [
            'landlord_full_name' => 'required | string', 
            'landlord_phone_number' => 'required | string', //e.g. +(234)08056963477 
            'landlord_email' => 'required | string | email | different:landlord_password',
            'landlord_password' => 'required | string | min:5 | max:15 | different:landlord_email,landlord_phone_number',

            'landlord_current_country' => 'nullable | string | different:landlord_current_state',
            'landlord_current_state'=> 'nullable | string | different:landlord_country,landlord_current_city_or_town',
            'landlord_current_city_or_town' => 'nullable | string | different:landlord_country,landlord_current_state',
            'landlord_current_address' => 'nullable | string | different:landlord_country,landlord_current_state',
            
            'landlord_religion' => 'nullable | string | different:landlord_country,landlord_current_state,landlord_current_city_or_town',
            'landlord_age' => 'nullable | numeric',
            'landlord_marital_status' => 'nullable | string', 

            'landlord_profession' => 'nullable | string',
            'landlord_got_pet' => 'nullable | bool',
            'pet_type' => 'nullable | json', //e.g.: Pets: {'Dogs' : 2, 'Cats': 1} */
            'landlord_nin' => 'nullable | string',
        ];

        return $rules;
    }


    protected function loginDashboardRules(): array
    {
		//set validation rules:
        $rules = [
            'landlord_email_or_phone_number' => 'required | string | different:landlord_password',
            'landlord_password' => 'required | string | min:5| max: 15| different:landlord_email_or_phone_number'
        ];

        return $rules;
    }

    protected function confirmLoginStateRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }
    
    protected function VerifyAccountRules(): array
    {
        $rules =  [
            'unique_landlord_id'=>'required | string | size:10 | exists:landlords',
            'verify_token' => 'required | string | size:6 | exists:landlords',
        ];
        return $rules;
    }


    protected function sendPassordResetTokenRules(): array
    {
        //set validation rules:
        $rules = [
            'landlord_email' => 'required | string | email | different:new_password | exists:landlords',
        ];

        return $rules;
    }

    protected function implementResetPasswordRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'landlord_email' => 'required | string | email | exists:landlords',
            'landlord_new_password' => 'required | string | min:7 | max:15 | different:pass_reset_token',
            'pass_reset_token' => 'required | string | size:6 |different:landlord_new_password | exists:landlords',
        ];

        return $rules;
    }


    protected function logoutRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }

}

?>