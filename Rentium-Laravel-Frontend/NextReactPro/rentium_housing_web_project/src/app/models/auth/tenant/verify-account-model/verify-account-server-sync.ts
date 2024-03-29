import fetch_from_storage from './../../../../services/auth/fetch-from-storage';

//use the fetch API:
const VERIFY_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'verifications/verify');
const REQUEST_METHOD: string = "PUT";
const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};

const verify_account_server_sync = async (verifyAccountParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: verifyAccountParams,
    }

    const response: Response = await fetch(VERIFY_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default verify_account_server_sync;