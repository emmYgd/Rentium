<?php

namespace App\Observers;

use App\Models\Landlord\Landlord;

class LandlordObserver
{
    /**
     * Handle the Landlord "created" event.
     *
     * @param  \App\Models\Landlord  $landlord
     * @return void
     */
    public function created(Landlord $landlord)
    {
        $landlord_email = $landlord->landlord_email;

        //send mail: //NOTE: In a cart just created, the default value is pending:
        $mail_from = env('ADMIN_EMAIL');
        $mail_header = "From:".  $mail_from;
        $mail_to = $landlord_email;
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
     * Handle the Landlord "updated" event.
     *
     * @param  \App\Models\Landlord  $landlord
     * @return void
     */
    public function updated(Landlord $landlord)
    {
        $landlord_email = $landlord->landlord_email;

        //send mail: //NOTE: In a cart just created, the default value is pending:
        $mail_from = env('ADMIN_EMAIL');
        $mail_header = "From:".  $mail_from;
        $mail_to = $landlord_email;
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
     * Handle the Landlord "deleted" event.
     *
     * @param  \App\Models\Landlord  $landlord
     * @return void
     */
    public function deleted(Landlord $landlord)
    {
        //
    }

    /**
     * Handle the Landlord "restored" event.
     *
     * @param  \App\Models\Landlord  $landlord
     * @return void
     */
    public function restored(Landlord $landlord)
    {
        //
    }

    /**
     * Handle the Landlord "force deleted" event.
     *
     * @param  \App\Models\Landlord  $landlord
     * @return void
     */
    public function forceDeleted(Landlord $landlord)
    {
        //
    }
}
