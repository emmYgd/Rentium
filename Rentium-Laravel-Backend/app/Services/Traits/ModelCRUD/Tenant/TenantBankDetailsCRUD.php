<?php

namespace App\Services\Traits\ModelCRUD\Tenant;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Models\TenantBankDetails;


trait TenantBankDetailsCRUD 
{
	//CRUD for services:
	protected function  TenantBankDetailsCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = TenantBankDetails::create($paramsToBeSaved); 	
		if($createModel === null)
        {
            return false;
        }
        
        return true;		
	}


	protected function  TenantBankDetailsReadSpecificService(array $queryKeysValues): TenantBankDetails | null //Object
	{	
		$readModel = TenantBankDetails::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function  TenantBankDetailsReadAllService(): Collection
	{
		$readAllModel = TenantBankDetails::get();
		return $readAllModel;
	}

	protected function  TenantBankDetailsReadAllLazyService(): array
	{
		$readAllModel = TenantBankDetails::lazy();
		return $readAllModel;
	}


	protected function  TenantBankDetailsReadAllLazySpecificService(array $queryKeysValues): array
	{
		$readAllModel = TenantBankDetails::where($queryKeysValues)->lazy();
		return $readAllModel;
	}

	protected function  TenantBankDetailsReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = TenantBankDetails::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function TenantBankDetailsUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$is_details_updated = TenantBankDetails::where($queryKeysValues)->update($newKeysValues);
        return $is_details_updated;
	}

	protected function  TenantBankDetailsDeleteSpecificService(array $deleteKeysValues): bool
	{
		return TenantBankDetails::where($deleteKeysValues)->delete();
	}

}

?>