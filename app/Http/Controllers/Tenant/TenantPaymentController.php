<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Tenant\TenantPaymentInterface;
use App\Services\Traits\ModelAbstraction\Tenant\TenantPaymentAbstraction;
use App\Http\Controllers\Validators\Tenant\TenantPaymentRequestRules;

final class TenantPaymentController extends Controller implements TenantPaymentInterface
{
    use TenantPaymentRequestRules;
    use TenantPaymentAbstraction;
    
    public function __construct()
    {

    }


    //All tenant's bank and card details are encrypted...and well protected
    private function UploadBankAccountDetails(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->uploadBankAccountDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //create without mass assignment:
            $bank_account_details_were_saved = $this->TenantSaveBankAccountDetailsService($request);
            if(!$bank_account_details_were_saved/*false*/)
            {
                throw new Exception("Tenant's Bank Account Details not Saved! Try Again");
            }

             $status = [
                'code' => 1,    
                'serverStatus' => 'BankDetailsSaved!',
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'BankDetailsNotSaved!',
                'short_description' => $ex->getMessage(),
            ];

            return response()->json($status, 400);
        }
        //finally{
            return response()->json($status, 200);
        /*}*/
    }


    private function UploadCardDetails(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->uploadCardDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
         
            //this should return in chunks or paginate:
            $bank_card_details_were_saved = $this->TenantUploadCardDetailsService($request);
            if(!$bank_card_details_were_saved)
            {
                throw new Exception("Tenant's Bank Card Details not Saved! Try Again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'CardDetailsSaved!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'CardDetailsNotSaved!',
                'short_description' => $ex->getMessage()
            ];
            return response()->json($status, 400);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
    }


    private function FetchBankAccountDetails(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->fetchBankAccountDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $bankAccountDetails = $this->TenantFetchBankAccountDetailsService($request);
            
            if(empty($bankAccountDetails))
            {
                throw new Exception("Details Empty, Please Update to get Values!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'FetchSuccess!',
                'bankaccountDetails' => $bankAccountDetails
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'FetchError!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }//finally{
            return response()->json($status, 200);
        //}
    }


    private function FetchBankCardDetailsRule(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->fetchBankCardDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
         
            //this should return in chunks or paginate:
            $bankCardDetails = $this->TenantFetchBankCardDetailsService($request);
            if( empty($bankCardDetails) )
            {
                throw new Exception("No Card Details found!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'FetchSuccess!',
                'buyers' => $bankCardDetails
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'FetchError!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 200);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
    }

}
?>