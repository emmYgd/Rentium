<?php

namespace App\Observers;

use App\Models\Tenant\Tenant;

class TenantObserver
{
    /**
     * Handle the Tenant "created" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function created(Tenant $tenant)
    {
        $tenant_email = $tenant->tenant_email;

        //send mail: //NOTE: In a cart just created, the default value is pending:
        $mail_from = env('ADMIN_EMAIL');
        $mail_header = "From:".  $mail_from;
        $mail_to = $tenant_email;
        $mail_subject = "You Just Signed Up with Us!";
        $mail_message = "KUDOS! You have just created your Account with Us. Dont stop there - Select our products, clear your cart, and keep enjoying our amazing offers. Best Regards!";
        
        $mail_was_sent = mail($mail_to, $mail_subject, $mail_message, $mail_header);
        if($mail_was_sent)
        {
            echo "Mail was sent!";

        }else
        {
            echo "Mail was not sent!";
        }
    }

    /**
     * Handle the Tenant "updated" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function updated(Tenant $tenant)
    {
        $tenant_email = $tenant->tenant_email;

        //send mail: //NOTE: In a cart just created, the default value is pending:
        $mail_from = env('ADMIN_EMAIL');
        $mail_header = "From:".  $mail_from;
        $mail_to = $tenant_email;
        $mail_subject = "A recent change!";
        $mail_message = "A recent change was just made to your account! If that was not you, reply to this email confirming and explaining the assertion. Best Regards!";
        
        $mail_was_sent = mail($mail_to, $mail_subject, $mail_message, $mail_header);
        if($mail_was_sent)
        {
            echo "Mail was sent!";

        }else
        {
            echo "Mail was not sent!";
        }
    }

    /**
     * Handle the Tenant "deleted" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function deleted(Tenant $tenant)
    {
        //
    }

    /**
     * Handle the Tenant "restored" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function restored(Tenant $tenant)
    {
        //
    }

    /**
     * Handle the Tenant "force deleted" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function forceDeleted(Tenant $tenant)
    {
        //
    }
}
