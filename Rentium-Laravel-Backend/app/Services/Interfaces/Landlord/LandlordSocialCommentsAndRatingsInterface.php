<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface LandlordSocialCommentsAndRatingsInterface 
{
    //comment and rate tenants:
    public function CommentsAndRatings(Request $request): JsonResponse;
    public function ViewOtherLandlordsCommentsRatingsOnTenant(Request $request): JsonResponse;
}

?>