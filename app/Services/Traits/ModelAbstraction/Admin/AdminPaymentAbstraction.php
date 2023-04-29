<?php

namespace App\Services\Traits\ModelAbstraction\Admin;

use Illuminate\Http\Request;

use App\Models\Admin\Admin;
use App\Services\Traits\ModelCRUD\Admin\AdminCRUD;
use App\Services\Traits\ModelCRUD\Landlord\LandlordCRUD;
use App\Services\Traits\ModelCRUD\Payment\PaymentCRUD;

trait AdminPaymentAbstraction
{	
	//inherits all their methods:
	use AdminCRUD;
    use LandlordCRUD;
    use PaymentCRUD;

	protected function AdminSetWithdrawalChargeService(Request $request): bool
	{
        if( 
            ($request?->unique_admin_id == null) || 
            ($request?->unique_admin_id == "") 
        )
        {
            throw new Exception("Error! Not an Admin!");
        }

        $queryKeysValues = [
            'unique_admin_id' => $request?->unique_admin_id,
        ];

        $newKeysValues = [
            'admin_withdrawal_charge' => $request?->admin_withdrawal_charge,
        ];
		$was_withdrawal_charge_set = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);

		return $was_withdrawal_charge_set;
	}


	protected function AdminAllLandlordWalletTotalService(Request $request): float
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        //read all wallet details:
		$all_wallet_details = $this?->WalletReadAllLazyService();
        //get the sum of all balance:
        $casted_wallet_balance = (float) $all_wallet_details->sum('current_wallet_balance');
        return $casted_wallet_balance;
	}


    protected function AdminTotalWithdrawalPayoutService(Request $request): float
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        $queryKeysValues = [
            'is_admin_approve' => true,
        ];
		$all_withdrawal_request_details = $this?->WithdrawalRequestReadAllLazySpecificService($queryKeysValues);
        //get the sum of all balance:
        $casted_total_withdrawal_payout = (float) $all_withdrawal_request_details->sum('actual_withdrawal_amount');
		return $casted_total_withdrawal_payout;
	}

}

?>