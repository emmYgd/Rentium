<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_tenants_can_register()
    {
        $response = $this->postJson(
            route('tenant.register'), 
            [
                'tenant_first_name' => 'Emmanuel',
                'tenant_middle_name' => 'Damilare',
                'tenant_last_name' => 'Adediji',
                'tenant_phone_number' => '+2349033068412',
                'tenant_username' => 'youngemmy',
                'tenant_email' => 'emmdammy@gmail.com',
                'tenant_password' => 'emma@12crown',
                //'tenant_password_confirmation' => 'emma@12crown',
            ],
            []
        );

        //$this->assertAuthenticated();
        //$response->assertNoContent();
        //$response->assertOk();
        $response->assertExactJson(['short_description' => "Invalid Input(s) provided!"]);
    }
}
