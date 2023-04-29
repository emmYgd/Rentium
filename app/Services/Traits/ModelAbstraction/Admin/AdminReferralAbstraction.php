<?php 

namespace App\Services\Traits\ModelAbstraction\Admin;

use Illuminate\Http\Request;

use App\Services\Traits\ModelCRUD\AdminCRUD;
use App\Services\Traits\ModelCRUD\ReferralCRUD;


trait AdminExtrasAbstraction
{   
    //inherits all their methods:
    use AdminCRUD;
    use ReferralCRUD;

    //activate or deactivate referral program
    protected function AdminUpdateReferralDetailsService(Request $request): bool
    {
        $queryKeysValues = [
            'unique_admin_id' => $request->unique_admin_id
        ];
        $newKeysValues = $request->except('unique_admin_id');

        $was_ref_details_updated = $this->AdminUpdateSpecificService($queryKeysValues, $newKeysValues);
        
        return  $is_ref_details_updated;
    }


    protected function AdminFetchReferralDetailsService(Request $request)//: array
    {
        $referral_details = [];

        //first read all the admin ref details:
        $queryKeysValues = ['token_id' => $request->token_id];
        $adminDetails = $this->AdminReadSpecificService($queryKeysValues);

        //Now get the count of the buyer links:
        $queryParam = "tenant_referral_link";
        $refLinkCount = $this->ReferralReadSpecificAllTestNullService($queryParam)->count();

        //add all to the data array:
        $allTenantBonus =  $this->ReferralReadAllLazyService()->sum('total_referral_bonus');
        
        $referral_details = [
            'is_referral_program_active' => $adminDetails->is_referral_prog_activated,
            'referral_bonus_currency' => $adminDetails->referral_bonus_currency,
            'referral_bonus' =>  $adminDetails->referral_bonus,
            'referral_links_total' => $refLinkCount,
            'tenant_bonus_generated' => $allTenantBonus,
        ];

        return  $referral_details;
    }


    protected function  AdminDisableReferralProgramService(Request $request): bool
    {
        $queryKeysValues = ['unique_admin_id' => $request->unique_admin_id];
        $newKeysValues = [
            'is_referral_prog_activated' => false,
            'referral_bonus' => null,
            'referral_bonus_currency' => null
        ];

        $was_referral_details_updated = $this->AdminUpdateSpecificService($queryKeysValues, $newKeysValues);
        if(!$was_referral_details_updated)
        {
            return false;
        }
        //else:
            //loop through the Referral collection:
            $referralDetails = $this->ReferralReadAllLazyCollection()->toArray();
            //loop through:
            foreach($referralDetails as $each_referral_model)
            {
                //transactioning is needed here:

                //get each model's respective tenant id and total referral bonus:
                $unique_tenant_id = $each_referral_model['unique_tenant_id'];
                $total_referral_bonus = $each_referral_model['total_referral_bonus'];

                //now update using keys and values:
                $refQueryKeysValues = [
                    'unique_tenant_id' => $unique_tenant_id
                ];

                $refNewKeysValues = [
                    'total_referral_bonus' => 0,
                ];
                $was_bonus_updated = $this->ReferralUpdateSpecificService($refQueryKeysValues, $refNewKeysValues);
                if(!$was_bonus_updated)
                {
                    return false;
                }
            }

        return  true;
    }

}

?>