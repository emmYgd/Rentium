<?php

namespace App\Http\Validators\Tenant;

trait TenantAccessRequestRules 
{
    protected function commentRateRules(): array
    {
        //set validation rules:
        $rules = [
            //the tenant making the request:
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            //the landlord about whom comments and ratings is being made:
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'tenant_comment' => 'required | string',
            'tenant_rating' => 'required | numeric'
        ];

        return $rules;
    }

    protected function viewOtherTenantsCommentsRatingsOnLandlordRules(): array
    {
        //set validation rules:
        $rules = [
            //the tenant making the request:
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            //the landlord about whom comments and ratings are investigated:
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }

}