<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Validators\Tenant\TenantSocialCommentsAndRatingsRequestRules;
use App\Services\Interfaces\Tenant\TenantSocialCommentsAndRatingsInterface;
use App\Services\Traits\ModelAbstraction\Tenant\TenantSocialCommentsAndRatingsAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


final class TenantSocialCommentsAndRatingsController extends Controller implements TenantSocialCommentsAndRatingsInterface
{
    use TenantSocialCommentsAndRatingsRequestRules;
    use TenantSocialCommentsAndRatingsAbstraction;
    use ComputeUniqueIDService;

    public function __construct()
    {
        //initialize Tenant Object:
        //private $Tenant = new Tenant;
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

            $tenant_comment_ratings_was_saved = $this->TenantCommentsAndRatingsService($request);

            if(!$tenant_comment_ratings_was_saved)
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


    private function ViewOtherTenantsCommentsRatingsOnLandlord(Request $request): JsonResponse
    {
       $status = array();

       try
       {
            //get rules from validator class:
            $reqRules = $this->viewOtherTenantsCommentsRatingsOnLandlordRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //this should return in chunks or paginate:
            $otherTenantsCommentsRatings = $this->TenantViewOtherTenantsCommentsRatingsOnLandlordService($request);
            if( empty($otherTenantsCommentsRatings) )
            {
                throw new Exception("Other Tenants' Comments and Ratings could not be Found!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Comments&RatingsFound!',
                'comment_ratings' => $otherTenantsCommentsRatings,
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