<?php

namespace App\Services\Traits\ModelAbstraction\Admin;

use Illuminate\Http\Request;

use App\Models\Admin\Admin;
use App\Services\Traits\ModelCRUD\Admin\AdminCRUD;
use App\Services\Traits\ModelCRUD\Landlord\LandlordCRUD;
use App\Services\Traits\ModelCRUD\Tenant\TenantCRUD;

trait AdminLandlordTenantGeneralActionAbstraction
{	
	//inherits all their methods:
	use AdminCRUD;
    use LandlordCRUD;
    use TenantCRUD;


	protected function AdminBanLandlordService(Request $request): bool
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id
        ];

        $newKeysValues = [
            'is_banned' => true,
        ];
		$was_landlord_banned = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);

		return $was_landlord_banned;
	}


	protected function AdminBanTenantService(Request $request): bool
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        $queryKeysValues = [
            'unique_tenant_id' => $request?->unique_tenant_id
        ];
        
        $newKeysValues = [
            'is_banned' => true,
        ];
		$was_tenant_banned = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);

		return $was_tenant_banned;
	}


    protected function AdminDeleteLandlordService(Request $request): bool
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        $queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id
        ];

		$was_landlord_deleted = $this?->LandlordDeleteSpecificService($queryKeysValues);

		return $was_landlord_deleted;
	}


    protected function AdminDeleteTenantService(Request $request): bool
	{
        if( ($request?->unique_admin_id == null) || ($request?->unique_admin_id == "") )
        {
            throw new Exception("Error! Not an Admin!");
        }

        $queryKeysValues = [
            'unique_tenant_id' => $request?->unique_tenant_id
        ];

		$was_tenant_deleted = $this?->TenantDeleteSpecificService($queryKeysValues);

		return $was_landlord_deleted;
	}

}

?>