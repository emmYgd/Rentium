<?php

namespace App\Observers;

use App\Models\Admin\Admin;

class AdminObserver
{
    /**
     * Handle the Admin "created" event.
     *
     * @param  \App\Models\Admin  $admin
     * @return void
     */
    public function created(Admin $admin)
    {
        $admin_email = $admin->admin_email;

        //send mail: //NOTE: In a cart just created, the default value is pending:
        $mail_from = env('ADMIN_EMAIL');
        $mail_header = "From:".  $mail_from;
        $mail_to = $admin_email;
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
     * Handle the Admin "updated" event.
     *
     * @param  \App\Models\Admin  $admin
     * @return void
     */
    public function updated(Admin $admin)
    {
        $admin_email = $admin->admin_email;

        //send mail: //NOTE: In a cart just created, the default value is pending:
        $mail_from = env('ADMIN_EMAIL');
        $mail_header = "From:".  $mail_from;
        $mail_to = $admin_email;
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
     * Handle the Admin "deleted" event.
     *
     * @param  \App\Models\Admin  $admin
     * @return void
     */
    public function deleted(Admin $admin)
    {
        //
    }

    /**
     * Handle the Admin "restored" event.
     *
     * @param  \App\Models\Admin  $admin
     * @return void
     */
    public function restored(Admin $admin)
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     *
     * @param  \App\Models\Admin  $admin
     * @return void
     */
    public function forceDeleted(Admin $admin)
    {
        //
    }
}
