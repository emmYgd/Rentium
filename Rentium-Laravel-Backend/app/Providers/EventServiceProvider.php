<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

                //bind app events to listeners:

        //Register:
        \App\Events\Tenant\TenantHasRegistered::class => [
            //\App\Listeners\Tenant\EmailTenantAboutWelcome::class,
            //\App\Listeners\Tenant\EmailTenantAboutVerification::class,
            //others here...
        ],

        \App\Events\Landlord\LandlordHasRegistered::class => [
            //\App\Listeners\Landlord\EmailLandlordAboutWelcome::class,
            //\App\Listeners\Landlord\EmailLandlordAboutVerification::class,
            //others here...
        ],


        //Password Reset:
        \App\Events\Tenant\PassResetTokenWasFormed::class => [
            //\App\Listeners\Tenant\EmailTenantAboutPassReset::class,
        ],

        \App\Events\Landlord\PassResetTokenWasFormed::class => [
            //\App\Listeners\Landlord\EmailLandlordAboutPassReset::class,
        ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
