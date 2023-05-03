<?php

namespace App\Services\Traits\ModelAbstraction\Admin;

use Illuminate\Http\Request;

use App\Models\Admin\Admin;
use App\Services\Traits\ModelCRUD\Admin\AdminCRUD;
use App\Services\Traits\ModelCRUD\Landlord\LandlordCRUD;
use App\Services\Traits\ModelCRUD\Tenant\TenantCRUD;

trait AdminLandlordTenantFetchAbstraction
{	
	//inherits all their methods:
	use AdminCRUD;
    use LandlordCRUD;
    use TenantCRUD;


	protected function AdminFetchAllLandlordDetailsService(Request $request): array
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }
		$allDetailsFound = $this?->LandlordReadAllLazyService();

		return $allDetailsFound?->toArray();
	}


	protected function AdminFetchAllTenantDetailsService(Request $request): array
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }
		$allDetailsFound = $this?->TenantReadAllLazyService();

		return $allDetailsFound?->toArray();
	}

	protected function AdminFetchEachLandlordDetailService(Request $request) : array
	{
		if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        //query KeyValue Pair:
        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id
        ];
        $eachDetailFound = $this?->LandlordReadSpecificService($queryKeysValues);

		return $eachDetailFound?->toArray();
	}

    
    protected function AdminFetchEachTenantDetailService(Request $request) : array
	{
		if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        //query KeyValue Pair:
        $queryKeysValues = [
            'unique_tenant_id' => $request?->unique_tenant_id
        ];
        $eachDetailFound = $this?->TenantReadSpecificService($queryKeysValues);

		return $eachDetailFound?->toArray();
	}
	
}

?>