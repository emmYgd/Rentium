import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const FETCH_ALL_LANDLORD_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'searches/dashboard/fetch/all/landords/summary');
const FETCH_SPECIFIC_LANDLORD_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'searches/dashboard/fetch/each/landlord/detail');

const REQUEST_METHOD: string = "GET";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


export const fetch_all_landlords_server_sync = async (fetchAllLandlordsParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchAllLandlordsParams,
    }

    const response: Response = await fetch(FETCH_ALL_LANDLORD_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const fetch_specific_landlord_server_sync = async (fetchSpecificLandlordParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchSpecificLandlordParams,
    }

    const response: Response = await fetch(FETCH_SPECIFIC_LANDLORD_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}