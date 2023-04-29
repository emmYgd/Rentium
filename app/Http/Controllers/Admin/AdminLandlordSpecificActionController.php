<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Http\Validators\Admin\AdminLandlordSpecificActionRequestRules;

use App\Services\Interfaces\Admin\AdminLandlordSpecificActionInterface;
use App\Services\Traits\ModelAbstraction\Admin\AdminLandlordSpecificActionAbstraction;

final class AdminLandlordSpecificActionController extends Controller implements AdminLandlordSpecificActionInterface
{
    use AdminLandlordSpecificActionRequestRules;
    use AdminLandlordSpecificActionAbstraction;
   

   public function __construct()
   {
      //$this->createAdminDefault();
   }


   private function ViewAllUnApprovedLandlordWithdrawalRequests(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->viewAllUnApprovedLandlordWithdrawalRequestsRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Access Error! Not an Admin!");
         }
         
         //this should return in chunks or paginate:
         $withdrawalRequestDetails = $this->AdminViewUnApprovedLandlordWithdrawalRequestsService($request);
         if( empty($withdrawalRequestDetails) )
         {
            throw new Exception("Unapproved Landlord Withdrawal Request Details Not Found!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'WithdrawalRequestsFound!',
         ];
      }
      catch(Exception $ex)
      {
         $status = [
            'code' => 0,
            'serverStatus' => 'WithdrawalRequestsNotFound!',
            'short_description' => $ex->getMessage()
         ];

         return response()->json($status, 400);
      }
      /*finally
      {*/
         return response()->json($status, 200);
      //}
   }


   private function ViewAllApprovedLandlordWithdrawalRequests(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->viewAllApprovedLandlordWithdrawalRequestsRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Access Error! Not an Admin!");
         }
         
         //this should return in chunks or paginate:
         $withdrawalRequestDetails = $this->AdminViewApprovedLandlordWithdrawalRequestsService($request);
         if( empty($withdrawalRequestDetails) )
         {
            throw new Exception("Approved Landlord Withdrawal Request Details Not Found!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'WithdrawalRequestsFound!',
         ];
      }
      catch(Exception $ex)
      {
         $status = [
            'code' => 0,
            'serverStatus' => 'WithdrawalRequestsNotFound!',
            'short_description' => $ex->getMessage()
         ];

         return response()->json($status, 400);
      }
      /*finally
      {*/
         return response()->json($status, 200);
      //}
   }


   private function ApproveLandlordWithdrawalRequest(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->approveLandlordWithdrawalRequestRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Invalid Input Provided!");
         }
         
         $withdrawal_request_was_approved = $this->AdminApproveLandlordWithdrawalRequestService($request);
         if(!$withdrawal_request_was_approved)
         {
            throw new Exception("Could not Approved Landlord Withdrawal Request!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'WithdrawalRequestApproved!',
         ];
      }
      catch(Exception $ex)
      {
         $status = [
            'code' => 0,
            'serverStatus' => 'WithdrawalRequestNotApproved!',
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