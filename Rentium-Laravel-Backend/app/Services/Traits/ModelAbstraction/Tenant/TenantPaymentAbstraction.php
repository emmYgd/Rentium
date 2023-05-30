<?php

namespace App\Services\Traits\ModelAbstraction;

use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;

use App\Services\Traits\ModelCRUD\Tenant\TenantBankDetailsCRUD;
use App\Models\Tenant\TenantBankDetails;

trait TenantBankandPaymentAbstraction
{
	use TenantBankDetailsCRUD;

	protected function TenantSaveBankAccountDetailsService(Request $request): bool
	{
		$unique_tenant_id = $request?->unique_tenant_id;

        $queryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];

		$newKeysValues = $request?->except('unique_tenant_id');
		//encrypt this new values:
		foreach($newKeysValues as $account_key => $account_value)
		{
			//set decrypted value equivalent:
			$newKeysValues[$account_key] = Crypt::encryptString($account_value);
		}

        //get an instance:
        $bankDetailsModel = $this?->TenantBankDetailsReadSpecificService($queryKeysValues);

        if($bankDetailsModel !== null)
        {
            //update:
            $was_bank_acc_details_updated = $this?->TenantBankDetailsUpdateSpecificService($queryKeysValues, $newKeysValues);
            return $was_bank_acc_details_updated;
        }
        
        //else:
		$was_bank_acc_details_saved = $this->TenantBankDetailsCreateAllService($newKeysValues);
		return $was_bank_acc_details_saved;	
	}


	protected function TenantUploadCardDetailsService($request)
	{
		$unique_tenant_id = $request?->unique_tenant_id;

        $queryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];

		$newKeysValues = $request?->except('unique_tenant_id');
		//encrypt this new values:
		foreach($newKeysValues as $card_key => $card_value)
		{
			//set decrypted value equivalent:
			$newKeysValues[$card_key] = Crypt::encryptString($card_value);
		}

        //get an instance:
        $bankDetailsModel = $this?->TenantBankDetailsReadSpecificService($queryKeysValues);

        if($bankDetailsModel !== null)
        {
            //update:
            $was_bank_card_details_updated = $this?->TenantBankDetailsUpdateSpecificService($queryKeysValues, $newKeysValues);
            return $was_bank_card_details_updated;
        }
        
        //else:
		$was_bank_card_details_saved = $this->TenantBankDetailsCreateAllService($newKeysValues);
		return $was_bank_card_details_saved;	
	}


	protected function TenantFetchBankAccountDetailsService(Request $request)
	{
		$queryKeysValues = [
			'token_id' => $request->token_id
		];
		$tenant_bank_details = $this->TenantBankDetailsReadSpecificService($queryKeysValues);

		$tenant_bank_acc_details = [
			'bank_account_first_name' => Crypt::decryptString($tenant_bank_details->bank_account_first_name),
            'bank_account_middle_name'=> Crypt::decryptString($tenant_bank_details->bank_account_middle_name),
            'bank_account_last_name'=> Crypt::decryptString($tenant_bank_details->bank_account_last_name),
            'country_of_opening' => Crypt::decryptString($tenant_bank_details->country_of_opening),
            'currency_of_operation'=> Crypt::decryptString($tenant_bank_details->currency_of_operation),
            'bank_account_type' => Crypt::decryptString($tenant_bank_details->bank_account_type),//savings, current, domiciliary
            'bank_account_number' => Crypt::decryptString($tenant_bank_details->bank_account_number),
            'bank_account_additional_info' => Crypt::decryptString($tenant_bank_details->bank_account_additional_info),
		];
		return $tenant_bank_acc_details;
	}


	protected function TenantFetchBankCardDetailsService(Request $request)
	{
		$queryKeysValues = [
			'token_id' => $request->token_id
		];
		$tenant_bank_details = $this->TenantBankDetailsReadSpecificService($queryKeysValues);

		$tenant_bank_card_details = [
			'bank_card_type' => Crypt::decryptString($tenant_bank_details->bank_card_type),
            'bank_card_number'=> Crypt::decryptString($tenant_bank_details->bank_card_number),
            'bank_card_cvv'=> Crypt::decryptString($tenant_bank_details->bank_card_cvv),
            'bank_card_expiry_month' => Crypt::decryptString($tenant_bank_details->bank_card_expiry_month),
            'bank_card_expiry_year'=> Crypt::decryptString($tenant_bank_details->bank_card_expiry_year),
		];
		return $tenant_bank_card_details;
	}

}

?>