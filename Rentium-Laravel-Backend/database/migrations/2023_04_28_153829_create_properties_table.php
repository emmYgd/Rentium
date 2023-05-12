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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->string('unique_property_id')->unique();
            $table->string('unique_landlord_id')->unique();

            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_occupied')->default(false);

            $table->string('property_category')->enum(['Rent', 'Lease']);//rent or lease
            $table->string('property_locality');//Lagos, Abuja
            $table->string('property_address');
            $table->string('property_estate_name');
            $table->string('property_type')->enum(['Bungalow', 'Duplex', 'Mini-flat']);//find others...
            $table->string('property_condition')->enum(['New', 'Renovated', 'Fairly-Used', 'Converted', 'Normal']); 
            $table->integer('property_bedrooms');
            $table->integer('property_bathrooms');

            $table->boolean('property_is_property_furnished');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
            $table->boolean('property_is_pet_allowed');
            $table->json('property_facilities');
            /*{
                '24-hour Electric Power Supply(Generator, Solar, etc.)' : true,
                'POP Ceiling': true,
                'Chandelier': true,
                'Dishwasher': true,
                'Kitchen Cabinet': true,
                'Tiles': true,
                'Running Water': true,
                'Other': 'Any other facility available'              
            }*/            
            $table->string('preferred_tenant_religion')->enum(['Christian', 'Muslim', 'Traditionalist', 'Any']);
            $table->float('property_rent_per_annum');
            $table->float('property_caution_damages_fee')->nullable(); 
            $table->float('property_cleaning_waste_bin_fee')->nullable();
            $table->float('property_electricity_fee')->nullable();
            $table->float('property_security_fee')->nullable();
            $table->float('property_developmental_fee')->nullable();

            //make a .pdf file from this longtext
            $table->longText('property_digital_tenancy_agreement');
            
            // property images to be uploaded:
            //environment:
            $table->binary('property_image_1_environment')->nullable();
            $table->binary('property_image_2_environment')->nullable();
            //compound:
            $table->binary('property_image_1_compound')->nullable(); 
            $table->binary('property_image_2_compound')->nullable(); 
            //rooms:
            $table->binary('property_image_rooms_1')->nullable();
            $table->binary('property_image_rooms_2')->nullable();
            $table->binary('property_image_rooms_3')->nullable(); 
            $table->binary('property_image_rooms_4')->nullable();
            //convieniences:
            $table->binary('property_image_convieniences_1')->nullable();//bathroom_toilet
            $table->binary('property_image_convieniences_2')->nullable();//bathroom_toilet 
            //kitchen:
            $table->binary('property_image_kitchen_1')->nullable(); 
            $table->binary('property_image_kitchen_2')->nullable(); 
        \
                    //facility: running water, solar panel, electric generator, etc. 
            $table->binary('property_image_facility_1')->nullable();
            $table->binary('property_image_facility_2')->nullable(); 
            $table->binary('property_image_facility_3')->nullable(); 
            $table->binary('property_image_facility_4')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};  ``
