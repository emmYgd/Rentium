<?php

namespace App\Services\Traits\ModelCRUD\Referral;

use App\Models\Referral;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait ReferralCRUD 
{
	//CRUD for services:
	protected function ReferralCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = Referral::create($paramsToBeSaved); 	
	    if($createModel === null)
        {
            return false;
        }
        
        return true;
	}


	protected function ReferralReadSpecificService(array $queryKeysValues): Referral | null 
	{	
		$readModel = Referral::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function ReferralReadAllService(): array
	{
		$readAllModel = Referral::get();
		return $readAllModel;
	}

	protected function ReferralReadAllLazyService(): LazyCollection
	{
		$readAllModel = Referral::lazy();
		return $readAllModel;
	}


	protected function ReferralReadAllLazySpecificService(array $queryKeysValues): LazyCollection
	{
		$readAllModel = Referral::where($queryKeysValues)->lazy();
		return $readAllModel;
	}

	protected function ReferralReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = Referral::where($queryKeysValues)->get();
		return $readAllModel;
	}

	protected function ReferralReadSpecificAllTestNullService(string $queryParam): LazyCollection
	{
		$readSpecificAllModel = Referral::where($queryParam, "!==", null)
											->where($queryParam, "!==", "")
												->lazy();
		return $readSpecificAllModel;
	}

	protected function ReferralUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$referral_has_updated = Referral::where($queryKeysValues)->update($newKeysValues);
		return $referral_has_updated;
	}

	protected function ReferralDeleteSpecificService(array $deleteKeysValues): bool
	{
		Referral::where($deleteKeysValues)->delete();
		return true;
	}

}

?>