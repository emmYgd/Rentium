<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Validators\Admin\AdminSocialCommentsAndRatingsRequestRules;
use App\Services\Interfaces\Admin\AdminSocialCommentsAndRatingsInterface;
use App\Services\Traits\ModelAbstraction\Admin\AdminSocialCommentsAndRatingsAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


final class AdminSocialCommentsAndRatingsController extends Controller implements AdminSocialCommentsAndRatingsInterface
{
    use AdminSocialCommentsAndRatingsRequestRules;
    use AdminSocialCommentsAndRatingsAbstraction;
    use ComputeUniqueIDService;

    public function __construct()
    {
        //initialize Admin Object:
        //private $Admin = new Admin;
    }
    

    private function ViewAllUnApprovedCommentsAndRatings(Request $request): JsonResponse
    {
      $status = array();

       try
       {
            //get rules from validator class:
            $reqRules = $this->viewAllUnApprovedCommentsAndRatingsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $allCommentsRatings = $this->AdminViewAllUnApprovedCommentsAndRatingsService($request);

            if( empty($allCommentsRatings) )
            {
                throw new Exception("Could not fetch Comments and Ratings!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'AllComments&RatingsFetched!',
                'comment_ratings' => $allCommentsRatings,
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'Comments&RatingsNotFetched!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
    /*finally
      {*/
        return response()->json($status, 200);
    //}
    }


    private function ViewAllApprovedCommentsRatings(Request $request): JsonResponse
    {
        $status = array();

       try
       {
            //get rules from validator class:
            $reqRules = $this->viewAllApprovedCommentsRatingsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //this should return in chunks or paginate:
            $allCommentsRatings = $this->AdminViewAllApprovedCommentsRatingsService($request);
            if( empty($allCommentsRatings) )
            {
                throw new Exception("Could not fetch Comments and Ratings!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Comments&RatingsFetched!',
                'comment_ratings' => $allCommentsRatings,
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'Comments&RatingsNotFetched!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }/*finally
        {*/
            return response()->json($status, 200);
        //}
    }


    private function ApproveCommentRating(Request $request): JsonResponse
    {
       $status = array();

       try
       {
            //get rules from validator class:
            $reqRules = $this->approveCommentRatingRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            //this should return in chunks or paginate:
            $comment_rating_was_approved  = $this->AdminApproveCommentRatingService($request);
            if(!$comment_rating_was_approved)
            {
                throw new Exception("Could not approve Comments and Ratings!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Comments&RatingsApproved!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'Comments&RatingsNotApproved!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }/*finally
        {*/
            return response()->json($status, 200);
        //}
    }

}