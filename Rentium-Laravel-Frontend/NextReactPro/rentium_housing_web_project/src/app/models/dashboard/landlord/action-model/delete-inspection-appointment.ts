import fetch_from_storage from '../../../../services/auth/fetch-from-storage';

//use the fetch API:
const DELETE_INSPECTION_APPOINTMENT_SCHEDULE_API_URL: URL = new URL( (process.env.LANDLORD_BASE_API_URL  as string) + 'actions/dashboard/delete/inspection/appointment/schedule');

const REQUEST_METHOD: string = "GET";

const REQUEST_HEADERS: HeadersInit = {
    'Content-Type' : 'application/json',
    'HTTP_Authorization': 'Bearer ' + fetch_from_storage('bearerAuthToken'),
};


const delete_inspection_appointment_schedule_server_sync = async (deleteInspectionAppointmentScheduleParams: BodyInit): Promise<any> => 
{
    const requestInit: RequestInit = {
        method: REQUEST_METHOD,
        cache: "no-cache", //default, no-cache, reload, force-cache, only-if-cached
        headers: REQUEST_HEADERS,
        body: deleteInspectionAppointmentScheduleParams,
    }

    const response: Response = await fetch(DELETE_INSPECTION_APPOINTMENT_SCHEDULE_API_URL, requestInit);

    //first handle cannot connect error:
    if(!response)
    {
        throw new Error('Failed to get Response!');
    }
    //else:
    return response.json();
}

export default delete_inspection_appointment_schedule_server_sync;
