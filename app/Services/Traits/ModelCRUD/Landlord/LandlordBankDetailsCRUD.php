<?php

namespace App\Services\Traits\ModelCRUD\Landlord;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Models\LandlordBankDetails;


trait LandlordBankDetailsCRUD 
{
	//CRUD for services:
	protected function  LandlordBankDetailsCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = LandlordBankDetails::create($paramsToBeSaved); 	
		if($createModel === null)
        {
            return false;
        }
        
        return true;		
	}


	protected function  LandlordBankDetailsReadSpecificService(array $queryKeysValues): LandlordBankDetails | null //Object
	{	
		$readModel = LandlordBankDetails::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function  LandlordBankDetailsReadAllService(): Collection
	{
		$readAllModel = LandlordBankDetails::get();
		return $readAllModel;
	}

	protected function  LandlordBankDetailsReadAllLazyService(): array
	{
		$readAllModel = LandlordBankDetails::lazy();
		return $readAllModel;
	}


	protected function  LandlordBankDetailsReadAllLazySpecificService(array $queryKeysValues): array
	{
		$readAllModel = LandlordBankDetails::where($queryKeysValues)->lazy();
		return $readAllModel;
	}

	protected function  LandlordBankDetailsReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = LandlordBankDetails::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function LandlordBankDetailsUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$is_details_updated = LandlordBankDetails::where($queryKeysValues)->update($newKeysValues);
        return $is_details_updated;
	}

	protected function  LandlordBankDetailsDeleteSpecificService(array $deleteKeysValues): bool
	{
		return LandlordBankDetails::where($deleteKeysValues)->delete();
	}

}

?>