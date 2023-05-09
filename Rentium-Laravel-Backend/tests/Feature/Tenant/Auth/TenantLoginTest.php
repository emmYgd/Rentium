<?php

namespace Tests\Feature\Tenant\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantLoginTest extends TestCase
{
    //use RefreshDatabase;

    /*public function test_new_tenants_can_login()
    {
        $response = $this->patchJson(
            route('tenant.login'), 
            [
                'tenant_email_or_phone_number' => 'emmdammy@gmail.com',
                'tenant_password' => 'emma@12crown',
            ],
            []
        );

        //$this->assertAuthenticated();
        //$response->assertNoContent();
        //$response->assertOk();
        $response->assertExactJson(['short_description' => "Verification Request Mail wasn't sent successfully!"]);
    }*/
}
