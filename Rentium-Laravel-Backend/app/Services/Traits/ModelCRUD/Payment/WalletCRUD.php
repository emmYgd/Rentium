<?php

namespace App\Services\Traits\ModelCRUD\Payment;

use App\Models\Wallet;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait WalletCRUD 
{
	//CRUD for services:
	protected function WalletCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = Wallet::create($paramsToBeSaved); 	
	    if($createModel === null)
        {
            return false;
        }
        
        return true;
	}


	protected function WalletReadSpecificService(array $queryKeysValues): Wallet | null 
	{	
		$readModel = Wallet::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function WalletReadAllService(): array
	{
		$readAllModel = Wallet::get();
		return $readAllModel;
	}


	protected function WalletReadAllLazyService(): LazyCollection
	{
		$readAllModel = Wallet::lazy();
		return $readAllModel;
	}


	protected function WalletReadAllLazySpecificService(array $queryKeysValues): LazyCollection
	{
		$readAllModel = Wallet::where($queryKeysValues)->lazy();
		return $readAllModel;
	}


	protected function WalletReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = Wallet::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function WalletUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$wallet_has_updated = Wallet::where($queryKeysValues)->update($newKeysValues);
		return $wallet_has_updated;
	}


	protected function WalletDeleteSpecificService(array $deleteKeysValues): bool
	{
		Wallet::where($deleteKeysValues)->delete();
		return true;
	}


}

?>