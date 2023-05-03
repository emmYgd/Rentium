<?php

namespace App\Services\Traits\ModelCRUD\WithdrawalRequest;

use App\Models\WithdrawalRequest;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait WithdrawalRequestCRUD
{
	//CRUD for services:
	protected function WithdrawalRequestCreateAllService(array $paramsToBeSaved): bool
	{ 
		$createModel = WithdrawalRequest::create($paramsToBeSaved);
		if($createModel === null)
        {
            return false;
        }
        
        return true;		
	}

	protected function WithdrawalRequestReadSpecificService(array $queryKeysValues): WithdrawalRequest | null
	{	
		$readModel = WithdrawalRequest::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function WithdrawalRequestReadAllLazyService(): LazyCollection 
	{
		//load this in chunk to avoid memory hang:
		$readAllModel = WithdrawalRequest::lazy();
		return $readAllModel;
	}

	protected function WithdrawalRequestReadAllLazySpecificService(array $queryKeysValues): LazyCollection
	{
		$allWithdrawalRequestPosted = WithdrawalRequest::where($queryKeysValues)->lazy();
		return $allWithdrawalRequestPosted;
	}


	protected function WithdrawalRequestReadSpecificAllService(array $queryKeysValues): Collection
	{
		$readSpecificAllModel = WithdrawalRequest::where($queryKeysValues)->get();
		return $readSpecificAllModel;
	}


	protected function WithdrawalRequestUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		WithdrawalRequest::where($queryKeysValues)->update($newKeysValues);
		return true;
	}


	protected function WithdrawalRequestDeleteSpecificService(array $deleteKeysValues): bool
	{
		WithdrawalRequest::where($deleteKeysValues)->delete();
		return true;
	}

}

?>