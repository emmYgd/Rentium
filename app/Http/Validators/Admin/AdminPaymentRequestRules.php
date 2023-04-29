<?php

namespace App\Http\Validators\Admin;

trait AdminPaymentRequestRules 
{
	protected function setWithdrawalChargeRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
            'admin_withdrawal_charge' => 'required | numeric',
        ];

        return $rules;
    }


    protected function allLandlordWalletTotalRules(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
        ];

        return $rules;
    }


    protected function totalWithdrawalPayout(): array
    {
		//set validation rules:
        $rules = [
            'unique_admin_id' => 'required | string | size:10 | exists:admins', 
        ];

        return $rules;
    }

}
?>