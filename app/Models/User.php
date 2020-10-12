<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use App\Notifications\LoginNotification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\RegisterNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\PasswordResetNotification;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\PasswordResetSuccessNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Send the registeration notification
     *
     * @param  mixed $token
     * @return void
     */
    public function sendRegisterNotification()
    {
        $this->notify(new RegisterNotification);
    }


    /**
     * Send the login notification
     *
     * @param  mixed $token
     * @return void
     */
    public function sendLoginNotification()
    {
        $this->notify(new LoginNotification);
    }

    /**
     * Send the password reset notification
     *
     * @param  mixed $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    /**
     * Send the password reset success notification
     *
     * @param  mixed $token
     * @return void
     */
    public function sendPasswordResetSuccessNotification()
    {
        $this->notify(new PasswordResetSuccessNotification);
    }

    /**
     * Send the email verification notification
     *
     * @param  mixed $token
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification);
    }
}
