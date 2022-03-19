<?php

namespace App\Services;

use App\Models\User;
use App;
use App\Notifications\SuccessUserRegistration;

class UserService
{

    /**
     *
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @throws \Exception
     */
    public function registerUser(string $email, string $password, string $passwordConfirmation)
    {
        // Check unique
        if (User::where('email', $email)->exists()) {
            throw new \Exception(trans('user.email_already_registered'));
        }

        // Check password confirmation
        if ($password !== $passwordConfirmation) {
            throw new \Exception(trans('user.wrong_password_confirmation'));
        }

        // Register user
        $user = App::make(User::class);
        $user->name = $email;
        $user->email = $email;
        $user->password = $password;
        $user->save();

        // Sent Email confirmation
        $user->notify(new SuccessUserRegistration($user));

        return $user;
    }
}