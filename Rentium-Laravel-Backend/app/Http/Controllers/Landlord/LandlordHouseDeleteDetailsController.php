<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Landlord\LandlordHouseDeleteDetailsInterface;
use App\Services\Traits\ModelAbstraction\Property\LandlordHouseDeleteDetailsAbstraction;
use App\Http\Controllers\Validators\Landlord\LandlordHouseDeleteDetailsRequestRules;

final class LandlordHouseDeleteDetailsController extends Controller implements LandlordHouseDeleteDetailsInterface
{
    use LandlordHouseDeleteDetailsRequestRules;
    use LandlordHousedeleteDetailsAbstraction;
    

    public function __construct()
    {

    }


    //tested with get but not with put...
    private function DeleteSpecificHouseDetails(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->deleteSpecificHouseDetailsRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //create without mass assignment:
            $details_were_deleted = $this?->LandlordDeleteSpecificHouseDetailsService($request);
            if(!($details_were_deleted))
            {
                throw new Exception("Property Details not Deleted!");
            }

             $status = [
                'code' => 1,    
                'serverStatus' => 'PropertyDetailsDeleted!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PropertyDetailsNotDeleted!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        /*}*/
    }


    private function DeleteAllPropertyRecords(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->deleteAllPropertyRecordsRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //create without mass assignment:
            $all_propertys_records_were_deleted = $this?->LandlordDeleteAllPropertyRecordsService($request);
            if(!$all_propertys_records_were_deleted/*false*/)
            {
                throw new Exception("Unable to Delete All Property Records!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'AllPropertyRecordsDeleted!',
                'property_id' => $request->unique_property_id
                //'requestLists' => $request?->file('main_image_1')
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'AllPropertyRecordsNotDeleted!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
        return response()?->json($status, 200);
        //}
    }
    
}

    