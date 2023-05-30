<?php
namespace App\Services\Interfaces\Tenant;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface TenantHouseFetchDetailsInterface 
{
    //fetches:
    public function FetchAllHousingDetailsByCategory(Request $request): JsonResponse;
    //query & order by date created, by location, by price, 
    public function FetchEachHousingDetails(Request $request): JsonResponse;
}

?>