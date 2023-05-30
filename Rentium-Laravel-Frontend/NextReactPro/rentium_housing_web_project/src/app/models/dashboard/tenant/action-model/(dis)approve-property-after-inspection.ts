import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const APPROVE_DISAPPROVE_PROPERTY_AFTER_INSPECTION_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'actions/dashboard/approve/disapprove/property/after/inspection');

const REQUEST_METHOD_1: string = "PUT";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


const approve_disapprove_property_after_inspection = async (approveDisapprovePropertyAfterInspectionParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_1,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: approveDisapprovePropertyAfterInspectionParams,
    }

    const response: Response = await fetch(APPROVE_DISAPPROVE_PROPERTY_AFTER_INSPECTION_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default approve_disapprove_property_after_inspection;