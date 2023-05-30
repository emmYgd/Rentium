import React from 'react';
import Link from 'next/link'

//import Views:
import FormView from './form-view';

//import services and models:
import fetch_from_storage from "@/app/services/auth/fetch-from-storage";
import {register_server_sync as tenant_register_model}  from "@/app/models/auth/tenant/register-model/register-server-sync";
import {register_server_sync as landlord_register_model} from "@/app/models/auth/landlord/register-model/register-server-sync";

//sample:
const RegisterView = () => 
{
    //handle all events on the outer layer
    const handleSubmit = async (event: any) => 
    {
        {/*continue by retrieving the corresponding information from the localStorage*/}
        //check if it is the landlord or tenant making the request:
        let userIntent = await fetch_from_storage("intent");

        //init userData:
        let userData = null;

        if(userIntent === "tenant")
        {
            userData = {
                "tenant_full_name": await fetch_from_storage("fullName"),
                "tenant_email": await fetch_from_storage("email"),
                "tenant_phone_number": await fetch_from_storage("phoneNumber"),
                "tenant_password": await fetch_from_storage("password"),
            }
        }

        if(userIntent === "landlord")
        {
            userData = {
                "landlord_full_name": await fetch_from_storage("fullName"),
                "landlord_email": await fetch_from_storage("email"),
                "landlord_phone_number": await fetch_from_storage("phoneNumber"),
                "landlord_password": await fetch_from_storage("password"),
            }
        }

        {/*Server-Bound User Model:*/}
        const serverBoundUserData  = JSON.stringify(userData);

        {/*continue by calling the Register API to the backend(either landlord or tenant)*/}
        tenant_register_model(serverBoundUserData);
    };

    return (
        <>
            {/*<-- section starts -->*/}
            <section>
                <div className={"container"}>
                    <div className={"row log-in sign-up"}>
                        <div className={"col-xl-5 col-lg-6 col-md-8 col-sm-10 col-12"}>
                            <div className={"theme-card"}>
                                <div className={"title-3 text-start"}>
                                    <h2>Sign up</h2>
                                </div>

                                {/*Form View here:*/}
                                <FormView />
                                <br />
                                <hr />
                                <br />

                                <p>Already have an account with us?
                                    <Link
                                        href={"login.html"}
                                        className={"btn btn-dashed btn-pill color-2"}
                                    >
                                        Log in
                                    </Link>
                                </p>

                                {/*
                    <div classNameName={"divider"}>
                        <h6>or</h6>
                    </div>


                    <div>
                        <h6>Sign up with</h6>
                        <div classNameName={"row social-connect"}>
                            <div classNameName={"col-6"}>
                                <a href={"https://www.facebook.com/" classNameName={"btn btn-social btn-flat facebook p-0"}>
                                    <i classNameName={"fab fa-facebook-f"}></i>
                                    <span>Facebook</span>
                                </a>
                            </div>

                            <div classNameName={"col-6"}>
                                <a href={"https://account.google.com" classNameName={"btn btn-social btn-flat google p-0"}>
                                    <i classNameName={"fab fa-google"}></i>
                                    <span>Google</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    */}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {/*<!-- section end -->*/}
        </>
    );
};

export default RegisterView;