<?php

namespace App\Services\Traits\ModelAbstraction\Property;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Services\Traits\ModelCRUD\Property\PropertyCRUD;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

trait LandlordHouseUploadDetailsAbstraction 
{
	use PropertyCRUD;
	use ComputeUniqueIDService;

	protected function LandlordSavePropertyDetailsService(Request $request): array
	{
		//get all requests:
		//$to_persist_array = $request?->except('unique_lanlord_id');
        $to_persist_array = $request?->all();

		//add property unique id to array:
		$to_persist_array['unique_property_id'] = $this?->genUniqueAlphaNumID();

		//save all using mass assignment:
		$were_details_saved = $this?->PropertyCreateAllService($to_persist_array);

		return [
			'were_text_details_saved' => $were_details_saved,
			'property_unique_lanlord_id' => $to_persist_array['property_unique_lanlord_id']
		];
	}


	protected function LandlordSaveHouseImageService(Request $request): bool
	{
		/*note: files are to be stored in the database for now...
		this could change in the future to include storing files on disk 
		and remote file storage system */

			//query and new Keys and values:
			$queryKeysValues = [
                'unique_lanlord_id' => $request?->unique_landlord_id,
                'unique_property_id' => $request?->unique_property_id
            ];
			//this is the image file uploads:
			$newImageKeysValues = $request?->except([
                'unique_lanlord_id', 
                'unique_property_id'
            ]);

			//Images in laravel will be stored in a storage folder while their pointer path will be stored in a database:

			//first store these images in a storage location on server:
			//probably stored in: ../storage/app/public/uploads first
			/*$main_image_1_rep = $request?->file('main_image_1')?->store('uploads');
			$main_image_2_rep = $request?->file('main_image_2')?->store('uploads');
			$logo_1_rep = $request?->file('logo_1')?->store('uploads');
			$logo_2_rep = $request?->file('logo_2')?->store('uploads');*/

            //loop through the array:
            /*foreach($newImageKeysValues as $imageKey => $imageValue)
            {*/
                
            //init:
            $newImageLinkKeysValues = array();
            for($i=0; $i<=count($newImageKeysValues);)
            {
                $house_image_rep = $request?->file($newImageKeysValues[$i])?->store('uploads');

			    //Now store their respective link representation in the database:
			    $newImageLinkKeysValues += [
				    $newImageLinkKeysValues[$i] => $house_image_rep,
			    ];
                $i++;
			}
			$were_property_images_updated = $this?->PropertyUpdateSpecificService($queryKeysValues, $newImageLinkKeysValues);

		return $were_property_images_updated;
	}


	protected function LandlordSaveHouseClipService(Request $request): bool
	{
		$queryKeysValues = [
			'unique_landlord_id' => $request?->unique_landlord_id,
			'unique_property_id' => $request?->unique_property_id,
		];

		//Now, save the file on storage first:
		$house_clip_rep = $request?->file('property_clip')?->store('uploads');
		//then save its link rep on the db:
		$newKeysValues = [
			'property_clip' => $house_clip_rep,
		];

		//Now call the CRUD:
		$was_clip_updated = $this?->PropertyUpdateSpecificService($queryKeysValues, $newKeysValues);
		
		return $was_clip_updated;
	}
	
}

?>