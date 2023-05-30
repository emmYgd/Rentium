import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const FETCH_ALL_WITHDRAWAL_REQUESTS_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'utils/dashboard/payments/view/all/withdrawal/requests/summary');
const FETCH_EACH_WITHDRAWAL_REQUESTS_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'utils/dashboard/payments/view/each/withdrawal/request');

const REQUEST_METHOD: string = "GET";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


export const fetch_all_withdrawal_requests_server_sync = async (fetchAllWithdrawalRequestsParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchAllWithdrawalRequestsParams,
    }

    const response: Response = await fetch(FETCH_ALL_WITHDRAWAL_REQUESTS_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const fetch_specific_withdrawal_request_server_sync = async (fetchSpecificWithdrawalRequestParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchSpecificWithdrawalRequestParams,
    }

    const response: Response = await fetch(FETCH_EACH_WITHDRAWAL_REQUESTS_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}