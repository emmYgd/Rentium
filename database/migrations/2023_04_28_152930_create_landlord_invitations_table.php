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
        Schema::create('landlord_invitations', function (Blueprint $table) {
            $table?->id();

            $table?->string('unique_invitation_id')?->unique();
            $table?->string('unique_landlord_id')?->unique(); 
            $table?->string('unique_tenant_id')?->unique();
            $table?->string('unique_property_id')?->unique(); 
        
            $table?->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlord_invitations');
    }
};
