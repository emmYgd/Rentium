<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Landlord\LandlordHouseUploadDetailsInterface;
use App\Services\Traits\ModelAbstraction\Property\LandlordHouseUploadDetailsAbstraction;
use App\Http\Controllers\Validators\Landlord\LandlordHouseUploadDetailsRequestRules;

final class LandlordHouseUploadDetailsController extends Controller implements LandlordHouseUploadDetailsInterface
{
    use LandlordHouseUploadDetailsRequestRules;
    use LandlordHouseUploadDetailsAbstraction;
    
    public function __construct()
    {

    }

    //tested with get but not with put...
    private function UploadHouseTextDetails(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->uploadHouseTextDetailsRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //create without mass assignment:
            $details_were_saved = $this?->LandlordSaveHouseTextDetailsService($request);
            if(!($details_were_saved['were_text_details_saved']))
            {
                throw new Exception("Property Text Details not Saved!");
            }

             $status = [
                'code' => 1,    
                'serverStatus' => 'PropertyTextDetailsSaved!',
                'unique_product_id' => $details_were_saved['unique_product_id']
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PropertyTextDetailsNotSaved!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        /*}*/
    }


     
    private function UploadHouseImageDetails(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->uploadHouseImageDetailsRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //create without mass assignment:
            $property_images_were_saved = $this?->LandlordSaveHouseImageService($request);
            if(!$property_images_were_saved/*false*/)
            {
                throw new Exception("Property Images not Saved!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'PropertyImagesSaved!',
                'property_id' => $request->unique_property_id
                //'requestLists' => $request?->file('main_image_1')
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PropertyImagesNotSaved!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
        return response()?->json($status, 200);
        //}
    }


    private function UploadHouseClip(Request $request):  JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->uploadHouseClipRules();

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
                throw new Exception("Property Clip not Saved!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'PropertyClipSaved!',
                'property_id' => $request->unique_property_id
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PropertyClipNotSaved!',
                'short_description' => $ex?->getMessage()
            ];
            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        //}
    }
    
}

    