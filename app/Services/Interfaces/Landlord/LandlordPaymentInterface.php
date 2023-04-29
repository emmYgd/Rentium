<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordPaymentInterface 
{
	public function UploadBankAccountDetails(Request $request): JsonResponse;
	public function FetchBankAccountDetails(Request $request): JsonResponse;
}

?>