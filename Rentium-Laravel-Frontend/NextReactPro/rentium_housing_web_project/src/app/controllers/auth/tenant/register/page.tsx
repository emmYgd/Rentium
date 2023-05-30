import React from "react";
import { NextPage } from "next";
//import services and models:
import fetch_from_storage from "@/app/services/auth/fetch-from-storage";
import { register_server_sync as tenant_register_model } from "@/app/models/auth/tenant/register-model/register-server-sync";
import { register_server_sync as landlord_register_model } from "@/app/models/auth/landlord/register-model/register-server-sync";


//imports:
import RegisterView from "@/app/views/components/auth/general/register-view/register-view";

const RegisterPage: NextPage = () => 
{
    let backendModel: any;//: Promise<JSON>;

    //handle all events on the outer layer
    const modelBoundServer = async () => {

        //init params:
        let userData = null;

        {/*continue by retrieving the corresponding information from the localStorage*/ }
        //check if it is the landlord or tenant making the request:
        let userIntent = fetch_from_storage("intent");
        let full_name = fetch_from_storage("fullName");
        let email = fetch_from_storage("email");
        let phone_number = fetch_from_storage("phoneNumber");
        let password = fetch_from_storage("password");

        const intervalId = setInterval(() => {
            //check continuously at intervals:
            if (!userIntent && !full_name && !email && !phone_number && !password) {
                //re-check again:
                //now, to ensure that the local persistence is filled:
                userIntent = fetch_from_storage("intent");
                full_name = fetch_from_storage("fullName");
                email = fetch_from_storage("email");
                phone_number = fetch_from_storage("phoneNumber");
                password = fetch_from_storage("password");
            }
            else {
                clearInterval(intervalId);
            }
        }, 2000);
        //call the interval: to begin excution immediately
        intervalId;

        if (userIntent === "tenant") 
        {
            userData =
            {
                "tenant_full_name": full_name,
                "tenant_email": email,
                "tenant_phone_number": phone_number,
                "tenant_password": password,
            }

            {/*Server-Bound User Model:*/ }
            const serverBoundUserData = JSON.stringify(userData);

            {/*continue by calling the Register API to the backend(either landlord or tenant)*/ }
            backendModel =  tenant_register_model(serverBoundUserData);
        }  

        if (userIntent === "landlord") 
        {
            userData = {
                "landlord_full_name": full_name,
                "landlord_email": email,
                "landlord_phone_number": phone_number,
                "landlord_password": password,
            }

            {/*Server-Bound User Model:*/}
            const serverBoundUserData = JSON.stringify(userData);
            {/*continue by calling the Register API to the backend(either landlord or tenant)*/ }
            backendModel = landlord_register_model(serverBoundUserData);
        }

        
    };

    //call it the first time to submit it to the event loop:
    modelBoundServer();

    return (
        <>
            {/*renders register-page*/}
            <RegisterView backendModel/>

        </>
    );
};

export default RegisterPage;
