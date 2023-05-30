import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const MAKE_PROPERTY_REQUEST_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'actions/dashboard/make/property/request');
const DELETE_PROPERTY_REQUEST_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'actions/dashboard/delete/each/property/request');

const REQUEST_METHOD_1: string = "POST";
const REQUEST_METHOD_2: string = "DELETE";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


export const make_property_request_server_sync = async (makePropertyRequestParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_1,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: makePropertyRequestParams,
    }

    const response: Response = await fetch(MAKE_PROPERTY_REQUEST_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const delete_property_request_server_sync = async (deletePropertyRequestParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_2,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: deletePropertyRequestParams,
    }

    const response: Response = await fetch(DELETE_PROPERTY_REQUEST_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}