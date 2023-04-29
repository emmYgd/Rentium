<?php

namespace App\Http\Controllers\Validators\Landlord;

trait LandlordPaymentExecuteRequestRules 
{
    protected function viewAllPaymentTransactionDetailsRules(): array
    {
       //set validation rules: payment transaction details for this landlord:
       $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }


    protected function viewWalletDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords', 
        ];

        return $rules;
    }


    protected function makeWithdrawalRequestRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords', 
            'withdrawal_amount' => 'required | numeric',
            'withdrawal_request_category' => 'required | string',
            //'is_amount_approved' => 'required | bool'//defaults to false in db
        ];
                                                                                                                           
        return $rules;
    }

}
