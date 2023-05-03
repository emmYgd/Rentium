<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordToTenantInteractionInterface 
{
    //uploads:
    //search either by username, email address, phone-number or tenant_id
	public function SearchForTenant(Request $request): JsonResponse;
    public function SendPropertyInvite(Request $request): JsonResponse;
    //the property which has been sent to a prospective tenant cannot 
    //be available on search by other tenants(i.e. it becomes hidden) until the invite expires (24 hours)
    //To enforce this, a middleware runs before every tenant search(in another tenant controller) to enforce 
    //that this condition holds  
    public function ViewTenantPropertyRequests(Request $request): JsonResponse;
    public function ApproveRejectTenantRequests(Request $request): JsonResponse;
    
    //public function CancelInspectionAppointment(Request $request): JsonResponse;
    //inspection invitation not honoured in 48 hours will be cancelled! and the property made public again;
    //public function AppendSignatureOnAgreement(Request $request): JsonResponse;
}

?>