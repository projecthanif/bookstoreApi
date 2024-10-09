<?php

namespace App\Actions\Api\V1;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserLoginAction extends ApiAction
{
    public function execute(array $data)
    {
        $attempt = Auth::attempt($data);

        if ($attempt) {
            $user = Auth::user();

            if ($user === null) {
                return $this->serverErrorResponse(msg: '');
            }

            $token = $this->generateToken($user);

            return $this->successResponse(
                msg: 'Logged in successfully.',
                data: [
                    'token' => $token?->plainTextToken,
                ],
            );
        }

        return $this->serverErrorResponse('', 500);
    }

    private function generateToken(User $user): \Laravel\Sanctum\NewAccessToken
    {
        return match ($user->role) {
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
            default => $user->createToken('user_token', ['user:update']),
        };
    }
}
