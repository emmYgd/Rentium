<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantLogoutTest extends TestCase
{
    //use RefreshDatabase;

    public function test_new_tenants_can_logout()
    {
        /*$response = $this->putJson(
            route('tenant.logout'), 
            [
                'unique_tenant_id' => 'wR7ozLjDGe',
            ],
            ['HTTP_Authorization' => 'Bearer ' . '1|CSKNu9ZEyGuod0OVyvbr4q2QBEEycaGB5K1r1g1f']
        );

        //$this->assertAuthenticated();
        //$response->assertNoContent();
        //$response->assertOk();

        $response->assertExactJson(['short_description' => "Verification Request Mail wasn't sent successfully!"]);
        */
    }
}
