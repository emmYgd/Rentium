<?php
namespace App\Services\Interfaces\Tenant;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface TenantAccessInterface 
{
	public function Register(Request $request): JsonResponse;
	public function LoginDashboard(Request $request): JsonResponse;
	public function VerifyAccount(Request $request): JsonResponse;
	public function SendResetPassLink(Request $request): JsonResponse;
	public function ClickResetPasswordLink(string $reset, string $answer): JsonResponse;
	public function ImplementResetPassword(Request $request): JsonResponse;
	public function Logout(Request $request):  JsonResponse;
}

?>