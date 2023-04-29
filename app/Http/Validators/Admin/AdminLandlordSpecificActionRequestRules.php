<?php

namespace App\Http\Validators\Admin;

trait AdminLandlordSpecificActionRequestRules 
{
	protected function viewAllUnApprovedLandlordWithdrawalRequestsRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
        ];

        return $rules;
    }


    protected function viewAllApprovedLandlordWithdrawalRequestsRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
        ];

        return $rules;
    }


    protected function approveLandlordWithdrawalRequestRules(): array
    {
        $rules =  [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];
        return $rules;
    }

}

?>