<?php

namespace Tests\Feature\Landlord;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class LandlordUploadHouseTextDetailsTest extends TestCase
{
    //use RefreshDatabase;    
    /*public function test_house_text_details_can_be_uploaded()
    {
        $response = $this->postJson(
            route('landlord.upload.property.texts'), 
            [
                'unique_landlord_id' => 'weZlUrKJam',
                'property_category'=> 'rent',//rent or lease
                'property_locality'=> 'Ibadan',//Lagos, Abuja
                'property_address'=> 'Agbowo Street, Bodija Junction, Agbowo-UI, Ibadan',
                'property_estate_name'=> 'GRA',
                'property_type'=> '2-Bedroom Flat',//bungalow, duplex, mini-flat, Others 
                'property_condition'=> 'Newly Built',//newly built, renovate, fairly used. 
                'property_bedrooms'=> '4',//1 or 2
                'property_bathrooms'=> '2', //1 or 2
    
                //boolean:
                'property_is_property_furnished' => true,//true or false                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                'property_is_pet_allowed' => true,//true or false
                'property_facilities' => json_encode("{
                    '24-hour Electric Power Supply(Generator, Solar, etc.)': true,
                    'POP Ceiling': true,
                    'Chandelier': true,
                    'Dishwasher': true,
                    'Kitchen Cabinet': true,
                    'Tiles': true,
                    'Running Water': true,
                    'Other': 'Any other facility available listed here'              
                }"),
                'preferred_tenant_religion' => 'Any', //Christianity, Islam, Traditionalist, Any
                'property_rent_per_annum' => 200000,
                'property_caution_damages_fee' => 20000,
                'property_cleaning_waste_bin_fee' => 20000,
                'property_electricity_fee' => 20000,
                'property_security_fee' => 20000,
                'property_developmental_fee' => 20000,
    
                'property_digital_tenancy_agreement' => 'This is just for test, will be constant on the platform, move to admin in production!',
                //make a .pdf file from this longtext
            ],
            [
                'HTTP_Authorization' => 'Bearer ' . '3|3i1S6aWmrGbsOqZDdSCfsdbBBVVpopB5p1wjyEFD',
                'Accept' => 'application/json'
            ]
        );
        
        //$this->assertAuthenticated();
        //$response->assertNoContent();
        //$response->assertOk();
        $response->assertExactJson(['short_description' => "Verification Request Mail wasn't sent successfully!"]); 
    
    }*/
}
?>