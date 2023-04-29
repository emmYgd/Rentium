<?php

namespace App\Http\Validators\Landlord;

trait LandlordToTenantInteractionRequestRules 
{

    protected function scheduleInspectionAppointmentForLandlordInvitationRules(): array
    {
         //set validation rules:
         $rules = [
            //specify date, time, nature of the inspection and send to the tenant
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'unique_property_id' => 'required | string | size:10 | exists:propertys',
            'appointment_time' => 'required | string',
            'appointment_date' => 'required | string',
            'appointment_address' => 'required | string',
            'appointment_nature_or_manner_description' => 'nullable | string',//how it is going to be...
        ];

        return $rules;
    }


    protected function scheduleInspectionAppointmentRules(): array
    {
        //set validation rules:
        $rules = [
            //specify date, time, nature of the inspection and send to the tenant
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
            'unique_tenant_id' => 'required | string | size:10 | exists:tenants',
            'unique_property_id' => 'required | string | size:10 | exists:propertys',
            'appointment_time' => 'required | string',
            'appointment_date' => 'required | string',
            'appointment_nature_or_manner_description' => 'nullable | string'//how it is going to be...
        ];

        return $rules;
    }

    protected function viewAllInspectionAppointmentSchedulesRules(): array
    {
        //set validation rules:
        $rules = [
            //specify date, time, nature of the inspection and send to the tenant
            'unique_landlord_id' => 'required | string | size:10 | exists:landlords',
        ];

        return $rules;
    }

}