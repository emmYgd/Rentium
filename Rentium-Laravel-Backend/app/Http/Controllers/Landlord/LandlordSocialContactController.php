<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Http\Validators\Landlord\LandlordSocialContactRequestRules;

use App\Services\Interfaces\Landlord\LandlordSocialContactInterface;
use App\Services\Traits\ModelAbstraction\Landlord\LandlordSocialContactAbstraction;

final class LandlordSocialContactController extends Controller implements LandlordSocialContactInterface
{
    use LandlordSocialContactRequestRules;
    use LandlordSocialContactAbstraction;
   

   public function __construct()
   {
      //$this->createLandlordDefault();
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
                throw new Exception("Invalid Input Provided!");
            }
            
            //this should return in chunks or paginate:
            $message_was_sent = $this->LandlordSendAdminMessageService($request);
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
                throw new Exception("Invalid Input Provided!");
            }
            
            //this should return in chunks or paginate:
            $message_was_sent = $this->LandlordSendTenantMessageService($request);
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
                throw new Exception("Access Error! Not an Landlord!");
            }
            
            //this should return in chunks or paginate:
            $messageDetails = $this->LandlordReadAllAdminMessagesService($request);
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
                throw new Exception("Access Error! Not an Landlord!");
            }
            
            //this should return in chunks or paginate:
            $messageDetails = $this->LandlordReadAllTenantMessagesService($request);
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