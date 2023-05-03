<?php

namespace App\Services\Traits\ModelCRUD\Contact;

use App\Models\Contact;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait ContactCRUD
{
	//CRUD for services:
	protected function ContactCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = Contact::create($paramsToBeSaved);
		if($createModel === null)
        {
            return false;
        }
        
        return true;	
	}


	protected function ContactReadSpecificService(array $queryKeysValues): Contact | null
	{	
		$readModel = Contact::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function ContactReadAllService(): Collection
	{	
		$readAllModel = Contact::get();
		return $readAllModel;
	}


	protected function ContactReadSpecificAllService(array $queryKeysValues): array
	{
		$readSpecificAllModel = Contact::where($queryKeysValues)->get();
		return $readAllModel;
	}

	protected function ContactReadAllLazyService(): LazyCollection 
	{
		//load this in chunk to avoid memory hang:
		$readAllModel = Contact::lazy();
		return $readAllModel;
	}

	protected function ContactReadAllLazySpecificService(array $queryKeysValues): LazyCollection 
	{
		//load this in chunk to avoid memory hang:
		$readAllModel = Contact::where($queryKeysValues)->lazy();
		return $readAllModel;
	}


	/*protected function ContactReadAllLazyExceptSpecificService(string $queryParam)
	{
		Contact::where('', '', )
	}*/

	protected function ContactReadLazySpecificAllTestNullService(string $queryParam): LazyCollection
	{
		$readSpecificAllModel = Contact::lazy()->where($queryParam, "!==", null);
		return $readSpecificAllModel;
	}


	protected function ContactUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Contact::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function ContactDeleteSpecificService(array $deleteKeysValues): bool
	{
		Contact::where($deleteKeysValues)->delete();
		return true;
	}
}