<?php
namespace App\Services\Interfaces\Admin;

interface AdminLandlordSpecificActionInterface 
{
	public function ViewAllUnApprovedLandlordWithdrawalRequests(Request $request): JsonResponse;
	public function ViewAllApprovedLandlordWithdrawalRequests(Request $request): JsonResponse;
	public function ApproveLandlordWithdrawalRequest(Request $request): JsonResponse;
}

?>