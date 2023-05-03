<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface TenantPaymentInterface 
{
	public function UploadBankAccountDetails(Request $request): JsonResponse;
    public function UploadCardDetails(Request $request): JsonResponse;
	public function FetchBankAccountDetails(Request $request): JsonResponse;
    public function FetchAllCardDetails(Request $request): JsonResponse;
}

?>