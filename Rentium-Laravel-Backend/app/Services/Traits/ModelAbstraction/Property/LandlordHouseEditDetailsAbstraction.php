<?php

namespace App\Services\Traits\ModelAbstraction\Property;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Services\Traits\ModelCRUD\Property\PropertyCRUD;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

trait LandlordHouseEditDetailsAbstraction 
{
	use PropertyCRUD;
	use ComputeUniqueIDService;

	protected function LandlordEditHouseTextDetailsService(Request $request): array
	{
		//get query params:
        $queryKeysValues = [
            'unique_landlord_id' => $request->unique_landlord_id,
            'unique_property_id' => $request->unique_property_id,
        ];
		$to_persist_array = $request?->except([
            'unique_landlord_id', 
            'unique_property_id'
        ]);

		//edit property record:
		$were_details_edited = $this?->PropertyUpdateSpecificService($queryKeysValues, $to_persist_array);

		return [
			'were_text_details_edited' => $were_details_edited,
			'property_unique_landlord_id' => $to_persist_array['property_unique_landlord_id']
		];
	}


	protected function LandlordSaveHouseImageService(Request $request): bool
	{
		/*note: files are to be stored in the database for now...
		this could change in the future to include storing files on disk 
		and remote file storage system */

		//query and new Keys and values:
		$queryKeysValues = [
            'unique_landlord_id' => $request?->unique_landlord_id,
            'unique_property_id' => $request?->unique_property_id
        ];
            
		//these are the image files to be uploaded:
		$newImageKeysValues = $request?->except([
            'unique_landlord_id', 
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

            //first check if this user has property images already:   
            $property_details = $this?->PropertyReadSpecificService($queryKeysValues);
            //for images, delete images whose db link is in the model:
            Storage::delete($property_details?->property_image_1_environment);
            Storage::delete($property_details?->property_image_2_environment);

            Storage::delete($property_details?->propery_image_1_compound);
            Storage::delete($property_details?->propery_image_2_compound);

            Storage::delete($property_details?->property_rooms_1);
            Storage::delete($property_details?->property_rooms_2);
            Storage::delete($property_details?->property_rooms_3);
            Storage::delete($property_details?->property_rooms_4);

            Storage::delete($property_details?->property_convieniences_1);
            Storage::delete($property_details?->property_convieniences_2);

            Storage::delete($property_details?->property_kitchen_1);
            Storage::delete($property_details?->property_kitchen_2);

            Storage::delete($property_details?->property_facility_1);
            Storage::delete($property_details?->property_facility_2);
            Storage::delete($property_details?->property_facility_3);
            Storage::delete($property_details?->property_facility_4);

            //now, having done that:
            //init:
            $newImageLinkKeysValues = array();
            for($i=0; $i<= count($newImageKeysValues);)
            {
                $house_image_rep = $request?->file($newImageKeysValues[$i])?->store('uploads');

			    //Now store their respective link representation in the database:
			    $newImageLinkKeysValues += [
				    $newImageLinkKeysValues[$i] => $house_image_rep,
			    ];
                $i++;
			}
			$were_property_images_edited = $this?->PropertyUpdateSpecificService($queryKeysValues, $newImageLinkKeysValues);

		return $were_property_images_edited;
	}


	protected function LandlordEditHouseClipService(Request $request): bool
	{
		$queryKeysValues = [
			'unique_landlord_id' => $request?->unique_landlord_id,
			'unique_property_id' => $request?->unique_property_id,
		];

        //first check if this user has property clip already:   
        $property_details = $this?->PropertyReadSpecificService($queryKeysValues);
        //for images, delete images whose db link is in the model:
        Storage::delete($property_details?->property_clip);

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