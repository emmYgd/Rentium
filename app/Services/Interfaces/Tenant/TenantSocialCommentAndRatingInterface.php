<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface TenantSocialCommentsAndRatingsInterface 
{
    //comment and rate Landlord
    public function CommentsAndRatings(Request $request): JsonResponse;
    public function ViewOtherTenantsCommentsRatingsOnLandlord(Request $request): JsonResponse;
}

?>