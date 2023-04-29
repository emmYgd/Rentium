<?php

namespace App\Http\Validators\Tenant;

trait TenantAccessRequestRules 
{
    protected function editImageRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | exists:tenants',
            'profile_image' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
        ];

        return $rules;
    }


    protected function editProfileRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'tenant_first_name' => 'nullable | string', 
            'tenant_middle_name' => 'nullable | string',
            'tenant_last_name' => 'nullable | string',
            'tenant_phone_number' => 'nullable | string',

            'tenant_username' => 'nullable | string | different:tenant_email',
            'tenant_email' => 'nullable | string | email | different:tenant_password',
            'tenant_password' => 'nullable | string | alpha_num | min:5 | max:15 | different:tenant_phone_number',
            
            'tenant_current_ country' => 'nullable | string | different:tenant_current_state',
            'tenant_current_state'=> 'nullable | string | different:tenant_country,tenant_current_city_or_town',
            'tenant_current_city_or_town' => 'nullable | string | different:tenant_country,tenant_current_state',
            'tenant_current_address' => 'nullable | string | different:tenant_country,tenant_current_state',
            'tenant_religion' => 'nullable | string | different:tenant_country,tenant_current_state',
            'tenant_age' => 'nullable | numeric | different:tenant_country,tenant_current_state',
            'tenant_marital_status' => 'nullable | string',

            'tenant_profession' => 'nullable | string',
            'tenant_got_pet' => 'nullable | bool',
            'pet_type' => 'nullable | json', //e.g.: Pets: {'Dogs' : 2, 'Cats': 1} 
        ];

        return $rules;
    }
   

    protected function deleteProfileRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | exists:tenants',
        ];

        return $rules;
    }

}