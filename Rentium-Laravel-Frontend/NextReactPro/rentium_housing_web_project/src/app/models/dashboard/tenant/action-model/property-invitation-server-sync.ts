import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const ACKNOWLEDGE_PROPERTY_REQUEST_API_URL: URL = new URL( (process.env.TENANT_BASE_API_URL  as string) + 'actions/dashboard/show/interest/in/property/invitations');

const REQUEST_METHOD_1: string = "PUT";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


const acknowledge_property_invitation = async (acknowledgePropertyInvitationParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD_1,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body:acknowledgePropertyInvitationParams,
    }

    const response: Response = await fetch(ACKNOWLEDGE_PROPERTY_REQUEST_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default acknowledge_property_invitation;