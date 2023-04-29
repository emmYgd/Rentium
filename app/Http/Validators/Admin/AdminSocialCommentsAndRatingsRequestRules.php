<?php

namespace App\Http\Validators\Admin;

trait AdminAccessRequestRules 
{
    protected function viewAllUnApprovedCommentsAndRatingsRules(): array
    {
        //set validation rules:
        $rules = [
            //the admin making the request:
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
        ];

        return $rules;
    }


    protected function viewAllApprovedCommentsRatingsRules(): array
    {
         //set validation rules:
         $rules = [
            //the admin making the request:
            'unique_admin_id' => 'required | string | size:10 | exists:admins',
        ];

        return $rules;
    }


    protected function approveCommentRatingRules(): array
    {
        //set validation rules:
        $rules = [
            //the admin making the request:
            'unique_admin_id' => 'required | string | size:10 | exists:admins | different:unique_landlord_id,unique_tenant_id',
            'unique_tenant_id' => 'nullable | string | size:10 | exists:tenants | different:unique_admin_id,unique_landlord_id',
            'unique_landlord_id' => 'nullable | string | size:10 | exists:tenants | different:unique_admin_id,unique_tenant_id',
        ];

        return $rules;
    }

}