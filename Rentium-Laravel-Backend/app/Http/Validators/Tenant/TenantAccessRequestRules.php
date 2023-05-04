<?php

namespace App\Http\Validators\Tenant;

trait TenantAccessRequestRules 
{
	protected function registerRules(): array
    {
		//set validation rules:
        $rules = [
            'tenant_first_name' => 'required | string', 
            'tenant_middle_name' => 'nullable | string',
            'tenant_last_name' => 'required | string',
            'tenant_phone_number' => 'required | string',

            /*'tenant_username' => 'nullable | string | different:tenant_email',
            'tenant_email' => 'required | string | email | different:tenant_password',
            'tenant_password' => 'required | string | alpha_num | min:5 | max:15 | different:tenant_email,tenant_username,tenant_phone_number',

            /*'tenant_current_country' => 'nullable | string | different:tenant_current_state',
            'tenant_current_state'=> 'nullable | string | different:tenant_country,tenant_current_city_or_town',
            'tenant_current_city_or_town' => 'nullable | string | different:tenant_country,tenant_current_state',
            'tenant_current_address' => 'nullable | string | different:tenant_country,tenant_current_state',
            
            'tenant_religion' => 'nullable | string | different:tenant_country,tenant_current_state,tenant_current_city_or_town',
            'tenant_age' => 'nullable | numeric',
            'tenant_marital_status' => 'nullable | string', 

            'tenant_profession' => 'nullable | string',
            'tenant_got_pet' => 'nullable | bool',
            'pet_type' => 'nullable | json', //e.g.: Pets: {'Dogs' : 2, 'Cats': 1} */
        ];

        return $rules;
    }


    protected function loginDashboardRules(): array
    {
		//set validation rules:
        $rules = [
            'tenant_username_or_email' => 'required | string | different:tenant_password',
            'tenant_password' => 'required | string | alpha_num | min:5| max: 15| different:tenant_username_or_email'
        ];

        return $rules;
    }


    protected function confirmLoginStateRules(): array
    {
        $rules =  [
            'unique_tenant_id'=>'required | exists:tenants',
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
            'unique_tenant_id' => 'required' //| unique: tenants',
        ];

        return $rules;
    }

}

?>