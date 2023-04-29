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
        Schema::create('comment_ratings', function (Blueprint $table) {
            $table?->id();

            $table?->string('unique_tenant_id')?->nullable();
            $table?->string('unique_landlord_id')?->nullable();

            $table?->longText('tenant_comments')?->nullable();
            $table?->float('tenant_ratings')?->nullable();

            $table?->longText('landlord_comments')?->nullable();
            $table?->float('landlord_ratings')?->nullable();

            $table?->boolean('is_tenant_initiated')?->default(false); //defaults to false
            $table?->boolean('is_landlord_initiated')?->default(false); //defaults to false
            //admin has to approve this for view before it can be displayed
            $table?->boolean('is_approved_for_view')?->default(false); //defaults to false

            $table?->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_ratings');
    }
};
