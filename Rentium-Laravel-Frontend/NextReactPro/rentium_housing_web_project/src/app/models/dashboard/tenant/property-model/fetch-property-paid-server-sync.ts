
//use the fetch API:
const PAID_PROPERTY_DETAILS_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'searches/dashboard/fetch/all/paid/propertys/summary');

const REQUEST_METHOD: string = "GET";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
};


const fetch_paid_properties_server_sync = async (fetchPaidPropertiesParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchPaidPropertiesParams,
    }

    const response: Response = await fetch(PAID_PROPERTY_DETAILS_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default fetch_paid_properties_server_sync;

