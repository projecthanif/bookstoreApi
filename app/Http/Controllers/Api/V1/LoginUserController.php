<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\UserLoginAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginUserController extends Controller
{
    public function __invoke(Request $request, UserLoginAction $action)
    {
        return $action->execute($request);
    }
}
