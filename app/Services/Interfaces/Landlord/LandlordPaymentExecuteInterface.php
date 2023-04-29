<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordPaymentExecuteInterface 
{
	public function ViewPaymentTransactionDetails(Request $request): JsonResponse;
	public function ViewWalletDetails(Request $request): JsonResponse;
    public function MakeWithdrawalRequest(Request $request): JsonResponse;
}

?>