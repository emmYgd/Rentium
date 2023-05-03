<?php

namespace App\Http\Controllers\Validators\Tenant;

trait TenantContactRequestRules 
{
    protected function sendAdminMessageRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
            'message' => 'required | string',//check for long-text property
            'attachment' => 'nullable | file | between:2,20'
        ];

        return $rules;
    }


    protected function sendLandlordMessageRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'message' => 'required | string',//check for long-text property
            'attachment' => 'nullable | file | between:2,20'
        ];

        return $rules;
    }

   
    protected function  readAllAdminMessagesRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
        ];

        return $rules;
    }

    protected function  readAllLandlordMessagesRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
        ];

        return $rules;
    }

}

?>