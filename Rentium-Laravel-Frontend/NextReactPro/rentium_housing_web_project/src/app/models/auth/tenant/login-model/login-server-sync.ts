//use the fetch API:
const LOGIN_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'dashboard/login');
const REQUEST_METHOD: string = "PUT";
const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
};

const login_server_sync = async (loginParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: loginParams,
    }

    const response: Response = await fetch(LOGIN_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default login_server_sync;