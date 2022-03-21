<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserRegisterRequest;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     *
     * @param UserRegisterRequest $request
     * @param UserService $service
     * @return string[]
     */
    public function register(UserRegisterRequest $request, UserService $service)
    {
        $user = $service->registerUser($request->email, $request->password);

        return $user;
    }
}
