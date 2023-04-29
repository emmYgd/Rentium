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
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table?->id();

            $table?->string('unique_landlord_id')?->unique();
            $table?->float('requested_amount');
            $table?->float('actual_withdrawal_amount');//requested amount minus admin charge
            $table?->float('withdrawal_request_category')?->enum(['Urgent', 'Normal'])?->nullable();
            $table?->boolean('is_admin_approved')?->default(false);

            $table?->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
