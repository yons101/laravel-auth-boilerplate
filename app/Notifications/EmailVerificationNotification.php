<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail;

class EmailVerificationNotification extends VerifyEmail
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }
        return (new MailMessage)
            ->subject(Lang::get('Verify your e-mail adress'))
            ->line(Lang::get('Please click the button below to verify your account'))
            ->action(
                Lang::get('Verify'),
                $this->verificationUrl($notifiable)
            )
            ->line(Lang::get('If this wasn\'t you, no action from you is required'));
    }
}
