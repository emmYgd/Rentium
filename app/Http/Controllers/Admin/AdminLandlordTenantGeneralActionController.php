<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Http\Validators\Admin\AdminLandlordTenantGeneralActionRequestRules;

use App\Services\Interfaces\Admin\AdminLandlordTenantGeneralActionInterface;
use App\Services\Traits\ModelAbstraction\Admin\AdminLandlordTenantGeneralActionAbstraction;

final class AdminLandlordTenantGeneralActionActionController extends Controller implements AdminLandlordTenantGeneralActionInterface
{
    use AdminLandlordTenantGeneralActionRequestRules;
    use AdminLandlordTenantGeneralActionAbstraction;
   

   public function __construct()
   {
      //$this->createAdminDefault();
   }


   private function BanLandlord(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->banLandlordRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Invalid Input Provided!");
         }
         
         //this should return in chunks or paginate:
         $landlord_was_banned = $this->AdminBanLandlordService($request);
         if(!$landlord_was_banned)
         {
            throw new Exception("The intended Landlord Wasn't Banned!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'BanSuccess!',
         ];
      }
      catch(Exception $ex)
      {
         $status = [
            'code' => 0,
            'serverStatus' => 'BanError!',
            'short_description' => $ex->getMessage()
         ];

         return response()->json($status, 400);
      }
      /*finally
      {*/
         return response()->json($status, 200);
      //}
   }


   private function BanTenant(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->banTenantRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Invalid Input Provided!");
         }
         
         //this should return in chunks or paginate:
         $tenant_was_banned = $this->AdminBanTenantService($request);
         if(!$tenant_was_banned)
         {
            throw new Exception("The intended Tenant Wasn't Banned!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'BanSuccess!',
         ];
      }
      catch(Exception $ex)
      {
         $status = [
            'code' => 0,
            'serverStatus' => 'BanError!',
            'short_description' => $ex->getMessage()
         ];

         return response()->json($status, 400);
      }
      /*finally
      {*/
         return response()->json($status, 200);
      //}
   }


   private function DeleteLandlord(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->deleteLandlordRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Invalid Input Provided!");
         }
         
         //this should return in chunks or paginate:
         $landlord_was_deleted = $this->AdminDeleteLandlordService($request);
         if(!$landlord_was_deleted)
         {
            throw new Exception("The intended Landlord Wasn't Deleted!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'DeletionSuccess!',
         ];
      }
      catch(Exception $ex)
      {
         $status = [
            'code' => 0,
            'serverStatus' => 'DeletionError!',
            'short_description' => $ex->getMessage()
         ];

         return response()->json($status, 400);
      }
      /*finally
      {*/
         return response()->json($status, 200);
      //}
   }


   private function DeleteTenant(Request $request): JsonResponse
   {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this->deleteTenantRules();

         //validate here:
         $validator = Validator::make($request->all(), $reqRules);

         if($validator->fails())
         {
            throw new Exception("Invalid Input Provided!");
         }
         
         //this should return in chunks or paginate:
         $tenant_was_deleted = $this->AdminDeleteTenantService($request);
         if(!$tenant_was_deleted)
         {
            throw new Exception("The intended Tenant Wasn't Deleted!");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'DeletionSuccess!',
         ];
      }
      catch(Exception $ex)
      {
         $status = [
            'code' => 0,
            'serverStatus' => 'DeletionError!',
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