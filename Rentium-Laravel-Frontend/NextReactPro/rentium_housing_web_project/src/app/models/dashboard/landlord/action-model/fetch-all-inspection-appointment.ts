import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const FETCH_ALL_INSPECTION_APPOINTMENT_SCHEDULES_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'actions/dashboard/view/all/inspection/appointment/schedules');

const REQUEST_METHOD: string = "GET";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


const fetch_all_inspection_appointment_schedules_server_sync = async (fetchAllInspectionAppointmentSchedulesParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: fetchAllInspectionAppointmentSchedulesParams,
    }

    const response: Response = await fetch(FETCH_ALL_INSPECTION_APPOINTMENT_SCHEDULES_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default fetch_all_inspection_appointment_schedules_server_sync;
