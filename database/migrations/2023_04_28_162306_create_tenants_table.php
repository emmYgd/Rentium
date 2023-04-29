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
        Schema::create('tenants', function (Blueprint $table) {
            $table?->id();

            //because it cannot be filled by mass assignment:
            $table?->string('unique_tenant_id')?->unique()?->nullable();

            $table?->boolean('is_logged_in')?->default(false);

            $table?->string('tenant_first_name');
            $table?->string('tenant_middle_name')?->nullable();
            $table?->string('tenant_last_name');

            $table?->string('tenant_username')?->unique()?->nullable();
            $table?->string('tenant_email')?->unique();
            $table?->string('tenant_phone_number')?->nullable()?->unique();
            //it cannot be filled by mass assignment:
            $table?->string('password')?->unique();

            $table?->string('tenant_current_country')?->nullable();
            $table?->string('tenant_current_state')?->nullable();
            $table?->string('tenant_current_city_or_town')?->nullable();
            $table?->string('tenant_current_address')?->nullable()?->unique();
            
            $table?->string('tenant_religion')?->nullable()?->enum(['Christianity', 'Islam', 'Traditionalist']);
            $table?->integer('tenant_age')?->nullable();
            $table?->string('tenant_marital_status')?->nullable()?->enum(['Single', 'Married']);;
            $table?->string('tenant_profession')?->nullable();

            $table?->boolean('tenant_got_pet')?->nullable();
            $table?->json('pet_type')?->nullable();

            /*$table?->string('tenant_bank_first_name')?->nullable();
            $table?->string('tenant_bank_middle_name')?->nullable();
            $table?->string('tenant_bank_last_name')?->nullable();*/

             //On the frontend: (MasterCard - Debit, Visa - Debit)They will all be encrypted...
            /*$table?->longText('tenant_bank_card_type')?->nullable();
            $table?->longText('tenant_bank_card_number')?->unique()?->nullable();
            $table?->longText('tenant_bank_card_cvv')?->unique()?->nullable();
            $table?->longText('tenant_bank_card_expiry_month')?->nullable();
            $table?->longText('tenant_bank_card_expiry_year')?->nullable();*/

            /*$table?->string('tenant_referral_link')?->unique()?->nullable();
            $table?->string('tenant_total_referral_bonus')?->nullable();*/

            $table?->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
