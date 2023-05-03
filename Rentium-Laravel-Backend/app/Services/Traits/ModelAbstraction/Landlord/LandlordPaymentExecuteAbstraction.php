<?php

namespace App\Services\Traits\ModelAbstraction;

use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;

use App\Services\Traits\ModelCRUD\Payment\PaymentTransactionCRUD;
use App\Services\Traits\ModelCRUD\Payment\WalletCRUD;
use App\Services\Traits\ModelCRUD\Landlord\WithdrawalRequestCRUD;

trait LandlordPaymentExecuteAbstraction
{
    use PaymentTransactionCRUD;
	use WalletCRUD;
    use WithdrawalRequestCRUD;

	protected function LandlordViewAllPaymentTransactionDetailsService(Request $request): array
	{
        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
        ];

        $paymentTransactionDetails = $this?->PaymentTransactionReadAllLazySpecificService($queryKeysValues);
		return $paymentTransactionDetails->toArray();	
	}


	protected function LandlordViewWalletDetailsService(Request $request): array
	{
		$queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
        ];

        $landlordWalletDetails = $this?->WalletReadSpecificService($queryKeysValues);
		return $landlordWalletDetails;
	}

    protected function LandlordMakeWithdrawalRequestService(Request $request): bool
	{
		$queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
        ];

        //first read the percentage value charge of the withdrawal:
        //Note: This is set by the admin...
        $db_value_charge = $this?->AdminReadSpecificService($queryKeysValues)?->admin_withdrawal_percent_charge;
        $percentage_value_charge = (float)$db_value_charge * 0.01;

        $newKeysValues = [
            'requested_amount' => $request->withdrawal_amount,
            'actual_withdrawal_amount' => $request->withdrawal_amount - $percentage_value_charge,//considering the platform's admin charge
            'withdrawal_request_category' => $request->withdrawal_request_category,
            //'is_admin_approved' => false,//defaults to false in db
        ];

        $was_request_made = $this?->WithdrawalRequestUpdateSpecificService($queryKeysValues, $newKeysValues);
		return $was_request_made;
	}

}

?>