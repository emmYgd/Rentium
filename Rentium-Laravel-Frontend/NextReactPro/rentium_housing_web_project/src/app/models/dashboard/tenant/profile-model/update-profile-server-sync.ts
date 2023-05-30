import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

const EDIT_PROFILE_DETAIL_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'utils/dashboard/profile/edit/profile/details');
const EDIT_PROFILE_IMAGE_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'utils/dashboard/profile/edit/profile/image');

const REQUEST_METHOD: string = "PUT";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};

export const edit_profile_detail_sync = async (editProfileDetailParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: editProfileDetailParams,
    }

    const response: Response = await fetch(EDIT_PROFILE_DETAIL_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const edit_profile_image_server_sync = async (editProfileImageParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: editProfileImageParams,
    }

    const response: Response = await fetch(EDIT_PROFILE_IMAGE_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}
