'use client';

import React from 'react';
import Image from 'next/image';

//import "./../../../libs-templates-assets/assets/images/loader/loader-4.gif"

//sample:
const Loading = () => 
{
    return (
        <div className="loader-wrapper">
            <div className="row loader-img">
                <div className="col-12">
                <Image 
                    className={"img-fluid"}
                    src="./../../../libs-templates-assets/assets/images/loader/loader-4.gif"
                    alt="loader"
                    priority
                />
                </div>
            </div>
        </div>
    );
};
export default Loading;