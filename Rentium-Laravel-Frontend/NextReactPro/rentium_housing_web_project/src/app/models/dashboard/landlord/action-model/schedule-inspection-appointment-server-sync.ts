import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const SCHEDULE_INSPECTION_APPOINTMENT_FOR_LANLORD_INVITATION_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'actions/dashboard/schedule/inspection/appointment/for/landlord/invitation');
const SCHEDULE_INSPECTION_APPOINTMENT_FOR_TENANT_REQUEST_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'actions/dashboard/schedule/inspection/appointment/for/tenant/request');

const REQUEST_METHOD: string = "POST";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


export const schedule_inspection_appointment_for_landlord_invitation_server_sync = async (scheduleInspectionAppointmentParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: scheduleInspectionAppointmentParams,
    }

    const response: Response = await fetch(SCHEDULE_INSPECTION_APPOINTMENT_FOR_LANLORD_INVITATION_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}


export const schedule_inspection_appointment_for_tenant_request_server_sync = async (scheduleInspectionAppointmentParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: scheduleInspectionAppointmentParams,
    }

    const response: Response = await fetch(SCHEDULE_INSPECTION_APPOINTMENT_FOR_TENANT_REQUEST_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}