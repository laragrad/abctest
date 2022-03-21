<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserOptionChangeRequest;
use App\Services\UserOptionService;
use App\Http\Controllers\Controller;

class UserOptionController extends Controller
{

    /**
     * Changing user options
     *
     * @param UserOptionChangeRequest $request
     * @param UserOptionService $service
     * @return string[]
     */
    public function edit(UserOptionChangeRequest $request, UserOptionService $service)
    {
        $result = $service->changeOptions($request->user(), $request->only('language','timezone'));

        return ['updated' => $result];
    }
}
