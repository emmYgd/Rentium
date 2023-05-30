import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const FETCH_ALL_PROPERTY_REQUESTS_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'searches/dashboard/fetch/all/tenant/property/requests/summary');
const APPROVE_DISAPPROVE_PROPERTY_REQUEST_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'actions/dashboard/reject/or/approve/property/request');

const REQUEST_METHOD_1: string = "GET";
const REQUEST_METHOD_2: string = "PUT";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


export const fetch_all_property_requests_server_sync = async (fetchAllPropertyRequestsParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_1,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchAllPropertyRequestsParams,
    }

    const response: Response = await fetch(FETCH_ALL_PROPERTY_REQUESTS_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}



export const approve_disapprove_property_request_server_sync = async (approveDisapprovePropertyRequestParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_1,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: approveDisapprovePropertyRequestParams,
    }

    const response: Response = await fetch(APPROVE_DISAPPROVE_PROPERTY_REQUEST_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}
