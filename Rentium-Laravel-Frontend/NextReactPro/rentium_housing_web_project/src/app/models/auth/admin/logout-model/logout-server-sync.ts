import fetch_from_storage from './../../../../services/auth/fetch-from-storage';

//use the fetch API:
const LOGOUT_API_URL: URL = new URL( (process.env.ADMIN_BASE_API_URL  as string) + 'verifications/verify');
const REQUEST_METHOD: string = "POST";
const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};

const logout_server_sync = async (logoutParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: logoutParams,
    }

    const response: Response = await fetch(LOGOUT_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default logout_server_sync;