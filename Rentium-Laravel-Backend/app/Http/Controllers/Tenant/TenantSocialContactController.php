<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Http\Validators\Tenant\TenantSocialContactRequestRules;

use App\Services\Interfaces\Tenant\TenantSocialContactInterface;
use App\Services\Traits\ModelAbstraction\Tenant\TenantSocialContactAbstraction;

final class TenantSocialContactController extends Controller implements TenantSocialContactInterface
{
    use TenantSocialContactRequestRules;
    use TenantSocialContactAbstraction;
   

   public function __construct()
   {
      //$this->createTenantDefault();
   }


   private function SendAdminMessage(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->sendAdminMessageRequestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid  Input Provided!");
            }
            
            //this should return in chunks or paginate:
            $message_was_sent = $this->TenantSendAdminMessageService($request);
            if(!$message_was_sent)
            {
                throw new Exception("Message was not sent successfully! Please try again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'MessageSent!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'MessageNotSent!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
   }


   private function SendLandlordMessage(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->sendLandlordMessageRequestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }
            
            //this should return in chunks or paginate:
            $message_was_sent = $this->TenantSendLandlordMessageService($request);
            if(!$message_was_sent)
            {
                throw new Exception("Message was not sent successfully! Please try again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'MessageSent!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'MessageNotSent!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
   }


   private function ReadAllAdminMessages(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->readAllAdminMessagesRequestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Access Error! Not an Tenant!");
            }
            
            //this should return in chunks or paginate:
            $messageDetails = $this->TenantReadAllAdminMessagesService($request);
            if(empty($messageDetails))
            {
                throw new Exception("Messages could not be fetched! Please try again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'MessagesFetched!',
                'messageDetails' => $messageDetails,
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'MessageNotFetched!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
   }


   private function ReadAllLandlordMessages(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->readAllLandlordMessagesRequestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Access Error! Not an Tenant!");
            }
            
            //this should return in chunks or paginate:
            $messageDetails = $this->TenantReadAllLandlordMessagesService($request);
            if(empty($messageDetails))
            {
                throw new Exception("Messages could not be fetched! Please try again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'MessagesFetched!',
                'messageDetails' => $messageDetails,
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'MessageNotFetched!',
                'short_description' => $ex->getMessage()
            ];

            return response()->json($status, 400);
        }
        /*finally
        {*/
            return response()->json($status, 200);
        //}
   }

}
?>                                         