<?php

namespace App\Http\Validators\Tenant;

trait TenantAccessRequestRules 
{
	protected function registerRules(): array
    {
		//set validation rules:
        $rules = [
            'tenant_full_name' => 'required | string', 
            'tenant_phone_number' => 'required | string', //e.g. +(234)08056963477 
            'tenant_email' => 'required | string | email | different:tenant_password',
            'tenant_password' => 'required | string | min:5 | max:15 | different:tenant_email,tenant_phone_number',

            'tenant_current_country' => 'nullable | string | different:tenant_current_state',
            'tenant_current_state'=> 'nullable | string | different:tenant_country,tenant_current_city_or_town',
            'tenant_current_city_or_town' => 'nullable | string | different:tenant_country,tenant_current_state',
            'tenant_current_address' => 'nullable | string | different:tenant_country,tenant_current_state',
            
            'tenant_religion' => 'nullable | string | different:tenant_country,tenant_current_state,tenant_current_city_or_town',
            'tenant_age' => 'nullable | numeric',
            'tenant_marital_status' => 'nullable | string', 

            'tenant_profession' => 'nullable | string',
            'tenant_got_pet' => 'nullable | bool',
            'pet_type' => 'nullable | json', //e.g.: Pets: {'Dogs' : 2, 'Cats': 1} */
            'tenant_nin' => 'nullable | string',
        ];

        return $rules;
    }


    protected function loginDashboardRules(): array
    {
		//set validation rules:
        $rules = [
            'tenant_email_or_phone_number' => 'required | string | different:tenant_password',
            'tenant_password' => 'required | string | min:5| max: 15| different:tenant_email_or_phone_number'
        ];

        return $rules;
    }

    
    protected function VerifyAccountRules(): array
    {
        $rules =  [
            'unique_tenant_id'=>'required | string | size:10 | exists:tenants',
            'verify_token' => 'required | string | size:6 | exists:tenants',
        ];
        return $rules;
    }


    protected function sendPassordResetTokenRules(): array
    {
        //set validation rules:
        $rules = [
            'tenant_email' => 'required | string | email | different:new_password | exists:tenants',
        ];

        return $rules;
    }

    protected function implementResetPasswordRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'tenant_email' => 'required | string | email | exists:tenants',
            'tenant_new_password' => 'required | string | min:7 | max:15 | different:pass_reset_token',
            'pass_reset_token' => 'required | string | size:6 |different:tenant_new_password | exists:tenants',
        ];

        return $rules;
    }


    protected function logoutRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
        ];

        return $rules;
    }

}

?>