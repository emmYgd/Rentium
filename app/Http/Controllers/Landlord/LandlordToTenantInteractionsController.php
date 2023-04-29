<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Landlord\LandlordToTenantInteractionsInterface;
use App\Http\Validators\Landlord\LandlordToTenantInteractionsRequestRules;
use App\Services\Traits\ModelAbstraction\Landlord\LandlordToTenantInteractionsAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


final class LandlordToTenantInteractionsController extends Controller implements LandlordToTenantInteractionsInterface
{
    use LandlordToTenantInteractionsRequestRules;
    use LandlordToTenantInteractionsAbstraction;
    use ComputeUniqueIDService;

    public function __construct()
    {
        //initialize Landlord Object:
        //private $Landlord = new Landlord;
    }
    
    //search either by username, email address, phone-number or tenant_id
	private function SearchForTenant(Request $request): JsonResponse 
    {
        $status = array();
        try
        {
            //get rules from validator class:
            $reqRules = $this?->searchForTenantRules();

            //first validate the requests:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                //throw Exception:
                throw new Exception("Invalid Input Provided!");
            }

            //pass the validated value to the Model Abstraction Service: 
            $tenantDetails = $this?->LandlordSearchForTenantService($request);

            if(empty( $tenantDetails ))
            {
                throw new Exception("Tenant not identified. Please try again!"); 
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'TenantIdentified!',
                'tenantDetails' => $tenantDetails
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'TenantNotIdentified!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        /*finally
        {*/
            return response()?->json($status, 200);
        /*}*/
    }


    private function SendPropertyInvite(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->sendPropertyInviteRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $invite_was_sent = $this?->LandlordSendPropertyInviteService($request);
            if(!$invite_was_sent)
            {
                throw new Exception("Failed to send Property Invitation to Tenant. Try Again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'InvitationSent!',
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'InvitationNotSent!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        //}
    }


    private function ViewTenantPropertyRequests(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->viewTenantPropertyRequestsRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $tenantPropertyRequests = $this?->LandlordViewTenantPropertyRequestsService($request);
            if( empty($tenantPropertyRequests) )
            {
                throw new Exception("No Tenants Interest shown on any of Your listed Properties!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'InterestsFound!',
                'interestLists' => $tenantPropertyRequests
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'InterestsNotFound!',
                'short_description' => $ex?->getMessage(),
            ];

            return response()?->json($status, 400);
        }
        /*finally
        {}*/
        return response()?->json($status, 200);
    }
    

    private function ApproveRejectTenantRequests(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->approveRejectTenantRequestsRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $request_approval_was_updated = $this?->LandlordApproveRejectTenantRequestsService($request);

            if(!$request_approval_was_updated)
            {
                throw new Exception("Tenant's Request Approval Status couldn't be changed!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'ApprovalStatusChanged!',
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'ApprovalStatusNotChanged!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{*/
            return response()?->json($status, 200);
        //}
    }
    
}

?>
