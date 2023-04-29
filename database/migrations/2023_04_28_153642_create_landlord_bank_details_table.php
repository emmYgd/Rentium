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
        Schema::create('landlord_bank_details', function (Blueprint $table) {
            $table?->id();

            $table?->string('unique_landlord_id');
            $table?->string('bank_name')?->nullable();
            $table?->string('bank_account_first_name')?->nullable();
            $table?->string('bank_account_middle_name')?->nullable();
            $table?->string('bank_account_last_name')?->nullable();
            $table?->string('country_of_opening')?->nullable();
            $table?->string('currency_of_operation')?->nullable();
            $table?->string('bank_account_type')?->nullable();
            $table?->string('bank_account_number')?->nullable();
            $table?->string('bank_account_additional_info')?->nullable();                                                                                                                                                                                                                                                                                                                                                                                                                             

            $table?->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlord_bank_details');
    }
};
