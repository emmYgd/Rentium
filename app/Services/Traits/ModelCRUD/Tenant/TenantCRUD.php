<?php

namespace App\Services\Traits\ModelCRUD\Tenant;

use App\Models\Tenant;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait TenantCRUD
{
	//CRUD for services:
	protected function TenantCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = Tenant::create($paramsToBeSaved);
		if($createModel === null)
        {
            return false;
        }
        
        return true;	
	}


	protected function TenantReadSpecificService(array $queryKeysValues): Tenant | null
	{	
		$readModel = Tenant::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function TenantReadAllService(): Collection
	{	
		$readAllModel = Tenant::get();
		return $readAllModel;
	}


	protected function TenantReadSpecificAllService(array $queryKeysValues): array
	{
		$readSpecificAllModel = Tenant::where($queryKeysValues)->get();
		return $readAllModel;
	}

	protected function TenantReadAllLazyService(): LazyCollection 
	{
		//load this in chunk to avoid memory hang:
		$readAllModel = Tenant::lazy();
		return $readAllModel;
	}

	protected function TenantReadAllLazySpecificService(array $queryKeysValues): LazyCollection 
	{
		//load this in chunk to avoid memory hang:
		$readAllModel = Tenant::where($queryKeysValues)->lazy();
		return $readAllModel;
	}

	protected function TenantReadSpecificAllTestNullService(string $queryParam): LazyCollection
	{
		$readSpecificAllModel = Tenant::lazy()->where($queryParam, "!==", null);
		return $readSpecificAllModel;
	}


	protected function TenantUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Tenant::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function TenantDeleteSpecificService(array $deleteKeysValues): bool
	{
		Tenant::where($deleteKeysValues)->delete();
		return true;
	}
}