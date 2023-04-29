<?php

namespace App\Services\Traits\ModelCRUD\PaymentTransaction;

use App\Models\PaymentTransaction;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait PaymentTransactionCRUD 
{
	//CRUD for services:
	protected function PaymentTransactionCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = PaymentTransaction::create($paramsToBeSaved); 	
	    if($createModel === null)
        {
            return false;
        }
        
        return true;
	}


	protected function PaymentTransactionReadSpecificService(array $queryKeysValues): PaymentTransaction | null 
	{	
		$readModel = PaymentTransaction::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function PaymentTransactionReadAllService(): array
	{
		$readAllModel = PaymentTransaction::get();
		return $readAllModel;
	}


	protected function PaymentTransactionReadAllLazyService(): LazyCollection
	{
		$readAllModel = PaymentTransaction::lazy();
		return $readAllModel;
	}


	protected function PaymentTransactionReadAllLazySpecificService(array $queryKeysValues): LazyCollection
	{
		$readAllModel = PaymentTransaction::where($queryKeysValues)->lazy();
		return $readAllModel;
	}


	protected function PaymentTransactionReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = PaymentTransaction::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function PaymentTransactionUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$paymenttransaction_has_updated = PaymentTransaction::where($queryKeysValues)->update($newKeysValues);
		return $paymenttransaction_has_updated;
	}


	protected function PaymentTransactionDeleteSpecificService(array $deleteKeysValues): bool
	{
		PaymentTransaction::where($deleteKeysValues)->delete();
		return true;
	}

    
}

?>