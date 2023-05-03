<?php

namespace App\Http\Validators\Landlord;

trait LandlordAccessRequestRules 
{
    protected function commentRateRules(): array
    {
        //set validation rules:
        $rules = [
            //the landlord making the request:
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            //the tenant about whom comments and ratings is being made:
            'unique_tenant_id' => 'required | string | size:10 | exists:landlords',
            'landlord_comment' => 'required | string',
            'landlord_rating' => 'required | numeric'
        ];

        return $rules;
    }


    protected function viewAllTenantsCommentsRatingsAboutSelfRules(): array
    {
         //set validation rules:
         $rules = [
            //the landlord making the request:
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }

    protected function viewOtherLandlordsCommentsRatingsOnLandlordRules(): array
    {
        //set validation rules:
        $rules = [
            //the landlord making the request:
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            //the tenant about whom comments and ratings are investigated:
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
        ];

        return $rules;
    }

}