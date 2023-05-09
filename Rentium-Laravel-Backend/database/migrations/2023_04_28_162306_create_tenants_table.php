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

            $table?->string('tenant_full_name');
           
            $table?->string('tenant_email')?->unique();
            $table?->boolean('is_email_verified')?->default(false);

            $table->string('verify_token')->unique()->nullable();//this will be purely numeric
            $table->string('pass_reset_token')->unique()->nullable();//this will be purely numeric

            $table?->string('tenant_phone_number')?->unique()?->unique();
            //it cannot be filled by mass assignment:
            $table?->string('tenant_password')?->unique()?->nullable();

            $table?->string('tenant_current_country')?->nullable();
            $table?->string('tenant_current_state')?->nullable();
            $table?->string('tenant_current_city_or_town')?->nullable();
            $table?->string('tenant_current_address')?->nullable()?->unique();
            
            $table?->string('tenant_religion')?->enum(['Christianity', 'Islam', 'Traditionalist'])?->nullable();
            $table?->integer('tenant_age')?->nullable();
            $table?->string('tenant_marital_status')?->enum(['Single', 'Married'])?->nullable();
            $table?->string('tenant_profession')?->nullable();

            $table?->boolean('tenant_got_pet')?->default(false)?->nullable();
            $table?->json('pet_type')?->nullable();

            $table?->string('tenant_nin')->nullable()->unique();

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
