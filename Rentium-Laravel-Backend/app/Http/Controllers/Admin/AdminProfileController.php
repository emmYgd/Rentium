<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Validators\Admin\AdminProfileRequestRules;

use App\Services\Interfaces\Admin\AdminProfileInterface;
use App\Services\Traits\ModelAbstraction\Admin\AdminProfileAbstraction;


final class AdminProfileController extends Controller implements AdminProfileInterface
{
    use AdminProfileRequestRules;
    use AdminProfileAbstraction;
    

    public function __construct()
    {
        //initialize Admin Object:
        //private $Admin = new Admin;
    }
    
    //admins can update their profile images if they so wish
    private function EditImage(Request $request):  JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->editImageRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Image provided!");
            }

            //create without mass assignment:
            $image_was_saved = $this?->AdminSaveProfileImageService($request);
            if(!$image_was_saved/*false*/)
            {
                throw new Exception("Image Details not saved!");
            }

             $status = [
                'code' => 1,
                'serverStatus' => 'ProfileImageSaved',
                //'requestLists' => $request?->all()
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'ProfileImageSaved',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{     
            return response()?->json($status, 200);
        //}*
    }


    private function EditProfile(Request $request): JsonResponse
    {
        $status = array(); 

        try
        {
            //get rules from validator class:
            $reqRules = $this?->editProfileRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input provided!");
            }

            //create without mass assignment:
            $details_were_saved = $this?->AdminUpdateEachService($request);
            if(!$details_were_saved/*false*/)
            {
                throw new Exception("Details not saved!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'ProfileDetailsSaved',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'ProfileDetailsNotSaved',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        //}
    }

    
    //This might include payment details of this user..
    private function DeleteProfile(Request $request): JsonResponse
    {
        $status = array(); 

        try
        {
            //get rules from validator class:
            $reqRules = $this?->deleteProfileRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input provided!");
            }

            //create without mass assignment:
            $details_were_deleted = $this?->AdminDeleteProfileService($request);
            if(!$details_were_deleted/*false*/)
            {
                throw new Exception("Profile not Deleted!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'ProfileDetailsDeleted',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'ProfileDetailsNotDeleted',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        //}
    }
    
}

?>
