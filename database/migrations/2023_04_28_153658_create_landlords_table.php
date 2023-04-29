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
        Schema::create('landlords', function (Blueprint $table) {
            $table?->id();

            //because it cannot be filled by mass assignment:
            $table?->string('unique_landlord_id')?->unique()?->nullable();

            $table?->boolean('is_logged_in')?->default(false);

            $table?->string('landlord_first_name');
            $table?->string('landlord_middle_name')?->nullable();
            $table?->string('landlord_last_name');

            $table?->string('landlord_username')?->unique()?->nullable();
            $table?->string('landlord_email')?->unique();
            $table?->string('landlord_phone_number')?->nullable()?->unique();
            //it cannot be filled by mass assignment:
            $table?->string('password')?->unique();

            $table?->string('landlord_current_country')?->nullable();
            $table?->string('landlord_current_state')?->nullable();
            $table?->string('landlord_current_city_or_town')?->nullable();
            $table?->string('landlord_current_address')?->nullable()?->unique();

            $table?->string('landlord_religion')?->nullable()?->enum(['Christianity', 'Islam', 'Traditionalist']);;
            $table?->integer('landlord_age')?->nullable();
            $table?->string('landlord_marital_status')?->nullable()?->enum(['Single', 'Married']);
            $table?->string('landlord_profession')?->nullable();

            $table?->boolean('landlord_got_pet')?->nullable();
            $table?->json('pet_type')?->nullable();

            /*$table?->string('landlord_referral_link')?->unique()?->nullable();
            $table?->string('landlord_total_referral_bonus')?->nullable();*/

            
            $table?->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlords');
    }
};
