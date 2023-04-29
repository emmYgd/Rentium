<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use App\Services\Interfaces\Tenant\TenantSocialReferralInterface;
use App\Http\Controllers\Validators\Tenant\TenantSocialReferralRequestRules;
use App\Services\Traits\ModelAbstraction\Tenant\TenantSocialReferralAbstraction;

final class TenantSocialReferralController extends Controller implements TenantSocialReferralInterface
{
   use TenantSocialReferralRequestRules;
   use TenantSocialReferralAbstraction;

   public function __construct()
   {
        //$this->createAdminDefault();
   }

   private function  GenerateUniqueReferralLink(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->generateUniqueReferralLinkRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $unique_referral_link = $this->TenantGenerateUniqueReferralLinkService($request);
            if(!$unique_referral_link)
            {
                throw new Exception("Referral link not formed!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'ReferralLinkGenerated!',
                'referral_link' =>  $unique_referral_link
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'ReferralLinknotGenerated!',
                'short_description' => $ex->getMessage(),
            ];

            return response()->json($status, 400);
        }/*finally
        {*/
            return response()->json($status, 200);
        //}
    }


    private function GetReferralBonus(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->getReferralBonusRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Access Error, Not logged in yet!");
            }

            //this should return in chunks or paginate:
            $referral_bonus_details = $this->TenantGetReferralBonusService($request);
            if( empty($referral_bonus_details) ) 
            {
                throw new Exception("Referral Bonus not found!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'FetchSuccess!',
                'referral_bonus_details' => $referral_bonus_details
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'FetchError!',
                'short_description' => $ex->getMessage(),
            ];

            return response()->json($status, 400);
        }/*finally
        {*/
            return response()->json($status, 200);
        //}
    }


    private function UseReferralLink(Request $request, $unique_tenant_id): RedirectResponse//: JsonResponse
    {
        $status = array();

        //redirect to our homepage:
        $redirect_link = redirect()->to(env('HOMEPAGE'));
        try
        {
            //get rules from validator class:
            $reqRules = $this->usereferralLinkRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Access Error, Not logged in yet!");
            }

         
            $bonus_was_recorded = $this->TenantUseReferralLinkService($unique_tenantsocial_id);
            if(!$bonus_was_recorded)
            {
                //not expecting error here but:
                throw new Exception("");
            }

         
            //$redirect_link = 

            $status = [
                'code' => 1,
                'serverStatus' => 'UpdateSuccess!',
                'referral_link' =>$request->getHttpHost()//$bonus_has_recorded//$unique_tenantsocial_id,//
            ];
        }
        catch(Exception $ex)
        {

            $status = [
                'code' => 0,
                'serverStatus' => 'UpdateError!',
                'short_description' => $ex->getMessage(),
            ];

        }
        finally
        {
            //redirect to our homepage:
            return $redirect_link; 
        }
   }
}