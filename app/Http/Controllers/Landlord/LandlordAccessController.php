<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Validators\Landlord\LandlordAccessRequestRules;

use App\Services\Interfaces\Landlord\LandlordAccessInterface;
use App\Services\Traits\ModelAbstraction\Landlord\LandlordAccessAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;
use App\Services\Traits\Utilities\PassHashVerifyService;


final class LandlordAccessController extends Controller implements LandlordAccessInterface
{
    use LandlordAccessRequestRules;
    use LandlordAccessAbstraction;
    use ComputeUniqueIDService;
    use PassHashVerifyService;
    

    public function __construct()
    {
        //initialize Landlord Object:
        //public $Landlord = new Landlord;
    }
    

    private function Register(Request $request): JsonResponse 
    {
        $status = array();
        try
        {
            //get rules from validator class:
            $reqRules = $this?->registerRules();

            //first validate the requests:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                //throw Exception:
                throw new Exception("Invalid Input provided!");
            }

            //pass the validated value to the Model Abstraction Service: 
            $is_details_saved = $this?->LandlordRegisterService($request);

            if(!$is_details_saved)
            {
                //delete the formerlly saved data:
                /*$deleteKeysValues = ['buyer_email' => $request?->buyer_email];
                $this?->LandlordDeleteSpecificService($deleteKeysValues);*/

                throw new Exception("Your details could not be registered. Please try again!"); 
            }

            //since password can't be saved through mass assignment, so save specific:
            $hashedPass = $this?->TransformPassService($request?->buyer_password);
            //$this?->HashPassword($request?->password);

            //unique id can't be saved through mass assignment, so save specific:
            $uniqueID = $this?->genUniqueAlphaNumID();

            $queryKeysValues = [
                'buyer_email' => $request?->buyer_email
            ];

            $newKeysValues = [ 
                'buyer_password' => $hashedPass, 
                'unique_buyer_id' => $uniqueID 
            ];

            $pass_id_were_saved = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);

            if(!$pass_id_were_saved)
            {
                //delete the formerlly saved data:
                $deleteKeysValues = [
                    'buyer_email' => $request?->buyer_email
                ];
                $this?->LandlordDeleteSpecificService($deleteKeysValues);

                //then, throw exception: 
                throw new Exception("Your details could not be registered. Please try again!"); 
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'RegEntriesSaved!',
            ];
        }
        catch(Exception $ex)
        {
            //warnings for sql repetititive inputs attempts in db
            $duplicationWarning1 = "Integrity constraint violation";
            $duplicationWarning2 = "SQLSTATE[23000]";
            $duplicationWarning = '1062 Duplicate entry';

            $status = [
                'code' => 0,
                'serverStatus' => 'RegEntriesNotSaved!',
                'short_description' => $ex?->getMessage()
            ];

            $str_contains_first_warning = str_contains($status['short_description'], $duplicationWarning1);
            $str_contains_second_warning = str_contains($status['short_description'], $duplicationWarning2);
            $str_contains_third_warning = str_contains($status['short_description'], $duplicationWarning3);
            if( 
                $str_contains_first_warning || $str_contains_second_warning || $str_contains_third_warning
            )
            {
                $status['warning'] = 'Either Your Email, Password or Phone Number have been used! Try Another.';
            }

            return response()?->json($status, 400);
        }
        /*finally
        {*/
            return response()?->json($status, 200);
        /*}*/
    }


    private function LoginDashboard(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->loginDashboardRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input provided!");
            }

            $detailsFound = $this?->LandlordDetailsFoundService($request);
            if(!$detailsFound)
            {
                throw new Exception("Failed login attempt. Invalid Email Provided!");
            }

            //verify password against the hashed password in the database:
            //$is_pass_verified = password_verify($request?->buyer_password, $detailsFound['buyer_password']);

            $hashedReqPass = $this?->TransformPassService($request?->buyer_password);
            $hashedStoredPass = $detailsFound['buyer_password'];
                
            if($hashedReqPass !== $hashedStoredPass)
            {
                throw new Exception("Failed login attempt. Invalid Password Provided!");
            }

            //now start to prepare to update login status:
            //set query:
            $uniqueToken = $detailsFound['unique_buyer_id'];
            $queryKeysValues = ['unique_buyer_id' => $uniqueToken];
            //set the is_logged_in status as true:
            $newKeysValues = ['is_logged_in' => true];

            $change_login_status = $this?->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);

            if(!$change_login_status)
            {
                throw new Exception("Failed login attempt. Please try again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'Found!',
                'uniqueToken' => $uniqueToken
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'NotFound!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        //}
    }


    private function ConfirmLoginState(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->confirmLoginStateRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input provided!");
            }

            $has_logged_in = $this?->LandlordConfirmLoginStateService($request);
            if(!$has_logged_in)
            {
                throw new Exception("Not logged in yet!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'LoggedIn!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'NotLoggedIn!',
                'short_description' => $ex?->getMessage(),
            ];

            return response()?->json($status, 400);
        }
        /*finally
        {}*/
        return response()?->json($status, 200);
    }
    

    private function ForgotPassword(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->forgotPasswordRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input provided!");
            }

            $has_updated = $this?->LandlordUpdatePasswordService($request);

            if(!$has_updated)
            {
                throw new Exception("Password could not be changed");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'passUpdated',
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'updateFailed',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{*/
            return response()?->json($status, 200);
        //}
    }
    

    private function Logout(Request $request):  JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->logoutRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Access denied, not logged in!");
            }

            $has_logged_out = $this?->LandlordLogoutService($request);
            if(!$has_logged_out/*false*/)
            {
                throw new Exception("Not logged out yet!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'LoggedOut!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'NotLoggedOut!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }//finally{
            return response()?->json($status, 200);
        //}
    }
    
}

?>
