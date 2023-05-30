import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const DELETE_PROPERTY_ALL_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'property/delete/all/own/details');
const DELETE_PROPERTY_SPECIFIC_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'property/delete/specific/own/detail');

const REQUEST_METHOD: string = "DELETE";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};

export const delete_property_all_server_sync = async (deletePropertyAllParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: deletePropertyAllParams,
    }

    const response: Response = await fetch(DELETE_PROPERTY_ALL_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const delete_property_specific_server_sync = async (deletePropertySpecificParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: deletePropertySpecificParams,
    }

    const response: Response = await fetch(DELETE_PROPERTY_SPECIFIC_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}
