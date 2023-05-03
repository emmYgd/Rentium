<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Http\Validators\Admin\AdminLandlordTenantFetchRequestRules;

use App\Services\Interfaces\Admin\AdminLandlordTenantFetchInterface;
use App\Services\Traits\ModelAbstraction\Admin\AdminLandlordTenantFetchAbstraction;

final class AdminLandlordTenantFetchTenantFetchController extends Controller implements AdminLandlordTenantFetchInterface
{
   use AdminLandlordTenantFetchAbstraction;
   use AdminLandlordTenantFetchRequestRules;

   private function __construct()
   {
      //$this->createAdminDefault();
   }


   private function FetchAllLandlordDetails(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->fetchAllLandlordDetailsRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Access Error! Not an Admin");
         }
         
         //this should return in chunks or paginate:
         $allDetailsFound = $this->AdminFetchAllLandlordDetailsService($request);
         if( empty($allDetailsFound) )
         {
            throw new Exception("No Landlord Details Were Found!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'FetchSuccess!',
            'all_landlord_details' => $allDetailsFound
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


   private function FetchAllTenantDetails(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->fetchAllTenantDetailsRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Access Error! Not an Admin");
         }
         
         //this should return in chunks or paginate:
         $allDetailsFound = $this->AdminFetchAllTenantDetailsService($request);
         if( empty($allDetailsFound) )
         {
            throw new Exception("No Tenant Details Were Found!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'FetchSuccess!',
            'buyer_details' => $allDetailsFound
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


   private function FetchEachLandlordDetail(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->fetchEachLandlordDetailRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Invalid Input Provided!");
         }
         
         //this should return in chunks or paginate:
         $eachDetailFound = $this->AdminFetchEachLandlordDetailService($request);
         if( empty($eachDetailFound) )
         {
            throw new Exception("Landlord detail was not found!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'FetchSuccess!',
            'buyer_details' => $eachDetailFound
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
  

   //first display the summary of all pending(not paid yet) or cleared cart(paid)
   private function FetchEachTenantDetail(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->fetchEachTenantDetailRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Access Error!");
         }
         
         //this should return in chunks or paginate:
         $detailsFound = $this->AdminFetchEachTenantDetailService($request);
         if( empty($detailsFound) )
         {
            throw new Exception("Tenant Detail not Found!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'FetchSuccess!',
            'buyer_details' => $detailsFound
         ];

      }
      catch(Exception $ex)
      {
         $status = [
            'code' => 0,
            'serverStatus' => 'FetchError!',
            'short_description' => $ex->getMessage()
         ];

         response()->json($status, 400);
      }
      /*finally
      {*/
         return response()->json($status, 200);
      //}
   }

}
