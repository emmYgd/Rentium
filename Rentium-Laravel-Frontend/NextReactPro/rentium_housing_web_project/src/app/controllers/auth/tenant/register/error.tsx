'use client'

import React from 'react';
import ErrorView from '@/app/views/components/auth/tenant/common-view/error-view';

//import "./../../../libs-templates-assets/assets/images/loader/loader-4.gif"

//sample:
const Error = ({error, reset}: {error: Error; reset:() => void}) => 
{
    return (
        <ErrorView error={error} reset={reset}/>
    );
};

export default Error;