'use client'

import React, {useState} from 'react';

//import Views:
import ButtonView from './button-view';
//import service:
import persist_to_storage from '@/app/services/auth/persist-to-storage';

//sample:
const FormView = () => 
{
  //handle click event:
  const handleSubmit = async(event: any) =>
  {
    //stops form from submitting and refreshing the page:
    event.preventDefault();
    //save data to local storage: 
    persist_to_storage('fullName', event.target.fullName.value);
    persist_to_storage('email', event.target.email.value);
    persist_to_storage('phoneNumber', event.target.phoneNumber.value);
    persist_to_storage('password', event.target.phoneNumber.value);
  };

  return (
    <>
      <form
      onSubmit={handleSubmit}
      >
        <div className={"form-group"}>
          <div className={"input-group"}>
            <div className={"input-group-prepend"}>
              <div className={"input-group-text"}>
                <i data-feather={"user"}></i>
              </div>
            </div>
            <input
              name={"fullName"}
              type={"text"}
              className={"form-control"}
              placeholder={"Enter your full name"}
              required={true}
            />
          </div>
        </div>

        <div className={"form-group"}>
          <div className={"input-group"}>
            <div className={"input-group-prepend"}>
              <div className={"input-group-text"}>
                <i data-feather={"mail"}></i>
              </div>
            </div>
            <input
              name={"email"}
              type={"email"}
              className={"form-control"}
              placeholder={"Enter email address"}
              required={true}
            />
          </div>
        </div>

        <div className={"form-group"}>
          <div className={"input-group"}>
            <div className={"input-group-prepend"}>
              <div className={"input-group-text"}>
                <i data-feather={"phone"}></i>
              </div>
            </div>
            <input
              name={"phoneNumber"}
              type={"phone-number"}
              className={"form-control"}
              placeholder={"Enter Phone Number"}
              required={true}
            />
          </div>
        </div>

        <div className={"form-group"}>
          <div className={"input-group"}>
            <div className={"input-group-prepend"}>
              <div className={"input-group-text"}>
                <i data-feather={"lock"}></i>
              </div>
            </div>
            <input
              name={"password"}
              type={"password"}
              id={"pwd-input"}
              className={"form-control"}
              placeholder={"Password"}
              maxLength={15}
              minLength={7}
              required={true}
            />
            <div className={"input-group-apend"}>
              <div className={"input-group-text"}>
                <i id={"pwd-icon"} className={"far fa-eye-slash"}></i>
              </div>
            </div>
          </div>
          <div className={"important-note"}>
            Password should be a minimum of 7 and maximum of 15
            characters and should contains letters and numbers
          </div>
        </div>
        <ButtonView />
      </form>
    </>
  );
};

export default FormView;


