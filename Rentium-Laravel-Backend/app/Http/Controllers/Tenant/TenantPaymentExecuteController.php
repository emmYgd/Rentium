<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Tenant\TenantPaymentExecuteInterface;
use App\Http\Controllers\Validators\Tenant\TenantPaymentExecuteRequestRules;
use App\Services\Traits\ModelAbstraction\Tenant\TenantPaymentExecuteAbstraction;

final class TenantPaymentExecuteController extends Controller implements TenantPaymentExecuteInterface
{
   use TenantPaymentExecuteAbstraction;
   use TenantPaymentExecuteRequestRules;

   public function __construct()
   {
        //$this->createTenantDefault();
   }


   private function MakePaymentByNewBankAccount(Request $request): JsonResponse
   {
      $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->makePaymentByNewBankAccount();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
            
            $paymentTransactionDetails = $this->TenantMakePaymentByNewBankAccountService($request);

            if( 
                empty($paymentTransactionDetails) || 
                !$paymentTransactionDetails['payment_was_made'] ||
                !$paymentTransactionDetails
            )
            {
                throw new Exception("Error! Payment Transaction Unsuccessful!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'PaymentTransactionSuccess!',
                'paymentTransactionDetails' => $paymentTransactionDetails
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PaymentTransactionError!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
      /*finally
      {*/
         return response()->json($status, 200);
      //}
    }


    private function MakePaymentBySavedBankAccount(Request $request): JsonResponse
    {
       $status = array();
 
        try
        {
            //get rules from validator class:
            $reqRules = $this->makePaymentBySavedBankAccount();
 
            //validate here:
            $validator = Validator::make($request->all(), $reqRules);
 
            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
             
            $paymentTransactionDetails = $this->TenantMakePaymentBySavedBankAccountService($request);
            if( 
                empty($paymentTransactionDetails) || 
                !$paymentTransactionDetails['payment_was_made'] ||
                !$paymentTransactionDetails
            )
            {
                throw new Exception("Error! Payment Transaction Unsuccessful!");
            }
 
            $status = [
                'code' => 1,
                'serverStatus' => 'PaymentTransactionSuccess!',
                'paymentTransactionDetails' => $paymentTransactionDetails
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PaymentTransactionError!',
                'short_description' => $ex->getMessage()
            ];
 
            return response()->json($status, 400);
        }
       /*finally
       {*/
          return response()->json($status, 200);
       //}
    }


    private function MakePaymentByNewBankCard(Request $request): JsonResponse
    {
       $status = array();
 
       try
       {
            //get rules from validator class:
            $reqRules = $this->makePaymentByNewBankCardRules();
 
            //validate here:
            $validator = Validator::make($request->all(), $reqRules);
 
            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
          
          
            $paymentTransactionDetails = $this->TenantMakePaymentByNewBankCardService($request);
            if( 
                empty($paymentTransactionDetails) || 
                !$paymentTransactionDetails['payment_was_made'] ||
                !$paymentTransactionDetails
            )
            {
                throw new Exception("Error! Payment Transaction Unsuccessful!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'PaymentTransactionSuccess!',
                'paymentTransactionDetails' => $paymentTransactionDetails
            ];
       }
       catch(Exception $ex)
       {
            $status = [
                'code' => 0,
                'serverStatus' => 'PaymentTransactionError!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
       }
       /*finally
       {*/
          return response()->json($status, 200);
       //}
    }


    private function MakePaymentBySavedBankCard(Request $request): JsonResponse
    {
       $status = array();
 
       try
       {
            //get rules from validator class:
            $reqRules = $this->makePaymentBySavedBankCardRules();
 
            //validate here:
            $validator = Validator::make($request->all(), $reqRules);
 
            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
          
          
            $paymentTransactionDetails = $this->TenantMakePaymentBySavedBankCardService($request);
            if( 
                empty($paymentTransactionDetails) || 
                !$paymentTransactionDetails['payment_was_made'] ||
                !$paymentTransactionDetails
            )
            {
                throw new Exception("Error! Payment Transaction Unsuccessful!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'PaymentTransactionSuccess!',
                'paymentTransactionDetails' => $paymentTransactionDetails
            ];
       }
       catch(Exception $ex)
       {
            $status = [
                'code' => 0,
                'serverStatus' => 'PaymentTransactionError!',
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
 
