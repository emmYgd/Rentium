<?php

namespace App\Services\Traits\ModelCRUD\Landlord;


use App\Models\Landlord\Landlord;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait LandlordCRUD
{
	//CRUD for services:
	protected function LandlordCreateAllService(array $paramsToBeSaved): bool
	{ 
		$createModel = Landlord::create($paramsToBeSaved);
		if(!$createModel)
        {
            return false;
        }
        
        return true;		
	}


	protected function LandlordReadSpecificService(array $queryKeysValues): Landlord | null
	{	
		$readModel = Landlord::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function LandlordReadAllLazyService(): LazyCollection 
	{
		//load this in chunk to avoid memory hang:
		$readAllModel = Landlord::lazy();
		return $readAllModel;
	}

	protected function LandlordReadAllLazySpecificService(array $queryKeysValues): LazyCollection
	{
		$allLandlordPosted = Landlord::where($queryKeysValues)->lazy();
		return $allLandlordPosted;
	}

	protected function LandlordReadSpecificAllTestNullService(string $queryParam): LazyCollection
	{
		$readSpecificAllModel = Landlord::where($queryParam, "!==", null)
										->where($queryParam, "!==", "")
										->lazy();
		return $readSpecificAllModel;
	}


	protected function LandlordReadSpecificAllService(array $queryKeysValues): Collection
	{
		$readSpecificAllModel = Landlord::where($queryKeysValues)->get();
		return $readSpecificAllModel;
	}


	protected function LandlordUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$landlordModelUpdate = Landlord::where($queryKeysValues)->update($newKeysValues);
		if(!$landlordModelUpdate)
		{
			return false;
		}
		return true;
	}


	protected function LandlordDeleteSpecificService(array $deleteKeysValues): bool
	{
		$landlordModelDelete = Landlord::where($deleteKeysValues)->delete();
		if(!$landlordModelDelete)
		{
			return false;
		}
		return true;
	}

}

?>