<?php

namespace App\Http\Controllers\Validators\Landlord;

trait LandlordPaymentRequestRules 
{
  
    
    protected function uploadBankAccountDetailsRules():array
    {
       //set validation rules:
       //Should be encrypted:
       $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'bank_name' => 'required | string',
            'bank_account_first_name'=> 'required | string',
            'bank_account_middle_name'=> 'nullable | string',
            'bank_account_last_name'=> 'required | string',
            'country_of_opening' =>'required | string',
            'currency_of_operation'=> 'required | string',
            'bank_account_type' => 'required | string',//savings, current, domiciliary
            'bank_account_number' => 'required | numeric',
            'bank_account_additional_info' => 'nullable | string'
        ];

        return $rules;
    }


    //Should be decrypted:
    protected function fetchBankAccountDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords', 
        ];

        return $rules;
    }

}
