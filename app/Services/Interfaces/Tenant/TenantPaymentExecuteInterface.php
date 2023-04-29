<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface TenantPaymentExecuteInterface 
{
	public function MakePaymentByNewBankAccount(Request $request): JsonResponse;
    public function MakePaymentBySavedBankAccount(Request $request): JsonResponse;
    public function MakePaymentByNewBankCard(Request $request): JsonResponse;
    public function MakePaymentBySavedBankCard(Request $request): JsonResponse;
}

?>