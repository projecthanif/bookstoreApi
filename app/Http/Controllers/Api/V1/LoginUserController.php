<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\UserLoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginUserRequest;

class LoginUserController extends Controller
{
    public function __invoke(LoginUserRequest $request, UserLoginAction $action)
    {
        return $action->execute($request->validated());
    }
}
