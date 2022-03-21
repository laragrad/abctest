<?php

namespace App\Services;

use App;
use App\Models\User;
use App\Notifications\UserRegistrationConfirmation;
use App\Exceptions\CustomException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;

class UserService
{

    /**
     * Registering new user
     *
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @throws \Exception
     */
    public function registerUser(string $email, string $password)
    {
        // Check unique email
        if (User::where('email', $email)->exists()) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, trans('user.email_already_registered'));
        }

        // Register user
        $user = App::make(User::class);
        $user->name = $email;
        $user->email = $email;
        $user->password = $password;
        $user->save();
        $user->refresh();

        // Sent Email confirmation
        $this->sendRegistrationConfirmation($user);

        return $user;
    }

    /**
     * Sending user registration confirmation
     *
     * @param User $user
     */
    public function sendRegistrationConfirmation(User $user)
    {
        $user->notify(new UserRegistrationConfirmation($user));
    }
}