<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */

    //Global Middleware:
    protected $middleware = [
        // \App\Http\Middleware\General\TrustHosts::class,

       \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        
        \App\Http\Middleware\General\TrustProxies::class,
        \App\Http\Middleware\General\TrimStrings::class,
        \App\Http\Middleware\General\PreventRequestsDuringMaintenance::class,

        //App\Http\Middleware\General\CreateDBonDeploy::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\General\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\General\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Illuminate\Http\Middleware\HandleCors::class,
            //\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            //\Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            //'throttle:api',//remember to put this back in deployment...
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        //For Tenants:
        'TenantEnsureLogoutState' => \App\Http\Middleware\Tenant\TenantEnsureLogoutState::class,
        'TenantCleanNullRecords' =>  \App\Http\Middleware\Tenant\TenantDeleteAllNullPassAndIDRecords::class,
        'TenantConfirmLoginState' => \App\Http\Middleware\Tenant\TenantConfirmLoginState::class,
        'TenantConfirmVerifyState' => \App\Http\Middleware\Tenant\TenantConfirmVerifyState::class,
        'TenantDestroyTokenAfterLogout' => \App\Http\Middleware\Tenant\DestroyTokenAfterLogout::class,
        //For Carts
        //'DeleteEmptyCarts' => \App\Http\Middleware\General\DeleteEmptyCarts::class,
        //'CartEnsureNotCleared' => \App\Http\Middleware\General\CartEnsureNotCleared::class,
        //For Wishlists
        //'DeleteEmptyWishlists' => \App\Http\Middleware\General\DeleteEmptyWishlists::class,
        //For Billing And Shipping:
        //'DeleteEmptyBillingAndShipping' => \App\Http\Middleware\Tenant\DeleteEmptyBillingAndShipping::class,


        //For Landlords:
        'LandlordEnsureLogoutState' => \App\Http\Middleware\Landlord\LandlordEnsureLogoutState::class,
        'LandlordCleanNullRecords' =>  \App\Http\Middleware\Landlord\LandlordDeleteAllNullPassAndIDRecords::class,
        'LandlordConfirmLoginState' => \App\Http\Middleware\Landlord\LandlordConfirmLoginState::class,
        'LandlordConfirmVerifyState' => \App\Http\Middleware\Landlord\LandlordConfirmVerifyState::class,
        'LandlordDestroyTokenAfterLogout' => \App\Http\Middleware\Landlord\DestroyTokenAfterLogout::class,

        //For Admin:
        'AdminCreateBoss' => \App\Http\Middleware\Admin\AdminCreateBoss::class,
        'AdminEnsureLogoutState' => \App\Http\Middleware\Admin\AdminEnsureLogoutState::class,
        'AdminCleanNullRecords' =>  \App\Http\Middleware\Admin\AdminDeleteAllNull::class,
        'AdminConfirmLoginState' => \App\Http\Middleware\Admin\AdminConfirmLoginState::class,
        'AdminConfirmVerifyState' => \App\Http\Middleware\Admin\AdminConfirmVerifyState::class,
        'AdminDestroyTokenAfterLogout' => \App\Http\Middleware\Admin\DestroyTokenAfterLogout::class,

        //Check for sanctum auth token abilities:
        'abilities' => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
        'ability' => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,

        'auth' => \App\Http\Middleware\General\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\General\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \App\Http\Middleware\General\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
