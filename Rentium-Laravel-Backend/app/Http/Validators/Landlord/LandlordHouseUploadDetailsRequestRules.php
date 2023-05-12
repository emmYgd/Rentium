<?php

namespace App\Http\Validators\Landlord;

trait LandlordHouseUploadDetailsRequestRules 
{
    protected function uploadHouseTextDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id'=> 'required | string | size:10 | exists:landlords',
            'property_category'=> 'required | string',//rent or lease
            'property_locality'=> 'required | string',//Lagos, Abuja
            'property_address'=> 'required | string',
            'property_estate_name'=> 'nullable | string',
            'property_type'=> 'required | string',//bungalow, duplex, mini-flat 
            'property_condition'=> 'required | string',//newly built, renovate, fairly used. 
            'property_bedrooms'=> 'required | numeric',//1 or 2
            'property_bathrooms'=> 'required | numeric', //1 or 2

            //boolean:
            'property_is_property_furnished' =>'required | bool',//true or false                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
            'property_is_pet_allowed' => 'required | bool',//true or false
            'property_facilities' => 'required | json',//true or false
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
            'preferred_tenant_religion' => 'required | string', //Christian, Muslim, Traditionalist, Any
            'property_rent_per_annum' => 'required | numeric',
            'property_caution_damages_fee' => 'nullable | numeric',
            'property_cleaning_waste_bin_fee' => 'nullable | numeric',
            'property_electricity_fee' => 'nullable | numeric',
            'property_security_fee' => 'nullable | numeric',
            'property_developmental_fee' => 'nullable | numeric',

            'property_digital_tenancy_agreement' => 'required | string',
            //make a .pdf file from this longtext
        ];

        return $rules;
    }


    protected function uploadHouseImageDetailsRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            /*by this time, the unique_property_id must have been generated 
               and returned back upon first upload in the upload_house_text_details_rules*/
            'unique_property_id' =>  'required | string | size:10 | exists:propertys',

            // property images to be uploaded:
            //environment:
            'property_image_1_environment' => 'required | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400', 
            'property_image_2_environment' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            //compound:
            'property_image_1_compound' => 'required | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_2_compound' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            //rooms:
            'property_image_rooms_1' => 'required | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400', 
            'property_image_rooms_2' => 'required | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_rooms_3' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_rooms_4' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            //convieniences:
            'property_image_convieniences_1' => 'required | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',//bathroom_toilet
            'property_image_convieniences_2' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400', //bathroom_toilet 
            //kitchen:
            'property_image_kitchen_1' => 'required | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_kitchen_2' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            //facility: running water, solar panel, electric generator, etc. 
            'property_image_facility_1' => 'required | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_facility_2' => 'required | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_facility_3' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
            'property_image_facility_4' => 'nullable | file | image | mimes:jpg,png | dimensions:min_width=100,max_width=200,min_height=200,max_height=400',
        ];

        return $rules;
    }

    
    protected function uploadHouseClipRules(): array
    {
        //set validation rules:
        $rules = [
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'unique_property_id' =>  'required | string | size:10 | exists:propertys',
            'property_clip' => 'nullable | file | size: | mimes:'//state the expected file size and type
        ];
    }

}

?>