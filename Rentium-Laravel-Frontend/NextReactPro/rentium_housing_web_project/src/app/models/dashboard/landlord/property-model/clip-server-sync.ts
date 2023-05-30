import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const SUBMIT_PROPERTY_CLIP_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'uploads/dashboard/property/upload/clip/details');
const EDIT_PROPERTY_CLIP_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'uploads/dashboard/property/edit/clip/details');

const REQUEST_METHOD_1: string = "POST";
const REQUEST_METHOD_2: string = "PATCH";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};

export const submit_property_clip_server_sync = async (submitPropertyClipParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_1,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: submitPropertyClipParams,
    }

    const response: Response = await fetch(SUBMIT_PROPERTY_CLIP_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const edit_property_clip_server_sync = async (editPropertyClipParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_2,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: editPropertyClipParams,
    }

    const response: Response = await fetch(EDIT_PROPERTY_CLIP_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}
