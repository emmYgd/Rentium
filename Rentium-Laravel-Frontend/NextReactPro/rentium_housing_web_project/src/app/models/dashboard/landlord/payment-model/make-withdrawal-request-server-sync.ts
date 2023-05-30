import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const MAKE_WITHDRAWAL_REQUEST_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'utils/dashboard/payments/make/withdrawal/request');

const REQUEST_METHOD: string = "POST";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


const make_withdrawal_request_server_sync = async (makeWithdrawalRequestParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: makeWithdrawalRequestParams,
    }

    const response: Response = await fetch(MAKE_WITHDRAWAL_REQUEST_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default make_withdrawal_request_server_sync;