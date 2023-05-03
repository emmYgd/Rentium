<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordInspectionAppointmentInterface 
{
    //Upon tenant request approval by lanlord or lanlord invitation exploration by tenant, initiate property inspection appointment:
	public function ScheduleInspectionAppointmentForLandlordInvitation(Request $request): JsonResponse;
    public function ScheduleInspectionAppointmentForTenantRequest(Request $request): JsonResponse;
    public function ViewAllInspectionAppointmentSchedules(Request $request): JsonResponse;
    //specify date, time, nature of the inspection and send to the tenant
}