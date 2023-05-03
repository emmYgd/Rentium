<?php

namespace App\Http\Controllers\Validators;

trait LandlordHouseDeleteDetailsRequestRules 
{
    protected function deleteSpecificHouseDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id'=> 'required | string | size:10 | exists:landlords',
            'unique_property_id' => 'required | string | size:10 | exists:propertys',
        ];

        return $rules;
    }


    protected function deleteAllPropertyRecordsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }

}

?>