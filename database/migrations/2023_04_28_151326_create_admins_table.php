<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table?->id();

            //because it cannot be filled by mass assignment:
            $table?->string('unique_admin_id')?->unique()?->nullable();

            $table?->boolean('is_logged_in')?->default(false);

            $table?->string('admin_first_name')?->nullable();
            $table?->string('admin_middle_name')?->nullable();
            $table?->string('admin_last_name')?->nullable();

            $table?->string('admin_email')?->unique();
            $table?->string('admin_phone_number')?->nullable()?->unique();
            //it cannot be filled by mass assignment:
            $table?->string('password')?->unique();

            $table?->string('landlord_current_country')?->nullable();
            $table?->string('landlord_current_state')?->nullable();
            $table?->string('landlord_current_city_or_town')?->nullable();
            $table?->string('landlord_current_address')?->nullable()?->unique();

            $table?->boolean('is_referral_program_activated')?->nullable()?->default(false);
            $table?->string('referral_bonus_currency')?->enum(['NGN', 'USD'])->default('NGN');
            $table?->float('referral_bonus');

            //for withdrawal amount:
            $table?->integer('admin_withdrawal_percent_charge')?->nullable();

            $table?->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
