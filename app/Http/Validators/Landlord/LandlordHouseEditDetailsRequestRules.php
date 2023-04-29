<?php

namespace App\Http\Controllers\Validators;

trait LandlordHouseEditDetailsRequestRules 
{
    protected function editHouseTextDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id'=> 'required | string | size:10 | exists:landlords',
            'unique_property_image_id' => 'required | string | size:10 | exists:property_images',
            'property_image_category'=> 'nullable | string',//rent or lease
            'property_image_locality'=> 'nullable | string',//Lagos, Abuja
            'property_image_address'=> 'nullable | string',
            'property_image_estate_name'=> 'nullable | string',
            'property_image_type'=> 'nullable | string',//bungalow, duplex, mini-flat 
            'property_image_condition'=> 'nullable | string',//newly built, renovate, fairly used. 
            'property_image_bedrooms'=> 'nullable | numeric',//1 or 2
            'property_image_bathrooms'=> 'nullable | numeric', //1 or 2

            //boolean:
            'property_image_is_property_image_furnished' =>'nullable | bool',//true or                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
            'property_image_is_pet_allowed' => 'nullable | bool',//true or false
            'property_image_facilities' => 'nullable | json',//true or false
            /*{
                '24-hour Electric Power Supply(Generator, Solar, etc.)' : true,
                'POP Ceiling': true,
                'Chandelier': true,
                'Dishwasher': true,
                'Kitchen Cabinet': true,
                'Tiles': true,
                'Running Water': true,
                'Other': 'Any other facility available'              
            }*/            

            'property_image_rent_per_annum' => 'nullable | numeric',
            'property_image_caution_damage_fee' => 'nullable | numeric',
            'property_image_cleaning_waste_bin_fee' => 'nullable | numeric',
            'property_image_electricity_fee' => 'nullable | numeric',
            'property_image_security_fee' => 'nullable | numeric',
            'property_image_developemental_fee' => 'nullable | numeric',

            'property_image_digital_tenancy_agreement' => 'nullable | string',
            //make a .pdf file from this longtext
        ];

        return $rules;
    }


    protected function editHouseImageDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            /*by this time, the unique_property_image_id must have been generated 
               and returned back upon first edit in the edit_house_text_details_rules*/
            'unique_property_image_id' =>  'required | string | size:10 | exists:property_images',

            // property_image images to be edited:
            //environment:
            'property_image_image_1_environment' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400', 
            'property_image_image_2_environment' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            //compound:
            'property_image_image_1_compound' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_image_2_compound' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            //rooms:
            'property_image_rooms_1' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400', 
            'property_image_rooms_2' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_rooms_3' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_rooms_4' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            //convieniences:
            'property_image_convieniences_1' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',//bathroom_toilet
            'property_image_convieniences_2' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400', //bathroom_toilet 
            //kitchen:
            'property_image_kitchen_1' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_kitchen_2' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            //facility: running water, solar panel, electric generator, etc. 
            'property_image_facility_1' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_facility_2' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_facility_3' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_facility_4' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
        ];

        return $rules;
    }

    
    protected function editHouseClipRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'nullable | string | size:10 | exists:landlords',
            'unique_property_image_id' =>  'nullable | string | size:10 | exists:property_images',
            'property_image_clip' => 'nullable | file | size: | mimes:'//state the expected file size and type
        ];
    }

}

?>