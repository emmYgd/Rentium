<?php

namespace App\Services\Traits\ModelAbstraction\General\Landlord;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use App\Services\Traits\Utilities\PassHashVerifyService;

trait NewPasswordAbstraction
{
    use PassHashVerifyService;
    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function LandlordImplementResetPasswordService(Request $request): bool
    {
        //get the new password:
        $landlord_new_password = $request->landlord_new_password;
        //hash the new pass:
        $landlord_new_hashed_password = $this->CustomHashPassword($landlord_new_password);

        //other requests params:
        $unique_landlord_id = $request->unique_landlord_id;
        $landlord_email = $request->landlord_email;
        $pass_reset_token = $request->pass_reset_token;

        //db queries:
        $queryKeysValues = [
            'unique_landlord_id' => $unique_landlord_id,
            'landlord_email' => $landlord_email,
            //production:
           //'pass_reset_token' => $this->CustomHashPassword(pass_reset_token)
            //test:
            'pass_reset_token' => $pass_reset_token
        ];

        //db update:
        $newKeysValues = [
            'landlord_password' => $landlord_new_hashed_password,
        ];
 
        //update:
        $was_password_updated = $this->LandlordUpdateSpecificService($queryKeysValues, $newKeysValues);
        if(!$was_password_updated)
        {
            return false;
        }
        //else:
            return true;
    }
}
