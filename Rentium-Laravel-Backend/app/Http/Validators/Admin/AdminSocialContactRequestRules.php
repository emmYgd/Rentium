<?php

namespace App\Http\Controllers\Validators\Admin;

trait AdminContactRequestRules 
{
    protected function sendLandlordMessageRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'message' => 'required | string',//check for long-text property
            'attachment' => 'nullable | file | between:2,20'
        ];

        return $rules;
    }


    protected function sendTenantMessageRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'message' => 'required | string',//check for long-text property
            'attachment' => 'nullable | file | between:2,20'
        ];

        return $rules;
    }

   
    protected function  readAllLandlordMessagesRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
        ];

        return $rules;
    }

    protected function  readAllTenantMessagesRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
        ];

        return $rules;
    }

}

?>