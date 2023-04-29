<?php

namespace App\Http\Validators\Admin;

trait AdminLandlordTenantFetchRequestRules 
{
	protected function fetchAllLandlordDetailsRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
        ];

        return $rules;
    }


    protected function fetchAllTenantDetailsRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
        ];

        return $rules;
    }


    protected function fetchEachLandlordDetailRules(): array
    {
        $rules =  [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];
        return $rules;
    }


    protected function fetchEachTenantDetailRules(): array
    {
        $rules =  [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
        ];
        return $rules;
    }

}

?>