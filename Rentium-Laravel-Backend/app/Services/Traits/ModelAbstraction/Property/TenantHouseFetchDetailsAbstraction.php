<?php

namespace App\Services\Traits\ModelAbstraction\Property;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

use App\Services\Traits\ModelCRUD\Property\PropertyCRUD;
use App\Services\Traits\Utilities\ComputeUniqueIDService;

use App\Model\Property;
use Illuminate\Support\LazyCollection;

trait TenantHouseFetchDetailsAbstraction 
{
	use PropertyCRUD;

		private function PropertyPluckAndSummarize(LazyCollection $propertyCollection): array
		{
			//From the LazyCollection returned, pluck only the id and the image as summary:
			$listed_properties_summary = $propertyCollection?->pluck('property_image_1_compound', 'unique_property_id')?->all();
	
			//Now loop through each occupied array and get the image link:
			foreach($listed_properties_summary as $key => $value)
			{
				//use each db link rep of the image to get the image on disk:
				$real_image_file_on_disk = base64_encode(Storage::get($value));
				//replace link with real image file:
				$listed_properties_summary[$key] = $real_image_file_on_disk;
			}
			return $listed_properties_summary;
		}


	protected function TenantFetchAllHousingDetailssByCategoryService(Request $request): array
	{
        //get requests search query params:
        $property_location = $request->property_location;
        $property_price_range = $request->property_price_range;
        $property_type = $request->property_type;
        $property_landlord_religion_preference = $request->property_landlord_religion_preference;
        
		//init:
		$all_listed_properties_summary = null;

        //respective search or query parameters:
		//Note: all fetched properties must not be hidden:
        $queryKeysValues = [
			'is_hidden' => false,
		];
        
        if( ($property_location !== null) && ($property_location !== "") )
        {
            Arr::add($queryKeysValues, 'property_location', $property_location);
        }
        elseif( ($property_price_range !== null) && ($property_price_range !== "") )
        {
            //json encode it:
            $property_price_range = json_decode($property_price_range);

            $budget_min_price = $property_price_range->budget_min_price;
            $budget_max_price = $property_price_range->budget_max_price;

            //fetch all lazily first:
			$all_listed_properties = $this?->PropertyReadAllLazySpecificService($queryKeysValues);
			//now query based on price range:
			$all_listed_properties_by_price_range = $all_listed_properties?->filter(function(Property $property)
			{
				//returned model must be greater than the minimum price and less than the maximum price: 
				return ( 
					($property->property_price >= $min_price) 
					&& 
					($property->property_price <= $max_price) 
				);
			});
			$all_listed_properties_summary = $this?->PropertyPluckAndSummarize($all_listed_properties_by_price_range); 
		}
        elseif( ($property_type !== null) && ($property_type !== "") )
        {
            Arr::add($queryKeysValues, 'property_type', $property_type);
        }
        elseif( ($property_tenant_religion !== null) && ($property_tenant_religion !== "") )
        {
            Arr::add($queryKeysValues, 'property_tenant_religion', $property_tenant_religion);
        }
        else
        {
			$all_listed_properties = $this?->PropertyReadAllLazySpecificService($queryKeysValues);
			$all_listed_properties_summary = $this->PropertyPluckAndSummarize($all_listed_properties);
        }

		//Now query for conditions:
		$all_listed_properties_by_category = $this?->PropertyReadAllLazySpecificService($queryKeysValues);
		$all_listed_properties_summary = $this->PropertyPluckAndSummarize($all_listed_properties_by_category);

		return $all_listed_properties_summary;
	}


	protected function TenantFetchEachHousingDetailsService(Request $request)
	{
		//init array:
		$queryKeysValues = array();
		
		//collect requests:
		$unique_landlord_id = $request->unique_property_id;
		$unique_property_id = $request->unique_property_id;

		if( ($unique_landlord_id !== null) && ($unique_landlord_id !== "") )
        {
            $queryKeysValues = [
				'unique_property_id' => $unique_property_id,
				'unique_landlord_id' => $unique_landlord_id,
				'is_hidden' => false,
			];
        }
        else
        {
			$queryKeysValues = [
				'unique_property_id' => $unique_property_id,
				'is_hidden' => false,
			];
		}

		$each_property_details = $this?->PropertyReadSpecificService($queryKeysValues);
		if(!$each_property_details)
		{
			throw new Exception("Property Details not found!");
		}
		
		//for images, fetch images whose db link is in the model:
		$each_property_details->property_image_1_environment = base64_encode(Storage::get($each_property_details?->property_image_1_environment));
		if(
			($each_property_details?->property_image_2_environment !== '') || 
			($each_property_details?->property_image_2_environment !== null)  
		)
		{
			$each_property_details->property_image_2_environment = 
			base64_encode(Storage::get($each_property_details?->property_image_2_environment));
		}
			

		//for images, fetch images whose db link is in the model:
		$each_property_details->property_image_1_compound = base64_encode(Storage::get($each_property_details?->property_image_1_environment));
		if(
			($each_property_details?->property_image_2_compound !== '') || 
			($each_property_details?->property_image_2_compound !== null)  
		)
		{
			$each_property_details->property_image_2_compound = 
			base64_encode(Storage::get($each_property_details?->property_image_2_compound));
		}


		//for images, fetch images whose db link is in the model:
		$each_property_details->property_rooms_1 = base64_encode(Storage::get($each_property_details?->property_rooms_1));
		$each_property_details->property_rooms_2 = base64_encode(Storage::get($each_property_details?->property_rooms_2));
		if(
			($each_property_details?->rooms_3 !== '') || 
			($each_property_details?->rooms_3 !== null)  
		)
		{
			$each_property_details->property_rooms_3 = 
			base64_encode(Storage::get($each_property_details?->property_rooms_3));
		}
		if(
			($each_property_details?->rooms_4 !== '') || 
			($each_property_details?->rooms_4 !== null)  
		)
		{
			$each_property_details->property_rooms_4 = 
			base64_encode(Storage::get($each_property_details?->property_rooms_4));
		}


		//for images, fetch images whose db link is in the model:
		$each_property_details->property_convieniences_1 = base64_encode(Storage::get($each_property_details?->property_convieniences_1));
		if(
			($each_property_details?->property_convieniences_2 !== '') || 
			($each_property_details?->property_convieniences_2 !== null)  
		)
		{
			$each_property_details->property_convieniences_2 = 
			base64_encode(Storage::get($each_property_details?->property_convieniences_2));
		}


		//for images, fetch images whose db link is in the model:
		$each_property_details->property_kitchen_1 = base64_encode(Storage::get($each_property_details?->property_kitchen_1));
		if(
			($each_property_details?->property_kitchen_2 !== '') || 
			($each_property_details?->property_kitchen_2 !== null)  
		)
		{
			$each_property_details->property_kitchen_2 = 
			base64_encode(Storage::get($each_property_details?->property_kitchen_2));
		}


		//for images, fetch images whose db link is in the model:
		$each_property_details->property_facility_1 = base64_encode(Storage::get($each_property_details?->property_facility_1));
		$each_property_details->property_facility_2 = base64_encode(Storage::get($each_property_details?->property_facility_2));
		if(
			($each_property_details?->property_facility_3 !== '') || 
			($each_property_details?->property_facility_3 !== null)  
		)
		{
			$each_property_details->property_facility_3 = 
			base64_encode(Storage::get($each_property_details?->property_facility_3));
		}
		if(
			($each_property_details?->property_facility_4 !== '') || 
			($each_property_details?->property_facility_4 !== null)  
		)
		{
			$each_property_details->property_facility_4 = 
			base64_encode(Storage::get($each_property_details?->property_facility_4));
		}
	
		//get the date created because the feature is hidden:
		$each_property_details['property_uploaded_at'] = $each_property_details?->created_at;

		return $each_property_details;
	}

	
}
?>