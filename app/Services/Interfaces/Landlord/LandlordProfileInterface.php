<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordProfileInterface 
{
	public function EditImage(Request $request):  JsonResponse;
	public function EditProfile(Request $request): JsonResponse;
	public function DeleteProfile(Request $request): JsonResponse;
}

?>