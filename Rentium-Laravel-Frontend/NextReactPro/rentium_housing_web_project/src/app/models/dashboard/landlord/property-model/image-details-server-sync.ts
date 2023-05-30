import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const SUBMIT_PROPERTY_IMAGES_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'uploads/dashboard/property/upload/image/details');
const EDIT_PROPERTY_IMAGES_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'uploads/dashboard/property/edit/image/details');

const REQUEST_METHOD_1: string = "POST";
const REQUEST_METHOD_2: string = "PATCH";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};

export const submit_property_images_server_sync = async (submitPropertyImagesParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_1,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: submitPropertyImagesParams,
    }

    const response: Response = await fetch(SUBMIT_PROPERTY_IMAGES_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const edit_property_images_server_sync = async (editPropertyImagesParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_2,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: editPropertyImagesParams,
    }

    const response: Response = await fetch(EDIT_PROPERTY_IMAGES_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}
