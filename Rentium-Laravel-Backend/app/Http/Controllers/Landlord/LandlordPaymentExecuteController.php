<?php

namespace App\Http\Controllers\Landlord;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Landlord\LandlordPaymentExecuteInterface;
use App\Http\Controllers\Validators\Landlord\LandlordPaymentExecuteRequestRules;
use App\Services\Traits\ModelAbstraction\Landlord\LandlordPaymentExecuteAbstraction;

final class LandlordPaymentExecuteController extends Controller implements LandlordPaymentExecuteInterface
{
   use LandlordPaymentExecuteAbstraction;
   use LandlordPaymentExecuteRequestRules;

   public function __construct()
   {
        //$this->createBuyerDefault();
   }


   //In this note, a landlord wallet will be created to record amount gained by the landlord
   private function ViewPaymentTransactionDetails(Request $request): JsonResponse
   {
      $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->viewAllPaymentTransactionDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);   

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
            
            $allPaymentTransactionDetails = $this->LandlordViewAllPaymentTransactionDetailsService($request);

            if( empty($allPaymentTransactionDetails) )
            {
                throw new Exception("Error! Payment transaction details not found!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'PaymentTransactionsFound!',
                'paymentTransactionDetails' => $allPaymentTransactionDetails
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PaymentTransactionsNotFound!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
      /*finally
      {*/
         return response()->json($status, 200);
      //}
    }


    private function ViewWalletDetails(Request $request): JsonResponse
    {
      $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->viewWalletDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);   

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
            
            $walletDetails = $this->LandlordViewWalletDetailsService($request);

            if( empty($walletDetails) )
            {
                throw new Exception("Error! Payment transaction details not found!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'WalletDetailsFound!',
                'paymentTransactionDetails' => $walletDetails
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'WalletDetailsNotFound!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
      /*finally
      {*/
         return response()->json($status, 200);
      //}
    }


    //first display the summary of all pending(not paid yet) or cleared cart(paid)
    private function MakeWithdrawalRequest(Request $request): JsonResponse
    {
       $status = array();
 
       try
       {
            //get rules from validator class:
            $reqRules = $this->makeWithdrawalRequestRules();
 
            //validate here:
            $validator = Validator::make($request->all(), $reqRules);
 
            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
          
          
            $withdrawal_request_was_made = $this->LandlordMakeWithdrawalRequestService($request);
            if(!$withdrawal_request_was_made /*false*/)
            {
                throw new Exception("Withdrawal Request Not Made! Pls try again");
            }
 
            $status = [
                'code' => 1,
                'serverStatus' => 'WithdrawalRequestWasMade!',
            ];
       }
       catch(Exception $ex)
       {
            $status = [
                'code' => 0,
                'serverStatus' => 'WithdrawalRequestWasMade!',
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
 
