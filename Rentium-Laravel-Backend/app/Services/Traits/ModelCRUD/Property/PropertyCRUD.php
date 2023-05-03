<?php

namespace App\Services\Traits\ModelCRUD\Property;

use App\Models\Property;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait PropertyCRUD 
{
	//CRUD for services:
	protected function PropertyCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = Property::create($paramsToBeSaved); 	
	    if($createModel === null)
        {
            return false;
        }
        
        return true;
	}


	protected function PropertyReadSpecificService(array $queryKeysValues): Property | null 
	{	
		$readModel = Property::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function PropertyReadAllService(): array
	{
		$readAllModel = Property::get();
		return $readAllModel;
	}

	protected function PropertyReadAllLazyService(): LazyCollection
	{
		$readAllModel = Property::lazy();
		return $readAllModel;
	}


	protected function PropertyReadAllLazySpecificService(array $queryKeysValues): LazyCollection
	{
		$readAllModel = Property::where($queryKeysValues)->lazy();
		return $readAllModel;
	}

	protected function PropertyReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = Property::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function PropertyUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$property_has_updated = Property::where($queryKeysValues)->update($newKeysValues);
		return $property_has_updated;
	}

	protected function PropertyDeleteSpecificService(array $deleteKeysValues): bool
	{
		Property::where($deleteKeysValues)->delete();
		return true;
	}

}

?>