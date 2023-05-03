<?php
namespace App\Services\Interfaces\Admin;

interface AdminReferralInterface 
{
	public function UpdateReferralDetails(Request $request): JsonResponse;
	public function FetchReferralDetails(Request $request): JsonResponse;
	public function DisableReferralProgram(Request $request): JsonResponse;
}

?>