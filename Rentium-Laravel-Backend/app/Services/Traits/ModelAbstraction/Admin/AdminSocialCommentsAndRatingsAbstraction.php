<?php

namespace App\Services\Traits\ModelAbstraction;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Services\Traits\ModelCRUD\Social\CommentRatingCRUD;

trait AdminSocialCommentsAndRatingsAbstraction
{
	use CommentRatingCRUD;
	
	protected function AdminViewAllUnApprovedCommentsAndRatingsService(Request $request): array
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        //To read:
        $queryKeysValues = [
            'is_admin_approved' => false,
        ];
		$all_comments_ratings = $this->CommentRatingReadAllLazySpecificService($queryKeysValues);

		return $all_comments_ratings->toArray();
	}


	protected function AdminViewAllApprovedCommentsRatingsService(Request $request): array
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        //To read:
        $queryKeysValues = [
            'is_admin_approved' => true,
        ];
		$all_comments_ratings = $this->CommentRatingReadAllLazySpecificService($queryKeysValues);

		return $all_comments_ratings->toArray();
	}


    protected function AdminApproveCommentRatingService(Request $request): bool
    {
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        //to update:
        //init:
        $queryKeysValues = array();
        //assign:
        $unique_landlord_id = $request?->unique_landlord_id;
        $unique_tenant_id = $request?->unique_tenant_id;
        if( 
            ($unique_landlord_id !== null) 
            && 
            ($unique_landlord_id !== "") 
        )
        {
            Arr::add($queryKeysValues, 'unique_landlord_id', $unique_landlord_id);
        }

        if( 
            ($unique_tenant_id !== null) 
            && 
            ($unique_tenant_id !== "") 
        )
        {
            Arr::add($queryKeysValues, 'unique_tenant_id', $unique_tenant_id);
        }

        $newKeysValues = [
            'is_admin_approved' => true,        
        ];

        $was_comment_rating_updated = $this->CommentRatingUpdateSpecificService($queryKeysValues, $newKeysValues);
        
        return $was_comment_rating_updated;
    }
}

?>