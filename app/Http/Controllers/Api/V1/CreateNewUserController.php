<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class CreateNewUserController extends Controller
{
    public function __invoke(StoreUserRequest $request): UserResource
    {
        $data = $request->validated();
        $data['role'] = UserRole::User->value;
        return new UserResource(User::create($data));
    }
}
