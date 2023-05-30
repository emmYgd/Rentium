<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Validators\Landlord\LandlordInspectionAppointmentRequestRules;

use App\Services\Interfaces\Landlord\LandlordInspectionAppointmentInterface;
use App\Services\Traits\ModelAbstraction\Landlord\LandlordInspectionAppointmentAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


final class LandlordInspectionAppointmentController extends Controller implements LandlordInspectionAppointmentInterface
{
    use LandlordInspectionAppointmentRequestRules;
    use LandlordInspectionAppointmentAbstraction;
    use ComputeUniqueIDService;

    public function __construct()
    {
        //initialize Landlord Object:
        //public $Landlord = new Landlord;
    }
    

    //Upon landlord invitation approval by tenant
    public function ScheduleInspectionAppointmentForLandlordInvitation(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->scheduleInspectionAppointmentForLandlordInvitationRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $appointment_was_scheduled = $this?->LandlordScheduleInspectionAppointmentForLandlordInvitationService($request);
            if(!$appointment_was_scheduled/*false*/)
            {
                throw new Exception("Appointment could not be scheduled!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'AppointmentScheduled!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'AppointmentNotScheduled!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }//finally{
            return response()?->json($status, 200);
        //}
    }


    //Upon tenant request approval by landlord
    public function ScheduleInspectionAppointmentForTenantRequest(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->scheduleInspectionAppointmentRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $appointment_was_scheduled = $this?->LandlordScheduleInspectionAppointmentForTenantRequestService($request);
            if(!$appointment_was_scheduled/*false*/)
            {
                throw new Exception("Appointment could not be scheduled!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'AppointmentScheduled!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'AppointmentNotScheduled!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }//finally{
            return response()?->json($status, 200);
        //}
    }
    

     //Upon tenant request approval by landlord
     public function ViewAllInspectionAppointmentSchedules(Request $request): JsonResponse
     {
        $status = array();
 
        try
        {
            //get rules from validator class:
            $reqRules = $this?->viewAllInspectionAppointmentSchedulesRules();
 
            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);
 
            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
 
            $appointmentSchedules = $this?->LandlordViewAllInspectionAppointmentSchedulesService($request);
            if( empty($appointmentSchedules))
            {
                throw new Exception("Inspection Appointment Schedules not Found!");
            }
 
            $status = [
                'code' => 1,
                'serverStatus' => 'AppointmentSchedulesFound!',
                'appointmentSchedules' => $appointmentSchedules,
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'AppointmentSchedulesNotFound!',
                'short_description' => $ex?->getMessage()
            ];
 
            return response()?->json($status, 400);
         }//finally{
            return response()?->json($status, 200);
         //}
     }


     public function DeleteInspectionAppointmentSchedule(Request $request): JsonResponse
     {
        $status = array();
 
        try
        {
            //get rules from validator class:
            $reqRules = $this?->deleteInspectionAppointmentScheduleRules();
 
            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);
 
            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
 
            $appointmentSchedules = $this?->LandlordDeleteInspectionAppointmentScheduleService($request);
            if($appointmentSchedules)
            {
                throw new Exception("Inspection Appointment Schedule not Deleted!");
            }
 
            $status = [
                'code' => 1,
                'serverStatus' => 'AppointmentScheduleDeleted!',
                'appointmentSchedules' => $appointmentSchedules,
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'AppointmentSchedulesDeleted!',
                'short_description' => $ex?->getMessage()
            ];
 
            return response()?->json($status, 400);
         }//finally{
            return response()?->json($status, 200);
         //}
     }
}

?>
