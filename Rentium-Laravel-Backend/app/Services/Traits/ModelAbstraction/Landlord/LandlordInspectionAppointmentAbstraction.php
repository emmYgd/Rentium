<?php

namespace App\Services\Traits\ModelAbstraction\Landlord;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use App\Services\Traits\ModelCRUD\Tenant\TenantCRUD;
use App\Services\Traits\ModelCRUD\Invitation\LandlordInvitationCRUD;
use App\Services\Traits\ModelCRUD\Request\TenantRequestCRUD;
use App\Services\Traits\ModelCRUD\Property\PropertyCRUD;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


trait LandlordInspectionAppointmentAbstraction
{	
	//inherits all their methods:
	use TenantCRUD;
    use LandlordInvitationCRUD;
    use TenantRequestCRUD;
    use PropertyCRUD;
    use ComputeUniqueIDService;

    protected function LandlordScheduleInspectionAppointmentForLandlordInvitationService(Request $request): bool
    {
        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
            'unique_tenant_id' => $request?->unique_tenant_id,
            'unique_property_id' => $request?->unique_property_id,
            'is_interest_shown' => true,
        ];

        $newKeysValues = [
            'appointment_time' => $request?->appointment_time,
            'appointment_date' => $request?->appointment_date,
            'appointment_address' => $request?->appointment_address,
            'appointment_nature_or_manner_description' => $request?->appointment_nature_or_manner_description
        ];
        
        //schedule appointment:
        $was_appointment_sent = $this->LandlordInvitationUpdateSpecificService($queryKeysValues, $newKeysValues);
        return $was_appointment_sent;
    }


    protected function LandlordScheduleInspectionAppointmentForTenantRequestService(Request $request): bool
    {
        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
            'unique_tenant_id' => $request?->unique_tenant_id,
            'unique_property_id' => $request?->unique_property_id,
            'is_request_approved' => true,
        ];

        $newKeysValues = [
            'appointment_time' => $request?->appointment_time,
            'appointment_date' => $request?->appointment_date,
            'appointment_address' => $request->appointment_address,
            'appointment_nature_or_manner_description' => $request?->appointment_nature_or_manner_description
        ];
        
        //schedule appointment:
        $was_appointment_sent = $this->TenantRequestUpdateSpecificService($queryKeysValues);
        return $was_appointment_sent;
    }


    protected function LandlordViewAllInspectionAppointmentSchedulesService(Request $request): array
    {
        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
            'is_invitation_explored' => true,
            'is_property_claimed' => false,
        ];
        
        /*$queryKeysValues2 = [
            'unique_landlord_id' => $request?->unique_landlord_id,
            'is_request_approved' => true,
            'is_property_claimed' => false,
        ];*/
        
        //view all appointment schedules for both:
        //Landlord Invitation:
        $inspectionAppointmentModels1 = $this->LandlordInvitationReadAllLazySpecificService($queryKeysValues);
        //And Tenant Request:
        $inspectionAppointmentModels2 = $this->TenantRequestReadAllLazySpecificService($queryKeysValues);

        $returnArray = [
            'AppointmentsAfterLandlordInvites' => $inspectionAppointmentModels1->toArray(),
            'AppointmentsAfterLandlordInvites' => $inspectionAppointmentModels2->toArray(),
        ];
        return $returnArray;
    }                                                                                                                                                          

}

?>