//use the fetch API:
const SEND_TOKEN_MAIL_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'guest/send/reset/password/token');
const IMPLEMENT_PASS_RESET_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'guest/reset/password');
const REQUEST_METHOD: string = "PUT";
const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
};

export const send_token_mail_server_sync = async (sendTokenMailParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: sendTokenMailParams,
    }

    const response: Response = await fetch(SEND_TOKEN_MAIL_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const implement_password_reset_server_sync = async (implementPasswordResetParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: implementPasswordResetParams,
    }

    const response: Response = await fetch(IMPLEMENT_PASS_RESET_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to check Data!');
    }
    //else:
    return response.json();
}