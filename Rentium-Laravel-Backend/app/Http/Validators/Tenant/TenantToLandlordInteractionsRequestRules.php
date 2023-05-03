<?php

namespace App\Http\Validators\Tenant;

trait TenanttoLandlordInteractionsRequestRules 
{
    protected function searchForLandlordRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string| size:10 | exists:tenants | different:unique_landlord_id,unique_property_id',
            //for tenant in search of landlord: any of these will do to search for a landlord:
            'unique_landlord_id' => 'nullable | string | size:10 | exists:landlords | different:unique_tenant_id,unique_property_id',
            'unique_property_id' => 'nullable | string | size:10 | exists:propertys | different:unique_tenant_id,unique_landlord_id',
            'landlord_username' => 'nullable | string | different:landlord_email',
            'landlord_email' => 'nullable | string | email | different:landlord_password',
            'landlord_phone_number' => 'nullable | numeric',
        ];

        return $rules;
    }


    protected function searchForPropertyInvitationsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants', 
        ];

        return $rules;
    }
   

    protected function showInterestInPropertyInvitationsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'unique_property_id' => 'required | string | size:10 | exists:propertys',
            'is_interest_shown' => 'required | bool',//they might show interest and later change their mind 
        ];

        return $rules;
    }

    
    protected function makePropertyRequestRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'unique_property_id' => 'required | string | size:10 | exists:propertys',
        ];

        return $rules;
    }

}