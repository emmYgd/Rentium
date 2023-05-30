'use client'

import React from 'react';
import {useEffect} from 'react';

//sample:
const Error = ({error, reset}: {error: Error; reset:() => void}) => 
{
    useEffect(() => {
        //log the error to an error reporting service:
        console.error(error);
    }, [error]);

    //return component:
    return (
        <div>
            <h2>Something went wrong</h2>
            <button
                onClick={
                    //attempt to recover by re-rendering the segment:
                    () => reset()
                }
            >
            </button>
        </div>
    );
};
export default Error;