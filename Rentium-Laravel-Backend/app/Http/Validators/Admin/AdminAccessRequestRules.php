<?php

namespace App\Http\Validators\Admin;

trait AdminAccessRequestRules 
{
	protected function registerRules(): array
    {
		//set validation rules:
        $rules = [
            'admin_first_name' => 'required | string', 
            'admin_middle_name' => 'string',
            'admin_last_name' => 'required | string',
            'admin_phone_number' => 'string',
            'admin_username' => 'string | different:admin_email',
            'admin_email' => 'required | string | email | different:admin_password',
            'admin_password' => 'required | string | alpha_num | min:5 | max:15 | different:admin_password'
        ];

        return $rules;
    }


    protected function loginDashboardRules(): array
    {
		//set validation rules:
        $rules = [
            'admin_username_or_email' => 'required | string | different:admin_password',
            'admin_password' => 'required | string | alpha_num | min:5| max: 15| different:admin_username_or_email'
        ];

        return $rules;
    }


    protected function confirmLoginStateRules(): array
    {
        $rules =  [
            'unique_admin_id'=>'required | exists:admins',
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
            'unique_admin_id' => 'required' //| unique: admins',
        ];

        return $rules;
    }

}

?>