<?php

namespace App\Http\Validators\Admin;

trait AdminLandlordTenantGeneralActionRequestRules 
{
	protected function banLandlordRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }


    protected function banTenantRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants'
        ];

        return $rules;
    }


    protected function deleteLandlordRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }


    protected function deleteTenantRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants'
        ];

        return $rules;
    }

}
?>