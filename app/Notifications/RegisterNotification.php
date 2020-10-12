<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail;

class RegisterNotification extends VerifyEmail
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::get('Your account has been created!'))
            ->line(Lang::get('You have successfully created your account with us.'))
            ->line(Lang::get('Please click the button below to verify your account'))
            ->action(
                Lang::get('Verify'),
                $this->verificationUrl($notifiable)
            )
            ->line(Lang::get('If this wasn\'t you, contact us.'));
    }
}
