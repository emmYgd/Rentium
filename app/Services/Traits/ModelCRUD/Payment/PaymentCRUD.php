<?php

namespace App\Services\Traits\ModelCRUD\Payment;

use App\Models\Payment;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait PaymentCRUD 
{
	//CRUD for services:
	protected function PaymentCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = Payment::create($paramsToBeSaved); 	
	    if($createModel === null)
        {
            return false;
        }
        
        return true;
	}


	protected function PaymentReadSpecificService(array $queryKeysValues): Payment | null 
	{	
		$readModel = Payment::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function PaymentReadAllService(): array
	{
		$readAllModel = Payment::get();
		return $readAllModel;
	}


	protected function PaymentReadAllLazyService(): LazyCollection
	{
		$readAllModel = Payment::lazy();
		return $readAllModel;
	}


	protected function PaymentReadAllLazySpecificService(array $queryKeysValues): LazyCollection
	{
		$readAllModel = Payment::where($queryKeysValues)->lazy();
		return $readAllModel;
	}


	protected function PaymentReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = Payment::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function PaymentUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$payment_has_updated = Payment::where($queryKeysValues)->update($newKeysValues);
		return $payment_has_updated;
	}


	protected function PaymentDeleteSpecificService(array $deleteKeysValues): bool
	{
		Payment::where($deleteKeysValues)->delete();
		return true;
	}

    
}

?>