<?php
namespace App\Services\Interfaces\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface AdminSocialContactInterface 
{
	public function SendLandlordMessage(Request $request): JsonResponse;
	public function SendTenantMessage(Request $request): JsonResponse;
    public function ReadAllLandlordMessages(Request $request): JsonResponse;
	public function ReadAllTenantMessages(Request $request): JsonResponse;
}

?>