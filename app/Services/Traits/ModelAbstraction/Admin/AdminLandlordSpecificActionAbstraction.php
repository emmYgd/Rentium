<?php

namespace App\Services\Traits\ModelAbstraction\Admin;

use Illuminate\Http\Request;

use App\Models\Admin\Admin;
use App\Services\Traits\ModelCRUD\Admin\AdminCRUD;
use App\Services\Traits\ModelCRUD\Landlord\LandlordCRUD;
use App\Services\Traits\ModelCRUD\Landlord\WithdrawalRequestCRUD;
use App\Services\Traits\ModelCRUD\Tenant\TenantCRUD;

trait AdminLandlordSpecificActionAbstraction
{	
	//inherits all their methods:
	use AdminCRUD;
    use LandlordCRUD;
    use WithdrawalRequestCRUD;
    use TenantCRUD;


	protected function AdminViewUnApprovedLandlordWithdrawalRequestsService(Request $request): array
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        $queryKeysValues = [
            'is_admin_approved' => false,
        ];
		$allDetailsFound = $this?->WithdrawalRequestReadAllLazySpecificService($queryKeysValues);

		return $allDetailsFound?->toArray();
	}


	protected function AdminViewApprovedLandlordWithdrawalRequestsService(Request $request): array
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }
		
        $queryKeysValues = [
            'is_admin_approved' => true,
        ];
		$allDetailsFound = $this?->WithdrawalRequestReadAllLazySpecificService($queryKeysValues);

		return $allDetailsFound?->toArray();
	}


	protected function AdminApproveLandlordWithdrawalRequestService(Request $request): bool
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
        ];
		
        $newKeysValues = [
            'is_admin_approved' => true,
        ];
		$was_request_approved = $this?->WithdrawalRequestUpdateSpecificService($queryKeysValues);

		return $was_request_approved;
	}
	
}

?>