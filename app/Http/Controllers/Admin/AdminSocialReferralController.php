<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Validators\Admin\AdminReferralRequestRules;
use App\Services\Interfaces\Admin\AdminReferralInterface;
use App\Services\Traits\ModelAbstraction\Admin\AdminReferralAbstraction;

final class AdminSocialReferralController extends Controller implements AdminReferralInterface
{
   use AdminReferralAbstraction;
   use AdminReferralRequestRules;

   public function __construct()
   {
        //$this->createAdminDefault();
   }


   private function UpdateReferralDetails(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->updateReferralDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
            
            $ref_state_was_updated = $this->AdminUpdateReferralDetailsService($request);
                if(! $ref_state_was_updated)
                {
                    throw new Exception("Admin couldn't change referral program status! Try Again!");
                }

            $status = [
                'code' => 1,
                'serverStatus' => 'referralDetailsSaved!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'referralDetailsNotSaved!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
   }

   
   private function FetchReferralDetails(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->fetchReferralDetailsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Access Error, Not logged in yet!");
            }
            
            //this should return in chunks or paginate:
            $referralDetailsFound = $this->AdminFetchReferralDetailsService($request);
            if( empty($referralDetailsFound) )
            {
                throw new Exception("Couldn't find any Referral Details!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'FetchSuccess!',
                'referral_details' => $referralDetailsFound
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
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
   }


   private function DisableReferralProgram(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->disableReferralRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Access Error, Not logged in yet!");
            }
            
            //this should return in chunks or paginate:
            $ref_program_was_disabled = $this->AdminDisableReferralProgramService($request);
            if(!$ref_program_was_disabled)
            {
                throw new Exception("Couldn't disable the Referral Program!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'ReferralProgramDisabled!',
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'ReferralProgramNotDisabled!',
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