<?php

namespace App\Services\Traits\ModelAbstraction\Tenant;

use Illuminate\Http\Request;

use App\Services\Traits\ModelCRUD\Social\CommentRatingCRUD;

trait TenantSocialCommentsAndRatingsAbstraction
{
	use CommentRatingCRUD;
	
	protected function TenantCommentsAndRatingsService(Request $request): bool
	{
		$commentRatingValues = [
			'unique_tenant_id' => $request->$unique_tenant_id,
            'unique_landlord_id' => $request->$unique_landlord_id,
		    'tenant_comment' => $request->tenant_comment,
		    'tenant_rating' => $request->tenant_rating,
            'is_tenant_initiated' => true, //defaults to false
            //'is_landlord_initiated' => false, //defaults to false
			//'is_approved_for_view' => false, //defaults to false
            //defaults to false in db...
			//admin has to approve this for view before it can be displayed to other tenants
		];

		//now save first in the comment_rating_table:
		$was_tenant_comment_ratings_saved = $this->CommentRatingCreateAllService($commentRatingValues);
		return $was_tenant_comment_ratings_saved;
	}


	protected function TenantViewOtherTenantsCommentsRatingsOnLandlordService(Request $request): array
	{
        $queryKeysValues = [
            'unique_tenant_id' => $request->unique_tenant_id,
            'unique_landlord_id' => $request->unique_landlord_id,
			'is_tenant_initiated' => true, //defaults to false
            'is_landlord_initiated' => false, //defaults to false
			'is_approved_for_view' => true, //defaults to false
        ];

		//read with query:
		$other_tenants_comments_ratings = $this->ThisTenantViewCommentsRatingsReadAllExceptLazyService($queryKeysValues);
		return $other_tenants_comments_ratings->toArray();
	}

}

?>