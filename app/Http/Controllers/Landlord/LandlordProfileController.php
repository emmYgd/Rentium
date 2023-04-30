<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Landlord\LandlordProfileInterface;
use App\Http\Validators\Landlord\LandlordProfileRequestRules;
use App\Services\Traits\ModelAbstraction\Property\LandlordProfileAbstraction;

final class LandlordProfileController extends Controller implements LandlordProfileInterface
{
    use LandlordProfileRequestRules;
    use LandlordProfileAbstraction;
    

    public function __construct()
    {
        //initialize Landlord Object:
        //private $Landlord = new Landlord;
    }
    
    //landlords can update their profile images if they so wish
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
            $image_was_saved = $this?->LandlordSaveProfileImageService($request);
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

    //for logged in user:
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
            $details_were_saved = $this?->LandlordUpdateEachService($request);
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
            $details_were_deleted = $this?->LandlordDeleteProfileService($request);
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
    

    //for logged in users, from the dashboard:
        public function ChangePassword(Request $request): JsonResponse
        {
            $status = array();
    
            try
            {       
                //get rules from validator class:
                $reqRules = $this?->changePasswordRules();
    
                //validate here:'new_pass'
                $validator = Validator::make($request?->all(), $reqRules);
    
                if($validator?->fails())
                {
                    throw new Exception("Invalid Input provided!");
                }
    
                $password_was_updated = $this?->LandlordUpdatePasswordService($request);
    
                if(!$password_was_updated)
                {
                    throw new Exception("Password could not be changed!");
                }
    
                $status = [
                    'code' => 1,
                    'serverStatus' => 'PassUpdateSuccess!',
                ];
    
            }
            catch(\Exception $ex)
            {
                $status = [
                    'code' => 0,
                    'serverStatus' => 'PassUpdateFailure!',
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
