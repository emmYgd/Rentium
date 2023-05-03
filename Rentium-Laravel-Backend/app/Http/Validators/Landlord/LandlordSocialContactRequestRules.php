<?php

namespace App\Http\Controllers\Validators\Landlord;

trait LandlordContactRequestRules 
{
    protected function sendAdminMessageRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
            'message' => 'required | string',//check for long-text property
            'attachment' => 'nullable | file | between:2,20'
        ];

        return $rules;
    }


    protected function sendTenantMessageRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'message' => 'required | string',//check for long-text property
            'attachment' => 'nullable | file | between:2,20'
        ];

        return $rules;
    }

   
    protected function  readAllAdminMessagesRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }

    protected function  readAllTenantMessagesRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }

}

?>