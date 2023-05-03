<?php
namespace App\Services\Interfaces\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordSocialContactInterface 
{
	public function SendAdminMessage(Request $request): JsonResponse;
	public function SendTenantMessage(Request $request): JsonResponse;
    public function ReadAllAdminMessages(Request $request): JsonResponse;
	public function ReadAllTenantMessages(Request $request): JsonResponse;
}

?>