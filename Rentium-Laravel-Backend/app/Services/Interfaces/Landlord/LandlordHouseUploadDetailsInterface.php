<?php
namespace App\Services\Interfaces\Landlord;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordHouseUploadDetailsInterface 
{
    //uploads:
	public function UploadHouseTextDetails(Request $request): JsonResponse;
    public function UploadHouseImageDetails(Request $request): JsonResponse;
    public function UploadHouseClip(Request $request): JsonResponse;
}

?>