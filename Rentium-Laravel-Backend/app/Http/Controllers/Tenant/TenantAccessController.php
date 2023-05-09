<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Validators\Tenant\TenantAccessRequestRules;
use App\Services\Interfaces\Tenant\TenantAccessInterface;
use App\Services\Traits\ModelAbstraction\Tenant\TenantAccessAbstraction;

use App\Services\Traits\ModelAbstraction\General\Tenant\EmailVerificationNotificationAbstraction;
use App\Services\Traits\ModelAbstraction\General\Tenant\VerifyEmailAbstraction;
use App\Services\Traits\ModelAbstraction\General\Tenant\PasswordResetNotificationAbstraction;
use App\Services\Traits\ModelAbstraction\General\Tenant\NewPasswordAbstraction;

use App\Services\Traits\Utilities\ComputeUniqueIDService;
use App\Services\Traits\Utilities\PassHashVerifyService;



final class TenantAccessController extends Controller implements TenantAccessInterface
{
    use TenantAccessRequestRules;
    use TenantAccessAbstraction;

    use EmailVerificationNotificationAbstraction;
    use VerifyEmailAbstraction;
    use PasswordResetNotificationAbstraction;
    use NewPasswordAbstraction;

    use ComputeUniqueIDService;
    use PassHashVerifyService;    
    
    public function __construct()
    {
        //initialize Tenant Object:
        //public $Tenant = new Tenant;
    }
    

    public function Register(Request $request): JsonResponse 
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
                //throw \Exception:
                throw new \Exception("Invalid Input(s) Provided!");
            }

            //pass the validated value to the Model Abstraction Service: 
            $detail_was_partially_saved = $this?->TenantRegisterService($request);
            if(!$detail_was_partially_saved)
            {
                throw new \Exception("Your detail could not be registered. Please try again!"); 
            }

            //since password can't be saved through mass assignment, so save specific:
            $hashedPass = $this?->CustomHashPassword($request?->tenant_password);

            //unique id can't be saved through mass assignment, so save specific:
            $uniqueID = $this?->genUniqueAlphaNumID();

            $queryKeysValues = [
                'tenant_email' => $request?->tenant_email
            ];

            $newKeysValues = [ 
                'tenant_password' => $hashedPass, 
                'unique_tenant_id' => $uniqueID 
            ];

            $pass_id_were_saved = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);

            if(!$pass_id_were_saved)
            {
                //delete the formerly saved data if password and id are not saved:
                $deleteKeysValues = [
                    'tenant_email' => $request?->tenant_email
                ];
                $partially_saved_data_was_deleted = $this?->TenantDeleteAllNullService($deleteKeysValues);
    
                if($partially_saved_data_was_deleted)
                {
                    //then throw new \Exception:
                    throw new \Exception("Your details could not be registered. Please try again!"); 
                } 
                //else:
                    //leave it to the middleware to Delete All null before each request
            }

            //After all these, send mail for tenant email for verification:
            $verify_token_was_sent = $this?->SendVerificationReqMail($request);
            //if it wasn't successful:
            if(!$verify_token_was_sent)
            {
                //delete all records of this tenant:
                $deleteKeysValues = [
                    'tenant_email' => $request?->tenant_email,
                    'tenant_phone_number' => $request?->tenant_phone_number
                ];
                $tenant_was_deleted = this?->TenantDeleteSpecificService($deleteKeysValues);
                if($tenant_was_deleted)
                {
                    throw new \Exception("Verification Request Mail wasn't sent successfully!");
                }
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'RegisterSuccess!',
                'short_description' => 'E-mail Verification Token was Sent to your email. Please login to Verify!',
                //'verify_token' => $verify_token_was_sent,
            ];
        }
        catch(\Exception $ex)
        {
            //warnings for sql repetititive input(s)s attempts in db
            $duplicationWarning1 = "Integrity constraint violation";
            $duplicationWarning2 = "SQLSTATE[23000]";
            $duplicationWarning3 = '1062 Duplicate entry';

            $status = [
                'code' => 0,
                'serverStatus' => 'RegEntriesNotSaved!',
                'short_description' => $ex?->getMessage()
            ];

            $str_contains_first_warning = str_contains($status['short_description'], $duplicationWarning1);
            $str_contains_second_warning = str_contains($status['short_description'], $duplicationWarning2);
            $str_contains_third_warning = str_contains($status['short_description'], $duplicationWarning3);
            if( 
                $str_contains_first_warning && 
                $str_contains_second_warning && 
                $str_contains_third_warning
            )
            {
                $status['warning'] = 'One of your details - Email, Password or Phone Number have been used! Try Another.';
            }

            return response()?->json($status, 400);
        }
        /*finally
        {*/
            return response()?->json($status, 200);
        /*}*/
    }


    public function LoginDashboard(Request $request): JsonResponse
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
                throw new \Exception("Invalid Input(s) provided!");
            }

            $foundDetail = $this?->TenantAuthenticateService($request);
            if(!$foundDetail)
            {
                throw new \Exception("Failed login attempt. Invalid Email, Phone Number or Password Provided!");
            }

            //now start to prepare to update login status:
            //set query:
            $uniqueToken = $foundDetail->unique_tenant_id;
            $queryKeysValues = [
                'unique_tenant_id' => $uniqueToken
            ];
            //set the is_logged_in status as true:
            $newKeysValues = [
                'is_logged_in' => true
            ];

            $change_login_status = $this?->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);

            if(!$change_login_status)
            {
                throw new \Exception("Failed to update login status. Please try again!");
            }

            //After logged in state was set, start generating the Bearer token for Authorization Header...

            //Now create the token:
            //This will be automatically handled by Sanctum and stored in database...
            $auth_header_token = $foundDetail->createToken('auth_header_token', ['tenant-crud']);
            $auth_header_token_text = $auth_header_token->plainTextToken;

            //Then, build status:
            $status = [
                'code' => 1,
                'serverStatus' => 'LoginSuccess!',
                //for subsequent calls inside the dashboard:
                'UniqueId' => $foundDetail['unique_tenant_id'],//for Tenant Authentication
                'tenantAuthToken' => $auth_header_token_text, //for Authorization header using Sanctum...
                'decription' => "For subsequent calls to the dashboard endpoints, 
                                    tenantUniqueId must be included in the request body while 
                                    tenantAuthToken must be included in the Authorization header as a Bearer Token"
            ];
        }
        catch(\Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'LoginFailure!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        //}
    }
    
    //To verify, the user logs into the dashboard:
    public function VerifyAccount(Request $request): JsonResponse
    {
        $status = array();

        //get rules from validator class:
        $reqRules = $this?->verifyAccountRules();

        //validate here:
        $validator = Validator::make($request?->all(), $reqRules);

        if($validator?->fails())
        {
            throw new \Exception("Access denied! Not a logged in user!");
        }
        try
        {
            $confirm_verify_state = $this?->TenantConfirmVerifiedStateService($request);

            if(!$confirm_verify_state)
            {
                $verify_state_was_changed = $this?->TenantChangeVerifiedStateService($request);
                if(!$verify_state_was_changed)
                {
                    throw new \Exception("Tenant Email was not verified!");
                }
    
                $status = [
                    'code' => 1,
                    'serverStatus' => 'VerifiedSuccess!',
                    'short_description' => 'Verification Performed Successfully!'
                ];
            }
            else
            {
                 //redirect to home page:
                 $status = [
                    'code' => 1,
                    'serverStatus' => 'VerifiedAlready!',
                    'short_description' => 'Take No Action!'
                ];
            }

        }
        catch(\Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'VerifiedFailure!',
                'short_description' => $ex?->getMessage(),
            ];

            return response()?->json($status, 400);
        }
        /*finally
        {*/
            return response()?->json($status, 200);
        //}
    }


    //For Guests(Logged out users):
    public function SendPassordResetToken(Request $request): JsonResponse
    {
        $status = array();
        try
        {
            //get rules from validator class:
            $reqRules = $this?->sendPassordResetTokenRules();
 
            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);
  
            if($validator?->fails())
            {
                throw new \Exception("Invalid Input provided!");
            }
            //send the token:
            $pass_reset_token_was_sent = $this?->TenantSendPasswordResetMailService($request);
 
            if(!$pass_reset_token_was_sent)
            {
                //throw \Exception:
                throw new \Exception("Password Reset Token was not sent!");
            }
            $status = [
                'code' => 1,
                'serverStatus' => 'PassResetTokenWasSent!',
                /*these are for the next requests...for the screen of the actual reset password
                which will include the new password and the pass reset token*/
                'unique_tenant_id' => $pass_reset_token_was_sent,
                'tenant_email' => $request->tenant_email,
            ];
        }
        catch(\Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PassResetTokenNotSent!',
                'short_description' => $ex?->getMessage(),
            ];

            return response()?->json($status, 400);
        }
        /*finally
        {*/
            //return response:
            return response()?->json($status, 200);
        //}
    }
     
    //This brings the screen for change password with the new intented password and the token: 
     public function ImplementResetPassword(Request $request): JsonResponse
     {
         $status = array();
 
        try
        {       
            //get rules from validator class:
            $reqRules = $this?->implementResetPasswordRules();
 
            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);
 
            if($validator?->fails())
            {
                throw new \Exception("Invalid Input Provided!");
             }
 
             $password_was_updated = $this?->TenantImplementResetPasswordService($request);
 
             if(!$password_was_updated)
             {
                 throw new \Exception("Password could not be changed!");
             }
 
             $status = [
                'code' => 1,
                'serverStatus' => 'PassResetSuccess!',
             ];
 
         }
         catch(\Exception $ex)
         {
             $status = [
                 'code' => 0,
                 'serverStatus' => 'PassResetFailure!',
                 'short_description' => $ex?->getMessage()
             ];
         }
         /*finally
         {*/
             return response()?->json($status, 200);
         //}
     }    
    

    public function Logout(Request $request):  JsonResponse
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
                throw new \Exception("Access denied, not logged in!");
            }

            $log_out_was_updated = $this?->TenantLogoutService($request);
            if(!$log_out_was_updated/*false*/)
            {
                throw new \Exception("Not logged out yet!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'LoggedOut!',
            ];
        }
        catch(\Exception $ex)
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
