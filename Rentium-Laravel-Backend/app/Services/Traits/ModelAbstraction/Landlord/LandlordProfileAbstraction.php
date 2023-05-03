<?php

namespace App\Services\Traits\ModelAbstraction\Landlord;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Services\Traits\ModelCRUD\Landlord\LandlordCRUD;
use App\Services\Traits\Utilities\PassHashVerifyService;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

trait LandlordProfileAbstraction
{	
	//inherits all their methods:
	use LandlordCRUD;

    protected function LandlordSaveProfileImageService(Request $request): bool
    {
		    /*note: files are to be stored in the database for now...
		    this could change in the future to include storing files on disk 
		    and remote file storage system */

		    $unique_landlord_id = $request?->unique_landlord_id;

            //Images in laravel will be stored in a storage folder while their pointer path will be stored in a database:
            $queryKeysValues = [
                '$unique_landlord_id' => $unique_landlord_id
            ];       

            //first check if this user has a profile image already:   
            $profile_details = $this?->LandlordReadSpecificService($queryKeysValues);
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
                $profile_image_name_was_deleted = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
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
			    $was_profile_image_updated = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);

                return $was_profile_image_updated;       
	}


    //update each fields without mass assignment: Specific Logic 
	protected function LandlordUpdateEachService(Request $request): bool
	{
		$unique_landlord_id = $request?->unique_landlord_id;

			$request = $request?->except('unique_landlord_id');

			foreach($request as $reqKey => $reqValue)
			{
				$queryKeysValues = [
					'unique_landlord_id' => $unique_landlord_id
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
				$were_landlord_profile_details_updated = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
                if(!$were_landlord_profile_details_updated)
                {
                    throw new Exception("Update not Successful!");
                }
            }
		return true;
	}


    protected function LandlordDeleteProfileService(Request $request): bool
    {
        $unique_landlord_id = $request?->unique_landlord_id;

        $queryKeysValues = [
            'unique_landlord_id' => $unique_landlord_id
        ];

        $newKeysValues = [
            'landlord_first_name' => '',
            'landlord_middle_name' => '',
            'landlord_last_name' => 'string',
            'landlord_phone_number' => '',
            'landlord_username' => '',
        ];
        $were_profile_details_deleted = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
        return $were_profile_details_deleted;
    }


}

?>