<?php

namespace App\Services\Traits\ModelAbstraction\Tenant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Tenant;
use App\Services\Traits\ModelCRUD\TenantCRUD;
use App\Services\Traits\Utilities\PassHashVerifyService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

trait TenantProfileAbstraction
{	
	//inherits all their methods:
	use TenantCRUD;

    protected function TenantSaveProfileImageService(Request $request): bool
    {
		    /*note: files are to be stored in the database for now...
		    this could change in the future to include storing files on disk 
		    and remote file storage system */

		    $unique_tenant_id = $request?->unique_tenant_id;

            //Images in laravel will be stored in a storage folder while their pointer path will be stored in a database:
            $queryKeysValues = [
                '$unique_tenant_id' => $unique_tenant_id
            ];       

            //first check if this user has a profile image already:   
            $profile_details = $this?->TenantReadSpecificService($queryKeysValues);
            //for images, fetch images whose db link is in the model:
            $profile_image_name = $profile_details?->profile_image;

                //delete this from file store first:
		        Storage::delete($profile_image_name);
                if(false)
                {
                    throw new RuntimeException("Former Profile Image could not be deleted!");
                }
                //new keys and values to replace image links with empty strings: 
                $newKeysValues = [
                    'profile_image' => ''
                ];

                //then, replace the db name with empty strings:
                $profile_image_name_was_deleted = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);
                if(!$profile_image_name_was_deleted)
                {
                    throw new Exception("Image Name wasn't deleted in the database!");
                }

                //Now store the profile image in a storage location on server:
			    //probably stored in: ../storage/app/public/uploads first:  
			    $new_profile_image_name_rep = $request?->file('profile_image')?->store('uploads');
                
                //now store this name rep in db:
                $newQueryKeysValues = [
                    'profile_image' => $new_profile_image_name_rep
                ];
			    $was_profile_image_updated = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);

                return $was_profile_image_updated;       
	}


    //update each fields without mass assignment: Specific Logic 
	protected function TenantUpdateEachService(Request $request): bool
	{
		$unique_tenant_id = $request?->unique_tenant_id;

			$request = $request?->except('unique_tenant_id');

			foreach($request as $reqKey => $reqValue)
			{
				$queryKeysValues = [
					'unique_tenant_id' => $unique_tenant_id
				];

				if(is_array($reqValue))
				{
					$newKeysValues = [
                        $reqKey => json_encode($reqValue)
                    ];
				}
				else
				{
					$newKeysValues = [
                        $reqKey => $reqValue
                    ];
				}
				$were_tenant_profile_details_updated = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);
                if(!$were_tenant_profile_details_updated)
                {
                    throw new Exception("Update not Successful!");
                }
            }
		return true;
	}


    protected function TenantDeleteProfileService(Request $request): bool
    {
        $unique_tenant_id = $request?->unique_tenant_id;

        $queryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id
        ];

        $newKeysValues = [
            'tenant_first_name' => '',
            'tenant_middle_name' => '',
            'tenant_last_name' => 'string',
            'tenant_phone_number' => '',
            'tenant_username' => '',
        ];
        $were_profile_details_deleted = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);
        return $were_profile_details_deleted;
    }


}

?>