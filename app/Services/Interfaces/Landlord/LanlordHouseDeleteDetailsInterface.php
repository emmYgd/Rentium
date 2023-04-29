<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordHouseTextDetailsInterface 
{
    //delete:
	public function DeleteSpecificHouseDetails(Request $request): JsonResponse;
    public function DeleteAllPropertyRecords(Request $request): JsonResponse;
}

?>