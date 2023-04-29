<?php

namespace App\Services\Traits\ModelCRUD\Landlord;

use App\Models\Landlord;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait LandlordCRUD
{
	//CRUD for services:
	protected function LandlordCreateAllService(array $paramsToBeSaved): bool
	{ 
		$createModel = Landlord::create($paramsToBeSaved);
		if($createModel === null)
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


	protected function LandlordReadSpecificAllService(array $queryKeysValues): Collection
	{
		$readSpecificAllModel = Landlord::where($queryKeysValues)->get();
		return $readSpecificAllModel;
	}


	protected function LandlordUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Landlord::where($queryKeysValues)->update($newKeysValues);
		return true;
	}


	protected function LandlordDeleteSpecificService(array $deleteKeysValues): bool
	{
		Landlord::where($deleteKeysValues)->delete();
		return true;
	}

}

?>