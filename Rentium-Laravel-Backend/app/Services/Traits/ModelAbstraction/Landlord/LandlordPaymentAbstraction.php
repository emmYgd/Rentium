<?php

namespace App\Services\Traits\ModelAbstraction;

use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;

use App\Services\Traits\ModelCRUD\Landlord\LandlordBankDetailsCRUD;

trait LandlordBankandPaymentAbstraction
{
	use PaymentCRUD;
	use LandlordBankDetailsCRUD;

	protected function LandlordSaveBankAccountDetailsService(Request $request): bool
	{
		$unique_landlord_id = $request?->unique_landlord_id;

        $queryKeysValues = [
            'unique_landlord_id' => $unique_landlord_id,
        ];

		$newKeysValues = $request?->except('unique_landlord_id');
		//encrypt this new values:
		foreach($newKeysValues as $account_key => $account_value)
		{
			//set decrypted value equivalent:
			$newKeysValues[$account_key] = Crypt::encryptString($account_value);
		}

        //get an instance:
        $bankDetailsModel = $this?->LandlordBankDetailsReadSpecificService($queryKeysValues);

        if($bankDetailsModel !== null)
        {
            //update:
            $was_bank_acc_details_updated = $this?->LandlordBankDetailsUpdateSpecificService($queryKeysValues, $newKeysValues);
            return $was_bank_acc_details_updated;
        }
        
        //else:
		$was_bank_acc_details_saved = $this->LandlordBankDetailsCreateAllService($newKeysValues);
		return $was_bank_acc_details_saved;	
	}


	protected function LandlordFetchBankAccountDetailsService(Request $request)
	{
		$queryKeysValues = [
			'token_id' => $request->token_id
		];
		$landlord_bank_details = $this->LandlordBankDetailsReadSpecificService($queryKeysValues);

		$landlord_bank_acc_details = [
			'bank_account_first_name' => Crypt::decryptString($landlord_bank_details->bank_account_first_name),
            'bank_account_middle_name'=> Crypt::decryptString($landlord_bank_details->bank_account_middle_name),
            'bank_account_last_name'=> Crypt::decryptString($landlord_bank_details->bank_account_last_name),
            'country_of_opening' => Crypt::decryptString($landlord_bank_details->country_of_opening),
            'currency_of_operation'=> Crypt::decryptString($landlord_bank_details->currency_of_operation),
            'bank_account_type' => Crypt::decryptString($landlord_bank_details->bank_account_type),//savings, current, domiciliary
            'bank_account_number' => Crypt::decryptString($landlord_bank_details->bank_account_number),
            'bank_account_additional_info' => Crypt::decryptString($landlord_bank_details->bank_account_additional_info),
		];
		return $landlord_bank_acc_details;
	}

}

?>