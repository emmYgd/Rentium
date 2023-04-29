<?php

namespace App\Http\Controllers\Validators\Tenant;

trait TenantHouseFetchDetailsRequestRules 
{
    protected function fetchAllHousingDetailsByCategoryRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'property_location' => 'nullable | string',
            'property_price_range' => 'nullable | json',
            'property_type' => 'nullable | string', //bungalow, duplex, mini-flat
            'property_tenant_religion' => 'nullable | string',
        ];

        return $rules;
    }


    protected function fetchEachHousingDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'unique_landlord_id'=> 'nullable | string | size:10 | exists:landlords',
            'unique_property_id' => 'required | string | size:10 | exists:propertys',
        ];

        return $rules;
    }
    
}

?>