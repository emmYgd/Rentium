//use the fetch API:
const SINGLE_OWN_PROPERTY_DETAIL_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'searches/dashboard/fetch/each/own/property/detail');

const REQUEST_METHOD: string = "GET";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
};

export const fetch_single_property_server_sync = async (fetchSingleOwnPropertyParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchSingleOwnPropertyParams,
    }

    const response: Response = await fetch(SINGLE_OWN_PROPERTY_DETAIL_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default fetch_single_property_server_sync;