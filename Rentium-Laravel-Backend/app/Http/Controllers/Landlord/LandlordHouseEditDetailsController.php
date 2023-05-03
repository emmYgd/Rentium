<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Landlord\LandlordHouseEditDetailsInterface;
use App\Services\Traits\ModelAbstraction\Property\LandlordHouseEditDetailsAbstraction;
use App\Http\Controllers\Validators\Landlord\LandlordHouseEditDetailsRequestRules;

final class LandlordHouseEditDetailsController extends Controller implements LandlordHouseEditDetailsInterface
{
    use LandlordHouseEditDetailsRequestRules;
    use LandlordHouseEditDetailsAbstraction;
    
    public function __construct()
    {

    }

    //tested with get but not with put...
    private function EditHouseTextDetails(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->editHouseTextDetailsRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //create without mass assignment:
            $details_were_edited = $this?->LandlordEditHouseTextDetailsService($request);
            if(!($details_were_edited['were_text_details_edited']))
            {
                throw new Exception("Property Text Details not Changed!");
            }

            $status = [
                'code' => 1,    
                'serverStatus' => 'PropertyTextDetailsChanged!',
                'unique_product_id' => $details_were_saved['unique_product_id']
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PropertyTextDetailsNotChanged!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        /*}*/
    }


     
    private function EditHouseImageDetails(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->editHouseImageDetailsRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //create without mass assignment:
            $property_images_were_edited = $this?->LandlordEditHouseImageService($request);
            if(!$property_images_were_edited/*false*/)
            {
                throw new Exception("Property Images not Changed!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'PropertyImagesChanged!',
                'property_id' => $request->unique_property_id
                //'requestLists' => $request?->file('main_image_1')
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PropertyImagesNotChanged!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
        return response()?->json($status, 200);
        //}
    }


    private function EditHouseClip(Request $request):  JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->editHouseClipRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input provided!");
            }

            //create without mass assignment:
            $property_clip_was_saved = $this?->LandlordSaveHouseClipService($request);
            if(!$property_clip_was_saved/*false*/)
            {
                throw new Exception("Property Clip not Changed!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'PropertyClipChanged!',
                'property_id' => $request->unique_property_id
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PropertyClipNotChanged!',
                'short_description' => $ex?->getMessage()
            ];
            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        //}
    }
    
}

    