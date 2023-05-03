<?php

namespace App\Services\Traits\ModelAbstraction\Property;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Services\Traits\ModelCRUD\Property\PropertyCRUD;

trait LandlordHouseUploadDetailsAbstraction 
{
	use PropertyCRUD;

    protected function LandlordDeleteSpecificHouseDetailsService(Request $request): bool
	{
		$deleteKeysValues = [
            'unique_landlord_id' => $request->unique_landlord_id,
			'unique_property_id' => $request?->unique_property_id,
		];

        //To delete specific details, we have to first delete the associated images and files on Storage:
		$each_property_detail = $this?->PropertyReadSpecificService($deleteKeysValues);
		if(!$each_property_detail)
		{
			throw new Exception("Property Details not found! Ensure you have created this property!");
		}

		//begin to delete the images on server whose db rep links are stored in our Model:
		
		//for images, fetch images whose db link is in the model:
		Storage::delete($each_property_detail?->property_image_1_environment);
		Storage::delete($each_property_detail?->property_image_2_environment);

		Storage::delete($each_property_detail?->property_image_1_compound);
		Storage::delete($each_property_detail?->property_image_2_compound);

        Storage::delete($each_property_detail?->property_rooms_1);
        Storage::delete($each_property_detail?->property_rooms_2);
        Storage::delete($each_property_detail?->property_rooms_3);
        Storage::delete($each_property_detail?->property_rooms_4);

        Storage::delete($each_property_detail?->property_convieniences_1);
        Storage::delete($each_property_detail?->property_convieniences_2);

        Storage::delete($each_property_detail?->property_kitchen_1);
        Storage::delete($each_property_detail?->property_kitchen_2);

        Storage::delete($each_property_detail?->property_facility_1);
        Storage::delete($each_property_detail?->property_facility_2);
        Storage::delete($each_property_detail?->property_facility_3);
        Storage::delete($each_property_detail?->property_facility_4);

        //delete clip:
        Storage::delete($each_property_detail?->property_clip);

        if(false)
        {
            throw new Exception("Storage Files could not be deleted!");
        }

		//having deleted the images on Storage, delete the whole entry inside the database:
		$was_property_deleted = $this?->PropertyDeleteSpecificService($deleteKeysValues);

		return $was_property_deleted;
	}


    protected function LandlordDeleteAllPropertyRecordsService(Request $request): bool
    {
        $queryKeysValues = [
            'unique_landlord_id' => $request->unique_landlord_id,
        ];

        //get all the collections: where this landlord uploaded:
        $all_propertys_records = $this->PropertyReadAllLazySpecificService($queryKeysValues);
        //now as all the record collections are read in-memory,
        //loop through all lazy collections:
        foreach($all_propertys_records->all() as $each_property_detail)
        {
            if(!$each_property_detail)
		    {
			    throw new Exception("Property Details not found! Ensure you have created this property!");
		    }

            //begin to delete the images on server whose db rep links are stored in our Model:
		
		    //for images, fetch images whose db link is in the model:
		    Storage::delete($each_property_detail?->property_image_1_environment);
		    Storage::delete($each_property_detail?->property_image_2_environment);

		    Storage::delete($each_property_detail?->property_image_1_compound);
		    Storage::delete($each_property_detail?->property_image_2_compound);

            Storage::delete($each_property_detail?->property_rooms_1);
            Storage::delete($each_property_detail?->property_rooms_2);
            Storage::delete($each_property_detail?->property_rooms_3);
            Storage::delete($each_property_detail?->property_rooms_4);

            Storage::delete($each_property_detail?->property_convieniences_1);
            Storage::delete($each_property_detail?->property_convieniences_2);

            Storage::delete($each_property_detail?->property_kitchen_1);
            Storage::delete($each_property_detail?->property_kitchen_2);

            Storage::delete($each_property_detail?->property_facility_1);
            Storage::delete($each_property_detail?->property_facility_2);
            Storage::delete($each_property_detail?->property_facility_3);
            Storage::delete($each_property_detail?->property_facility_4);

            //delete clip:
            Storage::delete($each_property_detail?->property_clip);

            if(false)
            {
                throw new Exception("Storage Files could not be deleted!");
            }

            //having deleted all the images on Storage, delete the whole entry inside the database:
            $eachDeleteKeysValues = [
                'unique_landlord_id' => $request->unique_landlord_id,
                'unique_property_id' => $each_property_detail?->unique_property_id,
            ];
		    $was_property_deleted = $this?->PropertyDeleteSpecificService($eachDeleteKeysValues);
            if(!$was_property_deleted)
            {
                throw new Exception("Error in deleting one of the properties! Try Again!");
            }
        }
        return true;
    }

}  
?>