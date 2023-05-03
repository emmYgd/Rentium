<?php

namespace App\Services\Traits\ModelCRUD\Admin;

use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

trait AdminCRUD
{
	//CRUD for services:
	
	protected function AdminCreateAllService(Request | array $paramsToBeSaved):bool
	{
		$createModel = Admin::create($paramsToBeSaved);
		if($createModel === null)
        {
            return false;
        }
        
        return true;	
	}


	protected function AdminReadSpecificService(array $queryKeysValues): Admin | null
	{	
		$readModel = Admin::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function AdminReadAllService(): Collection
	{
		$readAllModel = Admin::get();
		return $readAllModel;
	}


	protected function AdminReadSpecificAllService(array $queryKeysValues): Collection
	{
		$readSpecificAllModel = Admin::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function AdminUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Admin::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function AdminDeleteSpecificService(array $deleteKeysValues): bool
	{
	 	Admin::where($deleteKeysValues)->delete();
		return true;
	}

}

?>