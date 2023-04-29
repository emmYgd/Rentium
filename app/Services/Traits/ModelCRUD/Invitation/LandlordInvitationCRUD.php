<?php

namespace App\Services\Traits\ModelCRUD\LandlordInvitation;

use App\Models\LandlordInvitation;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;

trait LandlordInvitationCRUD 
{
	//CRUD for services:
	protected function LandlordInvitationCreateAllService(Request | array $paramsToBeSaved): bool
	{
		$createModel = LandlordInvitation::create($paramsToBeSaved); 	
	    if($createModel === null)
        {
            return false;
        }
        
        return true;
	}


	protected function LandlordInvitationReadSpecificService(array $queryKeysValues): LandlordInvitation | null 
	{	
		$readModel = LandlordInvitation::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function LandlordInvitationReadAllService(): array
	{
		$readAllModel = LandlordInvitation::get();
		return $readAllModel;
	}

	protected function LandlordInvitationReadAllLazyService(): LazyCollection
	{
		$readAllModel = LandlordInvitation::lazy();
		return $readAllModel;
	}


	protected function LandlordInvitationReadAllLazySpecificService(array $queryKeysValues): LazyCollection
	{
		$readAllModel = LandlordInvitation::where($queryKeysValues)->lazy();
		return $readAllModel;
	}

	protected function LandlordInvitationReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = LandlordInvitation::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function LandlordInvitationUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		$landlord_invitation_has_updated = LandlordInvitation::where($queryKeysValues)->update($newKeysValues);
		return $landlord_invitation_has_updated;
	}

	protected function LandlordInvitationDeleteSpecificService(array $deleteKeysValues): bool
	{
		$was_landlord_invitation_deleted = LandlordInvitation::where($deleteKeysValues)->delete();
		return $was_landlord_invitation_deleted;
	}

}

?>