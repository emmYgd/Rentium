<?php
namespace App\Services\Interfaces\Admin;

interface AdminPaymentInterface 
{
	public function SetWithdrawalCharge(Request $request): JsonResponse;
	public function AllLandlordWalletTotal(Request $request): JsonResponse;
	public function TotalWithdrawalPayout(Request $request): JsonResponse;
}

?>