import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

const DELETE_PROFILE_DETAIL_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'utils/dashboard/profile/delete/all/profile/details');

const REQUEST_METHOD: string = "DELETE";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};

export const delete_all_profile_detail_server_sync = async (deleteAllProfileDetailParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: deleteAllProfileDetailParams,
    }

    const response: Response = await fetch(DELETE_PROFILE_DETAIL_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}