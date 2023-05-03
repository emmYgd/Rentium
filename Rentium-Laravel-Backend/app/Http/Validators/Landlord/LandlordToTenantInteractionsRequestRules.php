<?php

namespace App\Http\Validators\Landlord;

trait LandlordToTenantInteractionsRequestRules 
{
    protected function searchForTenantRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            //for landlord in search of tenant: any of these will do to search for a tenant:
            'unique_tenant_id' => 'nullable | string| size:10 | exists:tenants | different:unique_landlord_id',
            'tenant_username' => 'nullable | string | different:tenant_email',
            'tenant_email' => 'nullable | string | email | different:tenant_password',
            'tenant_phone_number' => 'nullable | numeric',
        ];

        return $rules;
    }


    protected function sendPropertyInviteRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants', 
            'unique_property_id' => 'required | string | size:10 | exists:propertys',
        ];

        return $rules;
    }
   

    protected function viewTenantPropertyRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants'
        ];

        return $rules;
    }

    
    protected function approveRejectTenantRequestsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'is_request_approved' => 'required | bool',
        ];

        return $rules;
    }

}