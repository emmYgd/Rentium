<?php

namespace App\Services\Traits\ModelCRUD\TenantRequest;

use App\Models\TenantRequest;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait TenantRequestCRUD 
{
	//CRUD for services:
	protected function TenantRequestCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = TenantRequest::create($paramsToBeSaved); 	
	    if($createModel === null)
        {
            return false;
        }
        
        return true;
	}


	protected function TenantRequestReadSpecificService(array $queryKeysValues): TenantRequest | null 
	{	
		$readModel = TenantRequest::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function TenantRequestReadAllService(): array
	{
		$readAllModel = TenantRequest::get();
		return $readAllModel;
	}

	protected function TenantRequestReadAllLazyService(): LazyCollection
	{
		$readAllModel = TenantRequest::lazy();
		return $readAllModel;
	}


	protected function TenantRequestReadAllLazySpecificService(array $queryKeysValues): LazyCollection
	{
		$readAllModel = TenantRequest::where($queryKeysValues)->lazy();
		return $readAllModel;
	}

	protected function TenantRequestReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = TenantRequest::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function TenantRequestUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$tenant_request_has_updated = TenantRequest::where($queryKeysValues)->update($newKeysValues);
		return $tenant_request_has_updated;
	}

	protected function TenantRequestDeleteSpecificService(array $deleteKeysValues): bool
	{
		$was_tenant_request_deleted = TenantRequest::where($deleteKeysValues)->delete();
		return $was_tenant_request_deleted;
	}

}

?>