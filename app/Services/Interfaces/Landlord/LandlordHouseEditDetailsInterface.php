<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordHouseEditDetailsInterface 
{
    //edit:
    public function EditHouseTextDetails(Request $request): JsonResponse;
    public function EditHouseImageDetails(Request $request): JsonResponse;
    public function EditHousingClipDetails(Request $request): JsonResponse;
}

?>