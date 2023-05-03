<?php
namespace App\Services\Interfaces\Admin;

interface AdminSocialCommentsAndRatingsInterface 
{
	public function ViewAllUnApprovedCommentsAndRatings(Request $request): JsonResponse;
	public function ViewAllApprovedCommentsRatings(Request $request): JsonResponse;
	public function ApproveCommentRating(Request $request): JsonResponse;
}

?>