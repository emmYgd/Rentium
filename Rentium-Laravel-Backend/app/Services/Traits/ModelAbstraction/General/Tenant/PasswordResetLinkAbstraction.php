<?php

namespace App\Services\Traits\ModelAbstractions\General\Tenant;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Events\Dispatcher;

use App\Services\Traits\ModelAbstractions\Tenant\TenantAccessAbstraction;
use App\Services\Traits\Utilities\GenerateLinksService;

use App\Events\Tenant\PassResetLinkWasFormed;

trait PasswordResetLinkAbstraction
{
    use TenantAccessAbstraction;
    use GenerateLinksService;
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function SendPasswordResetMail(Request $request, string $url_title, array $other_url_params): string/*:
        bool*/
    {
        //else: form verification url:
        $pass_reset_link = $this->GeneratePassResetLink($url_title, $other_url_params);
        //use event to create and send mailing instance:
        event(new PassResetLinkWasFormed($request, $pass_reset_link));

        return $pass_reset_link;//true;
    }
}
