<?php

namespace App\Services\Traits\ModelAbstraction\General\Tenant;

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
    protected function TenantImplementResetPasswordService(Request $request): bool
    {
        //get the new password:
        $tenant_new_password = $request->tenant_new_password;
        //hash the new pass:
        $tenant_new_hashed_password = $this->CustomHashPassword($tenant_new_password);

        //other requests params:
        $unique_tenant_id = $request->unique_tenant_id;
        $tenant_email = $request->tenant_email;
        $pass_reset_token = $request->pass_reset_token;

        //db queries:
        $queryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
            'tenant_email' => $tenant_email,
             //production:
           //'pass_reset_token' => $this->CustomHashPassword(pass_reset_token)
            //test:
            'pass_reset_token' => $pass_reset_token
        ];

        //db update:
        $newKeysValues = [
            'tenant_password' => $tenant_new_hashed_password,
        ];
 
        //update:
        $was_password_updated = $this->TenantUpdateSpecificService($queryKeysValues, $newKeysValues);
        if(!$was_password_updated)
        {
            return false;
        }
        //else:
            return true;
    }
}
