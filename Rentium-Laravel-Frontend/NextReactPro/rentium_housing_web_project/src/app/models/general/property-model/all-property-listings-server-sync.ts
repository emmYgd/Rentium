
//use the fetch API:
const ALL_PROPERTY_LISTINGS_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'searches/dashboard/fetch/all/own/propertys/summary');

const REQUEST_METHOD: string = "GET";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
};

const fetch_all_properties_server_sync = async (fetchAllOwnPropertiesParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchAllOwnPropertiesParams,
    }

    const response: Response = await fetch(ALL_PROPERTY_LISTINGS_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default fetch_all_properties_server_sync;

