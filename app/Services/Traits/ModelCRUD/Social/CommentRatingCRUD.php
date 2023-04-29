<?php

namespace App\Services\Traits\ModelCRUD\Social;

use Illuminate\Http\Request;

use App\Models\CommentRating;

trait CommentRatingCRUD
{
	//CRUD for services:
	protected function CommentRatingCreateAllService(Request | array $paramsToBeSaved):bool
	{
		$createModel = CommentRating::create($anyParams);
		if($createModel === null)
        {
            return false;
        }
        
        return true;			
	}


	protected function CommentRatingReadSpecificService(array $queryKeysValues): array
	{	
		$readModel = CommentRating::where($queryKeysValues)->first();
		return $readModel;
	}


	/*protected function CommentRatingReadAllService(): array 
	{
		$readAllModel = CommentRating::get();
		return $readAllModel;
	}*/

	protected function CommentRatingReadAllLazySpecificService(array $queryKeysValues): array 
	{
		$readAllModel = CommentRating::where($queryKeysValues)->lazy()->orderByDesc('rating');
		return $readAllModel;
	}
	

	protected function CommentRatingReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = CommentRating::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function ThisTenantViewCommentsRatingsReadAllExceptLazyService(array $queryKeysValues): LazyCollection
	{
		//admin has to approve this for view before it can be displayed to other tenants

		//view all comments and ratings initiated by other tenants about specific landlord
			$otherTenantsCommentsRatingsExceptThis = CommentRating::
				where('unique_tenant_id', '!==', $queryKeysValues['unique_tenant_id'])
					->where('unique_landlord_id', '===', $queryKeysValues['unique_landlord_id'])
					->where('is_tenant_initiated', '===', $queryKeysValues['is_tenant_initiated'])
					->where('is_landlord_initiated', '===', $queryKeysValues['is_tenant_initiated'])
					->where('is_approved_for_view', '===', $queryKeysValues['is_approved_for_view'])
						->lazy();
			
			return $otherTenantsCommentsRatingsExceptThis;
	}


	protected function ThisLandlordViewCommentsRatingsAboutThisReadAllLazyService(array $queryKeysValues): LazyCollection
	{
		//view all comments and ratings initiated by many Tenants about this landlord
		$allTenantsCommentsRatingsAboutThisLandlord = CommentRating::
			where('unique_landlord_id', '===', $queryKeysValues['unique_landlord_id'])
				//->where('unique_tenant_id', '===', $queryKeysValues['unique_tenant_id'])
				->where('is_tenant_initiated', '===', $queryKeysValues['is_tenant_initiated'])
				->where('is_landlord_initiated', '===', $queryKeysValues['is_tenant_initiated'])
				->where('is_approved_for_view', '===', $queryKeysValues['is_approved_for_view'])
					->lazy();
			
		return $allTenantsCommentsRatingsAboutThisLandlord;
	}


	protected function ThisLandlordViewOtherCommentsRatingsAboutThisTenantReadAllLazyService(array $queryKeysValues): LazyCollection
	{
		//view all comments and ratings initiated by many other about this landlord
		$otherLandlordsCommentsRatingsAboutTenantExceptThis = CommentRating::
			where('unique_landlord_id', '!==', $queryKeysValues['unique_landlord_id'])
				->where('unique_tenant_id', '===', $queryKeysValues['unique_tenant_id'])
				->where('is_tenant_initiated', '===', $queryKeysValues['is_tenant_initiated'])
				->where('is_landlord_initiated', '===', $queryKeysValues['is_tenant_initiated'])
				->where('is_approved_for_view', '===', $queryKeysValues['is_approved_for_view'])
					->lazy();
			
		return $otherLandlordsCommentsRatingsAboutTenantExceptThis;
	}

	protected function CommentRatingUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool 
	{
		CommentRating::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function CommentRatingDeleteSpecificService(array $deleteKeysValues): bool
	{
		CommentRating::where($deleteKeysValues)->delete();
		return true;
	}

}

?>