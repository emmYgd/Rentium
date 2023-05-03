<?php

namespace App\Http\Validators\Landlord;

trait LandlordAccessRequestRules 
{

    protected function registerRules(): array
    {
		//set validation rules:
        $rules = [
            'landlord_first_name' => 'required | string', 
            'landlord_middle_name' => 'string',
            'landlord_last_name' => 'required | string',
            'landlord_phone_number' => 'required | string',
            'landlord_username' => 'nullable | string | different:landlord_email',
            'landlord_email' => 'required | string | email | different:landlord_password',
            'landlord_password' => 'required | string | alpha_num | min:5 | max:15 | different:landlord_phone_number',
            
            'landlord_country' => 'nullable | string | different:landlord_current_state',
            'landlord_current_state'=> 'nullable | string | different:landlord_country,landlord_current_city_or_town',
            'landlord_current_city_or_town' => 'nullable | string | different:landlord_country,landlord_current_state',
            'landlord_current_address' => 'nullable | string | different:landlord_country,landlord_current_state',

            'will_stay_with_tenant' => 'nullable | bool',
            //If landlord will be staying in the same compound with his tenants, the following wiil be required by the tenant:
            'landlord_religion' => 'nullable | string | different:landlord_country,landlord_current_state',
            'landlord_age' => 'nullable | numeric | different:landlord_country,landlord_current_state',
            'landlord_marital_status' => 'nullable | string',

            'landlord_profession' => 'nullable | string',
            'landlord_got_pet' => 'nullable | bool',
            'pet_type' => 'nullable | json', //e.g.: Pets: {'Dogs' : 2, 'Cats': 1} 
        ];

        return $rules;
    }


    protected function loginDashboardRules(): array
    {
		//set validation rules:
        $rules = [
            'landlord_username_or_email' => 'required | string | different:landlord_password',
            'landlord_password' => 'required | string | alpha_num | min:5| max: 15| different:landlord_username_or_email'
        ];

        return $rules;
    }


    protected function confirmLoginStateRules(): array
    {
        $rules =  [
            'unique_landlord_id'=>'required | string | size:10 | exists:landlords',
        ];
        return $rules;
    }


    protected function forgotPasswordRules(): array
    {
        //set validation rules:
        $rules = [
            'email_or_username' => 'required | different:new_password',
            'new_password' => 'required | alpha_num | min:7 | max:15 | different:email_or_username'
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