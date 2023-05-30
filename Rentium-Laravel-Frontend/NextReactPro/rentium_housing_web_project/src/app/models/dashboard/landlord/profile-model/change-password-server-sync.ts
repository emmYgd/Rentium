import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const AUTH_CHANGE_PASSWORD_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'utils/dashboard/profile/authenticated/change/password');

const REQUEST_METHOD: string = "PUT";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


export const change_password_server_sync = async (changePasswordParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: changePasswordParams,
    }

    const response: Response = await fetch(AUTH_CHANGE_PASSWORD_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}
