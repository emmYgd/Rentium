<?php
namespace App\Services\Interfaces\Admin;

interface AdminLandlordTenantFetchInterface 
{
	public function FetchAllLandlordDetails(Request $request): JsonResponse;
	public function FetchAllTenantDetails(Request $request): JsonResponse;
	public function FetchEachLandlordDetail(Request $request): JsonResponse;
	public function FetchEachTenantDetail(Request $request): JsonResponse;
}

?>