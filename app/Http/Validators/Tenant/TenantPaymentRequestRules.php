<?php

namespace App\Http\Controllers\Validators\Tenant;

trait TenantPaymentRequestRules 
{
  
    
    protected function uploadBankAccountDetailsRules():array
    {
       //set validation rules:
       //Should be encrypted:
       $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
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


    //Should be encrypted:
    protected function uploadCardDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'bank_card_type' => 'required | string',
            'bank_card_number'=> 'required | numeric',
            'bank_card_cvv' => 'required | numeric',
            'bank_card_expiry_month' => 'required | numeric',
            'bank_card_expiry_year' => 'required | numeric',
        ];

        return $rules;
    }

    //Should be decrypted:
    protected function fetchBankAccountDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants', 
        ];

        return $rules;
    }

    //Should be decrypted:
    protected function fetchBankCardDetailsRule(Request $request): array
    {
        //set validation rules:
        $rules = [
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants', 
        ];

        return $rules;
    }

}
