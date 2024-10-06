<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    public function __invoke(Request $request)
    {

        $data = $request->validate([
            'email' => 'email',
            'password' => 'string',
        ]);

        $attempt = Auth::attempt($data);

        if ($attempt) {
            $user = Auth::user();

            if ($user === null) {
                return $this->serverErrorResponse('', 500);
            }

            $token = match ($user->role) {
                UserRole::User->value => $user->createToken('user_token', ['user:update']),
                UserRole::ADMIN->value => $user->createToken('admin_token'),
                UserRole::Publisher->value => $user->createToken('publisher_token', [
                    'user:*',
                    'publisher:create',
                    'publisher:update',
                    'publisher:delete',
                ]),
                UserRole::Author->value => $user->createToken('author_token', [
                    'user:*',
                    'author:create',
                    'author:update',
                    'author:delete',
                ]),
            };

            return $this->successResponse(
                msg: 'Logged in successfully.',
                data: [
                    'token' => $token?->plainTextToken,
                ],
                statusCode: 200
            );
        }

        return $this->serverErrorResponse('', 500);   //
    }
}
