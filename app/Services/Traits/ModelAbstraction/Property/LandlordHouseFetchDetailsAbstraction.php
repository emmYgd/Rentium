<?php

namespace App\Services\Traits\ModelAbstraction\Property;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Services\Traits\ModelCRUD\Property\PropertyCRUD;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

trait LandlordHouseFetchDetailsAbstraction 
{
	use PropertyCRUD;

	protected function LandlordFetchAllOwnHouseDetailsSummaryService(Request $request): array
	{
        //this gets all property_ids with their 
        //query with this landlord's id:
        $queryKeysValues1 = [
            'unique_landlord_id' => $request?->unique_property_id,
			'is_occupied' => 'true',
        ];

		$queryKeysValues2 = [
            'unique_landlord_id' => $request?->unique_property_id,
			'is_occupied' => 'false',
        ];

		//Now query:
		$all_own_occupied_properties_details = $this?->PropertyReadAllLazySpecificService($queryKeysValues1);
		$all_own_unoccupied_properties_details = $this?->PropertyReadAllLazySpecificService($queryKeysValues2);
		
		//From the LazyCollection returned, pluck only the id and the image as summary:
		$all_own_occupied_property_ids_and_compound_image = $all_own_occupied_properties_details?->pluck('property_image_1_compound', 'unique_property_id')?->all();
		$all_own_unoccupied_property_ids_and_compound_image = $all_own_unoccupied_properties_details?->pluck('property_image_1_compound', 'unique_property_id')?->all();

        //Now loop through each occupied array and get the image link:
		foreach($all_own_occupied_property_ids_and_compound_image as $key => $value)
		{
			//use each db link rep of the image to get the image on disk:
			$real_image_file_on_disk = base64_encode(Storage::get($value));
			//replace link with real image file:
			$all_own_occupied_property_ids_and_compound_image[$key] = $real_image_file_on_disk;
		}

        //Now loop through each unoccupied array and get the image link:
		foreach($all_own_unoccupied_property_ids_and_compound_image as $key => $value)
		{
			//use each db link rep of the image to get the image on disk:
			$real_image_file_on_disk = base64_encode(Storage::get($value));
			//replace link with real image file:
			$all_own_unoccupied_property_ids_and_compound_image[$key] = $real_image_file_on_disk;
		}

		return [
			'occupied' => $all_own_occupied_property_ids_and_compound_image,
			'unoccupied' => $all_own_unoccupied_property_ids_and_compound_image
		];
	}


	protected function LandlordFetchEachHousingDetailsService(Request $request)
	{
		$queryKeysValues = [
			'unique_property_id' => $request?->unique_property_id,
		];

		$each_property_detail = $this?->PropertyReadSpecificService($queryKeysValues);
		if(!$each_property_detail)
		{
			throw new Exception("Property Details not found! Ensure you have created this property as appropriate.");
		}
		
		//for images, fetch images whose db link is in the model:
		$each_property_detail->property_image_1_environment = base64_encode(Storage::get($each_property_detail?->property_image_1_environment));
		if(
			($each_property_detail?->property_image_2_environment !== '') || 
			($each_property_detail?->property_image_2_environment !== null)  
		)
		{
			$each_property_detail->property_image_2_environment = 
			base64_encode(Storage::get($each_property_detail?->property_image_2_environment));
		}
			

		//for images, fetch images whose db link is in the model:
		$each_property_detail->property_image_1_compound = base64_encode(Storage::get($each_property_detail?->property_image_1_environment));
		if(
			($each_property_detail?->property_image_2_compound !== '') || 
			($each_property_detail?->property_image_2_compound !== null)  
		)
		{
			$each_property_detail->property_image_2_compound = 
			base64_encode(Storage::get($each_property_detail?->property_image_2_compound));
		}


		//for images, fetch images whose db link is in the model:
		$each_property_detail->property_rooms_1 = base64_encode(Storage::get($each_property_detail?->property_rooms_1));
		$each_property_detail->property_rooms_2 = base64_encode(Storage::get($each_property_detail?->property_rooms_2));
		if(
			($each_property_detail?->rooms_3 !== '') || 
			($each_property_detail?->rooms_3 !== null)  
		)
		{
			$each_property_detail->property_rooms_3 = 
			base64_encode(Storage::get($each_property_detail?->property_rooms_3));
		}
		if(
			($each_property_detail?->rooms_4 !== '') || 
			($each_property_detail?->rooms_4 !== null)  
		)
		{
			$each_property_detail->property_rooms_4 = 
			base64_encode(Storage::get($each_property_detail?->property_rooms_4));
		}


		//for images, fetch images whose db link is in the model:
		$each_property_detail->property_convieniences_1 = base64_encode(Storage::get($each_property_detail?->property_convieniences_1));
		if(
			($each_property_detail?->property_convieniences_2 !== '') || 
			($each_property_detail?->property_convieniences_2 !== null)  
		)
		{
			$each_property_detail->property_convieniences_2 = 
			base64_encode(Storage::get($each_property_detail?->property_convieniences_2));
		}


		//for images, fetch images whose db link is in the model:
		$each_property_detail->property_kitchen_1 = base64_encode(Storage::get($each_property_detail?->property_kitchen_1));
		if(
			($each_property_detail?->property_kitchen_2 !== '') || 
			($each_property_detail?->property_kitchen_2 !== null)  
		)
		{
			$each_property_detail->property_kitchen_2 = 
			base64_encode(Storage::get($each_property_detail?->property_kitchen_2));
		}


		//for images, fetch images whose db link is in the model:
		$each_property_detail->property_facility_1 = base64_encode(Storage::get($each_property_detail?->property_facility_1));
		$each_property_detail->property_facility_2 = base64_encode(Storage::get($each_property_detail?->property_facility_2));
		if(
			($each_property_detail?->property_facility_3 !== '') || 
			($each_property_detail?->property_facility_3 !== null)  
		)
		{
			$each_property_detail->property_facility_3 = 
			base64_encode(Storage::get($each_property_detail?->property_facility_3));
		}
		if(
			($each_property_detail?->property_facility_4 !== '') || 
			($each_property_detail?->property_facility_4 !== null)  
		)
		{
			$each_property_detail->property_facility_4 = 
			base64_encode(Storage::get($each_property_detail?->property_facility_4));
		}
	
		//get the date created because the feature is hidden:
		$each_property_detail['property_uploaded_at'] = $each_property_detail?->created_at;

		return $each_property_detail;
	}
}
?>