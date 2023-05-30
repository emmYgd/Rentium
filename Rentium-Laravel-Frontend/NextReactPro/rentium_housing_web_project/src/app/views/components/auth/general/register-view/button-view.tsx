import React from 'react';
import persist_to_storage from '@/app/services/auth/persist-to-storage';

//sample:
const ButtonView = () => 
{
    //handle tenant and landlord button events:
    const handleTenantClick = async (event: any) => 
    {
        //save this tenant intent to the local storage: 
        persist_to_storage('intent', 'tenant');
    }

    const handleLandlordClick = async (event: any) => 
    {
        //save this landlord intent to the local storage: 
        persist_to_storage('intent', 'landlord');
    }
    return(
        <div>
            <button 
                onClick={handleTenantClick}
                type={"submit"} 
                className={"btn btn-gradient btn-pill color-2 me-sm-3 me-2"}
            >
                Register As Tenant
            </button>
            <br/><br/>
            <button 
                onClick={handleLandlordClick}
                type={"submit"} 
                className={"btn btn-gradient btn-pill color-2 me-sm-3 me-2"}
            >
                Register As Landlord
            </button>
        </div>
    );
};
export default ButtonView;