<?php

namespace Tests\Feature\Tenant\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantRegistrationTest extends TestCase
{
    //use RefreshDatabase;

    public function test_new_tenants_can_register()
    {
        /*$response = $this->postJson(
            route('tenant.register'), 
            [
                'tenant_full_name' => 'Emmanuel Adediji',
                'tenant_phone_number' => '+(234)08056963477',
                'tenant_email' => 'emmdammy@gmail.com',
                'tenant_password' => 'emma@12crown',
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
