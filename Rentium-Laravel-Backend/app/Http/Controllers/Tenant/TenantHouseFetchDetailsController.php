<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Tenant\TenantHouseFetchDetailsInterface;
use App\Services\Traits\ModelAbstraction\Property\TenantHouseFetchDetailsAbstraction;
use App\Http\Validators\Tenant\TenantHouseFetchDetailsRequestRules;

final class TenantHouseFetchDetailsController extends Controller implements TenantHouseFetchDetailsInterface
{
    use TenantHouseFetchDetailsRequestRules;
    use TenantHouseFetchDetailsAbstraction;
    
    public function __construct()
    {

    }
    

    //this fetches all the House ids and 1 image of each property
    //query & order by date created, by location, by price,
    public function FetchAllHousingDetailsByCategory(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->fetchAllHousingDetailsByCategoryRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $allHousingDetailsByCategory = $this?->TenantFetchAllHousingDetailsByCategoryService($request);
            
            if(empty($allHousingDetailsByCategory))
            {
                throw new Exception("No Properties listed yet!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'FetchSuccess!',
                'productDetails' => $allHousingDetailsByCategory
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


    public function FetchEachHousingDetails(Request $request): JsonResponse
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
         
         $eachHousingDetails = $this?->TenantFetchEachHousingDetailsService($request);
         if( empty($eachHousingDetails) )
         {
            throw new Exception("Property Details not Found!");
         }

        $status = [
            'code' => 1,
            'serverStatus' => 'FetchSuccess!',
            'productDetails' => $eachHousingDetails,
        ];
      }
      catch(Exception $ex)
      {
        $status = [
            'code' => 0,
            'serverStatus' => 'FetchError!',
            'short_description' => $ex?->getMessage(),
        ];

        return response()?->json($status, 400);
      }
      /*finally
      {*/
        return response()?->json($status, 200);
      //}
    }

}

?>
