//use the fetch API:
const REGISTER_API_URL: URL = new URL( (process.env.ADMIN_BASE_API_URL  as string) + 'register');
const REQUEST_METHOD: string = "POST";
const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
};

const register_server_sync = async (registerParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: JSON.stringify(registerParams),
    }

    const response: Response = await fetch(REGISTER_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default register_server_sync;