<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Validators\Landlord\LandlordSocialCommentsAndRatingsRequestRules;
use App\Services\Interfaces\Landlord\LandlordSocialCommentsAndRatingsInterface;
use App\Services\Traits\ModelAbstraction\Landlord\LandlordSocialCommentsAndRatingsAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


final class LandlordSocialCommentsAndRatingsController extends Controller implements LandlordSocialCommentsAndRatingsInterface
{
    use LandlordSocialCommentsAndRatingsRequestRules;
    use LandlordSocialCommentsAndRatingsAbstraction;
    use ComputeUniqueIDService;

    public function __construct()
    {
        //initialize Landlord Object:
        //private $Landlord = new Landlord;
    }
    

    private function CommentsAndRatings(Request $request): JsonResponse
    {
      $status = array();

       try
       {
            //get rules from validator class:
            $reqRules = $this->commentsAndRatingsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $landlord_comment_rating_was_saved = $this->LandlordCommentsAndRatingsService($request);

            if(!$landlord_comment_rating_was_saved)
            {
                throw new Exception("Comment & Rating not Saved!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Comments&RatingsSaved!'
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'Comments&RatingsNotSaved!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
    /*finally
      {*/
        return response()->json($status, 200);
    //}
    }


    private function ViewAllTenantsCommentsRatingsAboutSelf(Request $request): JsonResponse
    {
        $status = array();

       try
       {
            //get rules from validator class:
            $reqRules = $this->viewAllTenantsCommentsRatingsAboutSelfRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //this should return in chunks or paginate:
            $allTenantsCommentsRatings = $this->LandlordViewAllTenantsCommentsRatingsAboutSelfService($request);
            if( empty($allTenantsCommentsRatings) )
            {
                throw new Exception("All Tenant's Comments and Ratings about You could not be Found!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Comments&RatingsFound!',
                'comment_ratings' => $allTenantsCommentsRatings,
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'Comments&RatingsNotFound!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }/*finally
        {*/
            return response()->json($status, 200);
        //}
    }


    private function ViewOtherLandlordsCommentsRatingsOnTenant(Request $request): JsonResponse
    {
       $status = array();

       try
       {
            //get rules from validator class:
            $reqRules = $this->viewOtherLandlordsCommentsRatingsOnTenantRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //this should return in chunks or paginate:
            $otherLandlordsCommentsRatings = $this->LandlordViewOtherLandlordsCommentsRatingsOnTenantService($request);
            if( empty($otherLandlordsCommentsRatings) )
            {
                throw new Exception("Other Landlords' Comments and Ratings could not be Found!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Comments&RatingsFound!',
                'comment_ratings' => $otherLandlordsCommentsRatings,
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'Comments&RatingsNotFound!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }/*finally
        {*/
            return response()->json($status, 200);
        //}
    }

}