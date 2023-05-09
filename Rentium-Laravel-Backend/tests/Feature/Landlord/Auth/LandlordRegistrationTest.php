<?php

namespace Tests\Feature\Landlord\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandlordRegistrationTest extends TestCase
{
    //use RefreshDatabase;

    public function test_new_landlords_can_register()
    {
       /*$response = $this->postJson(
            route('landlord.register'), 
            [
                'landlord_full_name' => 'Emmanuel Adediji',
                'landlord_phone_number' => '+(234)08056963477',
                'landlord_email' => 'emmdammy@gmail.com',
                'landlord_password' => 'emma@12crown',
            ],
            []
        );

        //$this->assertAuthenticated();
        //$response->assertNoContent();
        //$response->assertOk();
        $response->assertExactJson(['short_description' => "Invalid Input(s) provided!"]);
        */
    }
}
