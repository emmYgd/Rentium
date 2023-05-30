<?php

namespace App\Services\Traits\ModelCRUD\Tenant;

use App\Models\Tenant\Tenant;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait TenantCRUD
{
	//CRUD for services:
	protected function TenantCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = Tenant::create($paramsToBeSaved);
		if(!$createModel)
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
		return $readSpecificAllModel;
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
		$readAllModels = Tenant::where($queryKeysValues)->lazy();
		return $readAllModels;
	}

	protected function TenantReadSpecificAllTestNullService(string $queryParam): LazyCollection
	{
		$readSpecificAllModel = Tenant::where($queryParam, "!==", null)
										->where($queryParam, "!==", "")
										->lazy();
		return $readSpecificAllModel;
	}


	protected function TenantUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$tenantModelUpdate = Tenant::where($queryKeysValues)->update($newKeysValues);
		if(!$tenantModelUpdate)
		{
			return false;
		}
		return true;
	}

	protected function TenantDeleteSpecificService(array $deleteKeysValues): bool
	{
		$tenantModelDelete = Tenant::where($deleteKeysValues)->delete();
		if(!$tenantModelDelete)
		{
			return false;
		}
		return true;
	}
}