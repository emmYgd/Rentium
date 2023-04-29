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
        Schema::create('contacts', function (Blueprint $table) {
            $table?->id();

            $table?->string('unique_tenant_id')?->nullable();
            $table?->string('unique_landlord_id')?->nullable();
            $table?->string('unique_admin_id')?->nullable();

            $table?->string('message_nature')?->enum(['admin_to_landlord', 'landlord_to_admin', 'admin_to_tenant', 'tenant_to-admin', 'landlord_to_tenant', 'tenant_to_landlord']);
            $table?->string('message')?->nullable();
            $table?->binary('message_attachment')?->nullable();

            $table?->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
