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


trait LandlordToTenantInteractionsAbstraction
{	
	//inherits all their methods:
	use TenantCRUD;
    use LandlordInvitationCRUD;
    use TenantRequestCRUD;
    use PropertyCRUD;
    use ComputeUniqueIDService;


    protected function LandlordSearchForTenantService(Request $request): array
    {
        $unique_tenant_id = $request->unique_tenant_id;
        $tenant_username = $request->tenant_username;
        $tenant_email = $request->tenant_email;
        $tenant_phone_number = $request->tenant_phone_number;

        //init:
        $queryKeysValues = array();

        if( ($unique_tenant_id !== null) && ($unique_tenant_id !== "") )
        {
            Arr::add($queryKeysValues, 'unique_tenant_id', $unique_tenant_id);
        }
        elseif ( ($tenant_username !== null) && ($tenant_username !== "") ) 
        {
            Arr::add($queryKeysValues, 'tenant_username', $tenant_username);
        }
        elseif ( ($tenant_email !== null) && ($tenant_email !== "") ) 
        {
            Arr::add($queryKeysValues, 'tenant_email', $tenant_email);
        }
        elseif ( ($tenant_phone_number !== null) && ($tenant_phone_number !== "") ) 
        {
            Arr::add($queryKeysValues, 'tenant_phone_number', $tenant_phone_number);
        }

        //use this query to get the tenant:
        $tenant_details = $this?->TenantReadSpecificService($queryKeysValues);
        return $tenant_details?->toArray();
	}


	protected function LandlordSendPropertyInviteService(Request $request): bool
	{
		/*there is an invitation table which stores all invitation instances:
        Both landlord table and tenant table have  a hasMany relationship with this invitation table instance...*/
		$queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
            'unique_tenant_id' => $request?->unique_tenant_id,
            'unique_property_id' => $request?->unique_property_id,
            //create a new unique_invitation_id
            'unique_invitation_id' => $this->genUniqueNumericId()
        ];

        $was_invitation_created = $this?->LandlordInvitationCreateAllService($queryKeysValues);
        if(!$was_invitation_created)
        {
            return false;
        }

        /*change this property instance to hidden from public search and 
        listings from the view-point of the tenant:*/
        $queryKeysValues = Arr::except($queryKeysValues, ['unique_tenant_id']);
		$newKeysValues = [
            'is_hidden' => true //this is false by default
        ];
        $was_property_updated = $this?->PropertyUpdateSpecificService($queryKeysValues, $newKeysValues);
		if(!$was_property_updated)
        {
            return false;
        }

        return true;
	}


    protected function LandlordViewTenantPropertyRequestsService(Request $request): array
    {
        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
            'is_property_claimed' => false
        ];
        //read all requests made by the prospective tenants to this landlord's property:
        $property_request_model = $this->TenantRequestReadAllLazySpecificService($queryKeysValues);
        return $property_request_model->toArray();
    }


    protected function LandlordApproveRejectTenantRequestsService(Request $request): bool
    {
        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
        ];

        $newKeysValues = [
            'is_request_approved' => $request?->is_request_approved,
        ];

        //update landlord's tenant property request approval:
        $was_request_approval_updated = $this->TenantRequestUpdateSpecificService($queryKeysValues, $newKeysValues);

        if($request?->is_request_approved == true)
        {
            $publicPropertyVisibilityQueryKeysValue = [
                'unique_landlord_id' => $request?->unique_landlord_id,
                'unique_tenant_id' => $request?->unique_tenant_id,
                'unique_property_id' => $request?->unique_property_id, 
            ];

            //update this specific property such as it is hidden from public for the next 24 hours:
            $publicPropertyVisibilityNewKeysValues = [
                'is_hidden' => true //this is false by default
            ];
            $was_property_updated = $this?->PropertyUpdateSpecificService($queryKeysValues, $newKeysValues);
            if(!$was_property_updated)
            {
                return false;
            }
        }
        return $was_request_approval_updated;
    }

}

?>