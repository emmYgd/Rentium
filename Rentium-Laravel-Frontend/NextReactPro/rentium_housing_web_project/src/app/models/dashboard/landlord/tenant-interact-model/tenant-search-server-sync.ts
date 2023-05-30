import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const SEARCH_ALL_TENANTS_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'searches/dashboard/fetch/all/tenants/summary');
const SEARCH_EACH_TENANT_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'searches/dashboard/fetch/each/tenant/detail');

const REQUEST_METHOD: string = "GET";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};

export const search_all_tenants_server_sync = async (searchAllTenantsParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: searchAllTenantsParams,
    }

    const response: Response = await fetch(SEARCH_ALL_TENANTS_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const search_each_tenant_server_sync = async (searchEachTenantParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: searchEachTenantParams,
    }

    const response: Response = await fetch(SEARCH_EACH_TENANT_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}
