<?php
namespace App\Services\Interfaces\Admin;

interface AdminLandlordTenantGeneralActionInterface 
{
	public function BanLandlord(Request $request): JsonResponse;
	public function BanTenant(Request $request): JsonResponse;
	public function DeleteLandlord(Request $request): JsonResponse;
	public function DeleteTenant(Request $request): JsonResponse;
}

?>