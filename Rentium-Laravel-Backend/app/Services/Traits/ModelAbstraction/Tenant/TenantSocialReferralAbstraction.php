<?php 

namespace App\Services\Traits\ModelAbstraction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Services\Traits\ModelCRUD\Social\ReferralCRUD;
use App\Services\Traits\ModelCRUD\Admin\AdminCRUD;


trait TenantSocialReferralAbstraction
{   
    //inherits all their methods:
    use ReferralCRUD;
    use AdminCRUD;
    

    protected function TenantGenerateUniqueReferralLinkService(Request $request): string
    {
        //$referral_link = null;

        //first check if admin exists and if he has activated the referral program:
        $admin_details = $this?->AdminReadAllService()?->first();
        if(!$admin_details || !$admin_details?->is_referral_prog_activated)
        {
            throw new Exception("Referral Program Not Activated Yet!");
        }

        $unique_tenant_id = $request?->unique_tenant_id;

        //check the database if ref link is present:
        $queryKeysValues = [
            'unique_tenant_id' => unique_tenant_id
        ];
        $saved_referral_link = $this?->ReferralReadSpecificService($queryKeysValues)?->tenant_referral_link;
        if( 
            ($saved_referral_link !== null) || 
            ($saved_referral_link !== '') 
        )
        {
            return $saved_referral_link;
        }
        /*else:
        {*/
            //if it is activated, continue:
            $sub_ref_url = "{unique_tenant_id}/referral/{Crypt::encryptString(unique_tenant_id)}";

            //$current_domain = $request?->getSchemeAndHttpHost();
            //returns https://rentium.com

            $new_referral_link = $sub_ref_url;
            //e.g {tenant_id}/referral/{enc_tenant_id}

            //$queryKeysValues = ['unique_tenant_id' => $tenant_id];

            $newKeysValues = [
                'tenant_referral_link' => $new_referral_link
            ];

            //save in the referral table: 
            $was_referral_link_saved =  $this?->ReferralUpdateSpecificService($queryKeysValues, $newKeysValues);
            if(!$was_referral_link_saved)
            {
                throw new Exception("Error in Saving New Referral Link! Please try again!");
            }

            return $new_referral_link;
    }
    

    protected function TenantGetReferralBonusService(Request $request)//: string
    {
        //first check if admin has activated the referral program:
        $admin_details = $this?->AdminReadAllService()?->first();
        if(!$admin_details || !$admin_details?->is_referral_prog_activated)
        {
            throw new Exception("Referral Program Not Activated Yet!");
        }

        //then check the admin referral program bonus currency:
        $bonus_currency = $admin_details?->referral_bonus_currency;

        //now back to the tenant, query for their total accumulated bonus:
        $queryKeysValues = [
            'unique_tenant_id' => $request?->unique_tenant_id
        ];
        $referral_bonus = $this?->ReferralReadSpecificService($queryKeysValues)?->total_referral_bonus;

        //return array:
        $ref_bonus_details = [
            'ref_bonus_currency' => $bonus_currency,
            'ref_bonus_amount' => $referral_bonus
        ];

        return $ref_bonus_details;
    }


    /*when a tenant wants to register, 
    there will be s field for referral link where he can input who referred him.
    This function handles that:*/
    protected function TenantReferralLinkUseService(string $referral_link)//: string
    {
        //first check if admin has activated the referral program:
        $admin_details = $this?->AdminReadAllService()?->first();
        if(!$admin_details )
        {
            throw new Exception("Referral Program Not Activated Yet!");
        }

        $is_referral_activated = $admin_details?->is_referral_prog_activated;

        if(!$is_referral_activated)
        {
            throw new Exception("Referral Program Not Activated Yet!");
        }

        //get the admin bonus per click:
        $bonus_per_click = $admin_details?->referral_bonus;

        //check the tenant table and add bonus accordingly:
        $queryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id
        ];
        $db_ref_bonus = $this?->TenantReadSpecificService($queryKeysValues)?->total_referral_bonus;

        //cast values:
        //add the two values together and update:
        (float)$db_ref_bonus += (float) $bonus_per_click;

        //update this new value in database:
        $newKeysValues = ['tenant_total_referral_bonus' => $db_ref_bonus];
        $is_new_ref_updated = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);

        return $is_new_ref_updated;
    }

}