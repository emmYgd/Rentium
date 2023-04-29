<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Http\Validators\Admin\AdminPaymentRequestRules;

use App\Services\Interfaces\Admin\AdminPaymentInterface;
use App\Services\Traits\ModelAbstraction\Admin\AdminPaymentAbstraction;

final class AdminPaymentController extends Controller implements AdminPaymentInterface
{
    use AdminPaymentRequestRules;
    use AdminPaymentAbstraction;
   

   public function __construct()
   {
      //$this->createAdminDefault();
   }


   private function SetWithdrawalCharge(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->setWithdrawalChargeRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
            
            //this should return in chunks or paginate:
            $withdrawal_charge_was_set = $this->AdminSetWithdrawalChargeService($request);
            if(!$withdrawal_charge_was_set)
            {
                throw new Exception("The Admin Withdrawal Charge Wasn't Set!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'WithdrawalChargeWasSet!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'WithdrawalChargeWasNotSet!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
    }


    private function AllLandlordWalletTotal(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->allLandlordWalletTotalRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
            
            //this should return in chunks or paginate:
            $all_landlord_wallet_total = $this->AdminAllLandlordWalletTotalService($request);
            if(!$all_landlord_wallet_total)
            {
                throw new Exception("Unable to compute all Landlords' total Wallet Balance!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'WalletBalanceTotalComputed!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'WalletBalanceTotalNotComputed!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
   }


   private function TotalWithdrawalPayout(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->totalWithdrawalPayout();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
            
            //this should return in chunks or paginate:
            $totalWithdrawalPayout = $this->AdminTotalWithdrawalPayoutService($request);
            if(!$totalWithdrawalPayout)
            {
                throw new Exception("Unable to compute Landlord total Withdrawal Payout!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'WithdrawalPayoutComputed!',
                'totalWithdrawalPayout' => $totalWithdrawalPayout
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'WithdrawalPayoutNotComputed!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
    }


}
?>