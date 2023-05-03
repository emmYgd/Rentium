<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\Interfaces\Tenant\TenantToLandlordInteractionsInterface;
use App\Http\Validators\Tenant\TenantToLandlordInteractionsRequestRules;
use App\Services\Traits\ModelAbstraction\Tenant\TenantToLandlordInteractionsAbstraction;
use App\Services\Traits\Utilities\ComputeUniqueIDService;


final class TenantToLandlordInteractionsController extends Controller implements TenantToLandlordInteractionInterface
{
    use TenantToLandlordInteractionsRequestRules;
    use TenantToLandlordInteractionsAbstraction;
    use ComputeUniqueIDService;

    public function __construct()
    {
        //initialize Tenant Object:
        //private $Tenant = new Tenant;
    }
    
    //search either by username, email address, phone-number or tenant_id
	private function SearchForLandlord(Request $request): JsonResponse 
    {
        $status = array();
        try
        {
            //get rules from validator class:
            $reqRules = $this?->searchForLandlordRules();

            //first validate the requests:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                //throw Exception:
                throw new Exception("Invalid Input Provided!");
            }

            //pass the validated value to the Model Abstraction Service: 
            $landlordDetails = $this?->TenantSearchForLandlordService($request);

            if(empty( $landlordDetails ))
            {
                throw new Exception("Landlord not identified. Please try again!"); 
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'LandlordIdentified!',
                'tenantDetails' => $landlordDetails
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'LandlordNotIdentified!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        /*finally
        {*/
            return response()?->json($status, 200);
        /*}*/
    }


    private function SearchForPropertyInvitations(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->searchForPropertyInvitationsRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $invitationsDetails = $this?->TenantSearchForPropertyInvitationsService($request);
            if( empty($invitationsDetails) )
            {
                throw new Exception("No Landlord Property Invitations for  you yet! Try Again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'PropertyInvitationsDetected!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'PropertyInvitationsNotDetected!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        //}
    }


    public function ShowInterestInPropertyInvitations(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->showInterestInPropertyInvitationsRules();

            //validate here:
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $interest_was_shown = $this?->TenantShowInterestInPropertyInvitationsService($request);
            if( !$interest_was_shown /*false*/)
            {
                throw new Exception("No Interest shown in Landlord Property Invitation!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'TenantInterestShown!',
            ];

        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'TenantInterestNotShown!',
                'short_description' => $ex?->getMessage()
            ];

            return response()?->json($status, 400);
        }
        //finally{
            return response()?->json($status, 200);
        //}
    }


    private function MakePropertyRequest(Request $request): JsonResponse
    {
        $status = array();

        try
        {
            //get rules from validator class:
            $reqRules = $this?->makePropertyRequestRules();

            //validate here:'new_pass'
            $validator = Validator::make($request?->all(), $reqRules);

            if($validator?->fails())
            {
                throw new Exception("Invalid Input Provided!");
            }

            $tenant_request_was_made = $this?->TenantMakePropertyRequestService($request);
            if( !$request_was_made /*false*/)
            {
                throw new Exception("No Property Request was made! Try Again!");
            }

            $status = [
                'code' => 1,
                'serverStatus' => 'RequestMade!',
            ];
        }
        catch(Exception $ex)
        {
            $status = [
                'code' => 0,
                'serverStatus' => 'RequestNotMade!',
                'short_description' => $ex?->getMessage(),
            ];

            return response()?->json($status, 400);
        }
        /*finally
        {}*/
        return response()?->json($status, 200);
    }
    
}

?>
