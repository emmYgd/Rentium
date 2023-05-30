<?php
namespace App\Services\Interfaces\Landlord;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordAccessInterface 
{
	public function Register(Request $request): JsonResponse;
	public function LoginDashboard(Request $request): JsonResponse;

	public function ConfirmLoginState(Request $request): JsonResponse;
    
	public function VerifyAccount(Request $request): JsonResponse;
	public function SendPassordResetToken(Request $request): JsonResponse;
	public function ImplementResetPassword(Request $request): JsonResponse;
	public function Logout(Request $request):  JsonResponse;
}

?>