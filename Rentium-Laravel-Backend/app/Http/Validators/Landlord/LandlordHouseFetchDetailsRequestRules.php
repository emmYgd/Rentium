<?php

namespace App\Http\Controllers\Validators;

trait LandlordHouseFetchDetailsRequestRules 
{
    protected function fetchAllOwnHouseDetailsSummaryRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id'=> 'required | string | size:10 | exists:landlords,propertys',
            'is_rented' => 'required | bool'
        ];

        return $rules;
    }

    //protected function 

    protected function fetchEachHousingDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id'=> 'required | string | size:10 | exists:landlords',
            'unique_property_id' => 'required | string | size:10 | exists:propertys'
        ];

        return $rules;
    }


    protected function deleteEachProductDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id'=> 'required | string | size:10 | exists:admins',
            'product_unique_landlord_id' => 'required | string | size:10 | exists:products'
        ];

        return $rules;
    }

    
}

?>