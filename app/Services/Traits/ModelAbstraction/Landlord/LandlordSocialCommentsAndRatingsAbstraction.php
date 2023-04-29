<?php

namespace App\Services\Traits\ModelAbstraction;

use Illuminate\Http\Request;

use App\Services\Traits\ModelCRUD\Social\CommentRatingCRUD;

trait LandlordSocialCommentsAndRatingsAbstraction
{
	use CommentRatingCRUD;
	
	protected function LandlordCommentsAndRatingsService(Request $request): bool
	{
		$commentRatingValues = [
			'unique_landlord_id' => $request->$unique_landlord_id,
            'unique_landlord_id' => $request->$unique_landlord_id,
		    'landlord_comment' => $request->landlord_comment,
		    'landlord_rating' => $request->landlord_rating,
            'is_landlord_initiated' => true, //defaults to false
            //'is_tenant_initiated' => false, //defaults to false
			//'is_approved_for_view' => false, //defaults to false
            //defaults to false in db...
			//admin has to approve this for view before it can be displayed to other landlords
		];

		//now save first in the comment_rating_table:
		$was_landlord_comment_rating_saved = $this->CommentRatingCreateAllService($commentRatingValues);
		return $was_landlord_comment_rating_saved;
	}


	protected function LandlordViewAllTenantsCommentsRatingsAboutSelfService(Request $request): array
	{
        $queryKeysValues = [
            'unique_landlord_id' => $request->unique_landlord_id,
			'is_tenant_initiated' => false, //defaults to false
            'is_landlord_initiated' => true, //defaults to false
			'is_approved_for_view' => true, //defaults to false
        ];

		//read with query:
		$all_tenants_comments_ratings = this->ThisLandlordViewCommentsRatingsAboutThisReadAllLazyService($queryKeysValues);
		return $all_tenants_comments_ratings->toArray();
	}


	protected function LandlordViewOtherLandlordsCommentsRatingsOnTenantService(Request $request): array
	{
        $queryKeysValues = [
            'unique_landlord_id' => $request->unique_landlord_id,
            'unique_tenant_id' => $request->unique_tenant_id,
			'is_tenant_initiated' => false, //defaults to false
            'is_landlord_initiated' => true, //defaults to false
			'is_approved_for_view' => true, //defaults to false
        ];

		//read with query:
		$other_landlords_comments_ratings = $this->ThisLandlordViewOtherCommentsRatingsAboutThisTenantReadAllLazyService($queryKeysValues);
		return $other_landlords_comments_ratings->toArray();
	}

}

?>