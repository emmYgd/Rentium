<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Http\Validators\Admin\AdminSocialContactRequestRules;

use App\Services\Interfaces\Admin\AdminSocialContactInterface;
use App\Services\Traits\ModelAbstraction\Admin\AdminSocialContactAbstraction;

final class AdminSocialContactController extends Controller implements AdminSocialContactInterface
{
    use AdminSocialContactRequestRules;
    use AdminSocialContactAbstraction;
   

   public function __construct()
   {
      //$this->createAdminDefault();
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
            $message_was_sent = $this->AdminSendLandlordMessageService($request);
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


   private function SendTenantMessage(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->sendTenantMessageRequestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Access Error! Not an Admin!");
            }
            
            //this should return in chunks or paginate:
            $message_was_sent = $this->AdminSendTenantMessageService($request);
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
                throw new Exception("Access Error! Not an Admin!");
            }
            
            //this should return in chunks or paginate:
            $messageDetails = $this->AdminReadAllLandlordMessagesService($request);
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


   private function ReadAllTenantMessages(Request $request): JsonResponse
   {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this->readAllTenantMessagesRequestsRules();

            //validate here:
            $validator = Validator::make($request->all(), $reqRules);

            if($validator->fails())
            {
                throw new Exception("Access Error! Not an Admin!");
            }
            
            //this should return in chunks or paginate:
            $messageDetails = $this->AdminReadAllTenantMessagesService($request);
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