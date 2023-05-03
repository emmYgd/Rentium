<?php

namespace App\Services\Traits\ModelAbstraction\Landlord;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use App\Services\Traits\ModelCRUD\Tenant\TenantCRUD;
use App\Services\Traits\ModelCRUD\Invitation\LandlordInvitationCRUD;
use App\Services\Traits\ModelCRUD\Request\TenantRequestCRUD;
use App\Services\Traits\ModelCRUD\Property\PropertyCRUD;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


trait TenantToLandlordInteractionsAbstraction
{	
	//inherits all their methods:
	use TenantCRUD;
    use LandlordInvitationCRUD;
    use TenantRequestCRUD;
    use PropertyCRUD;
    use ComputeUniqueIDService;


    protected function TenantSearchForLandlordService(Request $request): array
    {
        $unique_landlord_id = $request->unique_landlord_id;
        $landlord_username = $request->landlord_username;
        $landlord_email = $request->landlord_email;
        $landlord_phone_number = $request->landlord_phone_number;

        //init:
        $queryKeysValues = array();

        if( ($unique_landlord_id !== null) && ($unique_landlord_id !== "") )
        {
            Arr::add($queryKeysValues, 'unique_landlord_id', $unique_landlord_id);
        }
        elseif( (($unique_property_id !== null) && ($unique_property_id !== "")) )
        {
            //first search for the landlord id that owns this property id:
            $owner_landlord_id = $this?->PropertyReadSpecificService($queryKeysValues)->unique_landlord_id;
            //then add to the lanlord details query array:
            Arr::add($queryKeysValues, 'unique_landlord_id', $owner_landlord_id);
        }
        elseif ( ($landlord_username !== null) && ($landlord_username !== "") ) 
        {
            Arr::add($queryKeysValues, 'landlord_username', $landlord_username);
        }
        elseif ( ($landlord_email !== null) && ($landlord_email !== "") ) 
        {
            Arr::add($queryKeysValues, 'landlord_email', $landlord_email);
        }
        elseif ( ($landlord_phone_number !== null) && ($landlord_phone_number !== "") ) 
        {
            Arr::add($queryKeysValues, 'landlord_phone_number', $landlord_phone_number);
        }

        //use this query to get the tenant:
        $landlord_details = $this?->LandlordReadSpecificService($queryKeysValues);
        return $landlord_details?->toArray();
	}


	protected function TenantSearchForPropertyInvitationsService(Request $request): bool
	{
		/*there is an invitation table which stores all invitation instances:
        Both landlord table and tenant table have  a hasMany relationship with this invitation table instance...*/
		$queryKeysValues = [
            'unique_tenant_id' => $request?->unique_tenant_id,
        ];

        $invitation_details = $this?->LandlordInvitationReadAllLazySpecificService($queryKeysValues);
        
        return $invitation_details;
	}


    protected function TenantShowInterestInPropertyInvitationsService(Request $request): array
    {
        $queryKeysValues = [
            'unique_tenant_id' => $request?->unique_tenant_id,
            'unique_landlord_id' => $request?->unique_landlord_id,
            'unique_property_id' => $request?->unique_property_id,
            //'is_property_claimed' => false
        ];

        $newKeysValues = [
            'is_interest_shown' => $request?->is_interest_shown,//defaults to false
        ];

        //read all requests made by the prospective tenants to this landlord's property:
        $was_interest_shown = $this->LandlordInvitationUpdateSpecificService($queryKeysValues, $newKeysValues);
        return $was_interest_shown;
    }


    protected function TenantMakePropertyRequestService(Request $request): bool
    {
        $newRequestsKeysValues = [
            'unique_tenant_id' => $request?->unique_tenant_id,
            'unique_landlord_id' => $request?->unique_landlord_id,
            'unique_property_id' => $request?->unique_property_id,
            'unique_tenant_request_id' => $this?->genUniqueNumericId(),
            //'is_request_approved' => false //defaults to false in db 
        ];

        //update landlord's tenant property request approval:
        $was_tenant_request_made = $this->TenantRequestCreateAllService($newRequestsKeysValues);

        return $was_tenant_request_made;
    }

}

?>