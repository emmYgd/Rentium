<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Landlord\LandlordHouseFetchDetailsInterface;
use App\Services\Traits\ModelAbstraction\Property\LandlordHouseFetchDetailsAbstraction;
use App\Http\Controllers\Validators\Landlord\LandlordHouseFetchDetailsRequestRules;

final class LandlordHouseFetchDetailsController extends Controller implements LandlordHouseFetchDetailsInterface
{
    use LandlordHouseFetchDetailsRequestRules;
    use LandlordHouseFetchDetailsAbstraction;
    
    public function __construct()
    {

    }
    
    //this fetches all the House ids and 1 image of each property
    private function FetchAllOwnHouseDetailsSummary(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->fetchAllOwnHouseDetailsSummaryRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Access Error, can't connect!");
            }

            $allOwnHouseDetailsSummary = $this?->LandlordFetchAllOwnHouseDetailsSummaryService($request);
            
            if(empty($allOwnHouseDetailsSummary))
            {
                throw new Exception("No properties created so far, create and list new ones!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'FetchSuccess!',
                'productDetails' => $allOwnHouseDetailsSummary
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'FetchError!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }//finally{
            return response()?->json($status, 200);
        //}
    }


    private function FetchEachHousingDetails(Request $request): JsonResponse
    {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this?->fetchEachHousingDetailsRules();

         //validate here:
         $validator = Validator::make($request?->all(), $reqRules);

         if($validator?->fails())
         {
            throw new Exception("Invalid Input Provided!");
         }
         
         $eachHousingDetails = $this?->LandlordFetchEachHousingDetailsService($request);
         if( empty($eachHousingDetails) )
         {
            throw new Exception("Property Details not Found!");
         }

        $status = [
            'code' => 1,
            'serverStatus' => 'FetchSuccess!',
            'productDetails' => $eachHousingDetails
        ];
      }
      catch(Exception $ex)
      {
        $status = [
            'code' => 0,
            'serverStatus' => 'FetchError!',
            'short_description' => $ex?->getMessage()
        ];

        return response()?->json($status, 400);
      }
      /*finally
      {*/
        return response()?->json($status, 200);
      //}
    }

    
    private function  DeleteEachHousingDetails(Request $request): JsonResponse
    {
      $status = array();

      try
      {
         //get rules from validator class:
         $reqRules = $this?->deleteEachProductDetailsRules();

         //validate here:
         $validator = Validator::make($request?->all(), $reqRules);

         if($validator?->fails())
         {
            throw new Exception("Invalid Product ID provided!");
         }
         
         //this should return in chunks or paginate:
         $productHasDeleted = $this?->LandlordDeleteEachProductDetailsService($request);
         if(!$productHasDeleted)
         {
            throw new Exception("Product not yet deleted, please try again!.");
         }

         $status = [
            'code' => 1,
            'serverStatus' => 'DeleteSuccess!',
         ];

      }
      catch(Exception $ex)
      {

         $status = [
            'code' => 0,
            'serverStatus' => 'DeleteError!',
            'short_description' => $ex?->getMessage()
         ];

      }
      /*finally
      {*/
         return response()?->json($status, 200);
      //}
   }

}

?>
