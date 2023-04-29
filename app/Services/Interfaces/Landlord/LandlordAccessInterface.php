<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordAccessInterface 
{
	public function Register(Request $request): JsonResponse;
	public function LoginDashboard(Request $request): JsonResponse;
	public function ConfirmLoginState(Request $request): JsonResponse;
	public function ForgotPassword(Request $request): JsonResponse;
	public function Logout(Request $request):  JsonResponse;
}

?>