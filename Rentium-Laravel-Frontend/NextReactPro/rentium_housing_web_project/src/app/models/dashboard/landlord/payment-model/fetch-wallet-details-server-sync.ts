import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const FETCH_WALLET_DETAILS_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + "utils/dashboard/payments/view/wallet/details");

const REQUEST_METHOD: string = "GET";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


const fetch_wallet_details_server_sync = async (fetchWalletDetailsParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchWalletDetailsParams,
    }

    const response: Response = await fetch(FETCH_WALLET_DETAILS_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default fetch_wallet_details_server_sync;