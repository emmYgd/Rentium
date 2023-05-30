<?php

namespace Tests\Feature\Tenant\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class TenantConfirmLoginTest extends TestCase
{
    //use RefreshDatabase;

    public function test_login_status_can_be_verified()
    {
        $response = $this->patchJson(
            route('tenant.confirm.login.state'), 
            [
                'unique_tenant_id' => 'vpH2AKYnTm',
            ],
            [
                'HTTP_Authorization' => 'Bearer ' . '18|QlbYnEExD9r9LAEHHAAZFnBPySBpboB0ltA8qLOm',
                'Accept' => 'application/json'
            ]
        );
        
        //$this->assertAuthenticated();
        //$response->assertNoContent();
        //$response->assertOk();
        $response->assertExactJson(['short_description' => "Verification Request Mail wasn't sent successfully!"]); 
    }
        /*$user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1');
        */

    /*public function test_email_is_not_verified_with_invalid_hash()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }*/
}
