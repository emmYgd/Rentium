<?php

namespace App\Http\Validators\Admin;

trait AdminAccessRequestRules 
{
    protected function editImageRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_admin_id' => 'required | exists:admins',
            'profile_image' => 'nullable | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
        ];

        return $rules;
    }


    protected function editProfileRules(): array
    {
        //set validation rules:
        $rules = [
            'admin_id' => 'required | unique:admins',
            'admin_org' => 'nullable | string | min:5 | max:1000',
            'vision' => 'nullable | string | different:admin_org',
            'mission' => 'nullable | string | different:vision,admin_org',
            'year_of_establishment' => 'nullable | numeric',
            'industry' => 'nullable',
        ];

        return $rules;
    }
   

    protected function deleteProfileRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_admin_id' => 'required | exists:admins',
        ];

        return $rules;
    }

}