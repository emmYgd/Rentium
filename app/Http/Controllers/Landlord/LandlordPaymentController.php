<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Landlord\LandlordPaymentInterface;
use App\Services\Traits\ModelAbstraction\Landlord\LandlordPaymentAbstraction;
use App\Http\Controllers\Validators\Landlord\LandlordPaymentRequestRules;

final class LandlordPaymentController extends Controller implements LandlordPaymentInterface
{
    use LandlordPaymentRequestRules;
    use LandlordPaymentAbstraction;
    
    public function __construct()
    {

    }


    //All landlord's bank and card details are encrypted...and well protected
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
            $bank_account_details_were_saved = $this->LandlordSaveBankAccountDetailsService($request);
            if(!$bank_account_details_were_saved/*false*/)
            {
                throw new Exception("Landlord's Bank Account Details not Saved! Try Again");
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

            $bankAccountDetails = $this->LandlordFetchBankAccountDetailsService($request);
            
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

}
?>