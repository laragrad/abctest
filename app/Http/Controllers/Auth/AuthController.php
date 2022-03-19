<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\AuthRequest;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     *
     * @param AuthRequest $request
     * @return array
     */
    public function token(AuthRequest $request) {

        $request->authenticate();

        $tokenName = 'token'; // TODO Client app/device name
        $token = $request->user()->createToken($tokenName);

        return [
            'token' => $token->plainTextToken,
        ];
    }
}