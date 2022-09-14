<?php

namespace App\Http\Services\Traits;

use App\Models\User;
use App\Notifications\SendEmailVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

trait SendEmail
{
    public static function sendEmail($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            $token = Password::createToken(
                $user
            );

            $url = url("/auth/new-password?token=$token&email=$user->email");
            return Notification::route('mail', $user->email)->notify(new SendEmailVerification($url));
        }
    }
}
