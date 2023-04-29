<?php
namespace App\Services\Interfaces\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface TenantSocialContactInterface 
{
	public function SendAdminMessage(Request $request): JsonResponse;
	public function SendLandlordMessage(Request $request): JsonResponse;
    public function ReadAllAdminMessages(Request $request): JsonResponse;
	public function ReadAllLandlordMessages(Request $request): JsonResponse;
}

?>