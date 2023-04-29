<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordHouseFetchDetailsInterface 
{
    //fetches:
	public function FetchAllOwnHousingSummary(Request $request): JsonResponse;
    public function FetchEachHousingDetails(Request $request): JsonResponse;
    //public function FetchEachHousingDetailsByCategory(Request $request): JsonResponse;
    //query & order by date created, by location, by price, 
}

?>