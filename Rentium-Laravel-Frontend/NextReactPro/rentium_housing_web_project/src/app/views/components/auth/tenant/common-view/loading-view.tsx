import React from 'react';
import Image from 'next/image';

//import "./../../../libs-templates-assets/assets/images/loader/loader-4.gif"

//sample:
const LoadingView = () => 
{
    return (
        <div className="loader-wrapper">
            <div className="row loader-img">
                <div className="col-12">
                    <Image 
                        className={"img-fluid"}
                        src="/public/libs-templates-assets/assets/images/loader/loader-4.gif"
                        alt="loader"
                        width={50} 
                        height={50}
                        priority
                    />
                </div>
            </div>
        </div>
    );
};
export default LoadingView;