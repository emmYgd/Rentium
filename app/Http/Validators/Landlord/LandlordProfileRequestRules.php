<?php

namespace App\Http\Validators\Landlord;

trait LandlordAccessRequestRules 
{
    protected function editImageRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'profile_image' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
        ];

        return $rules;
    }


    protected function editProfileRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'landlord_first_name' => 'nullable | string', 
            'landlord_middle_name' => 'nullable | string',
            'landlord_last_name' => 'nullable | string',
            'landlord_phone_number' => 'nullable | numeric',

            'landlord_username' => 'nullable | string | different:landlord_email',
            'landlord_email' => 'nullable | string | email | different:landlord_password',
            'landlord_password' => 'nullable | string | alpha_num | min:5 | max:15 | different:landlord_password',
            
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
   

    protected function deleteProfileRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }

}