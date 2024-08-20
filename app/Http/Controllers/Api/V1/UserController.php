<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): UserCollection
    {
        return new UserCollection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $data = $request->validated();
        $data['role'] = UserRole::User->value;

        return new UserResource(User::create($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id): UserResource
    {
        User::find($id)->update($request->validated());

        return new UserResource(User::find($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return User::find($id)?->delete();
    }

    /**
     * Login User
     *
     * @throws \JsonException
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email',
            'password' => 'string',
        ]);


        $attempt = Auth::attempt($data);

        if ($attempt) {
            $user = Auth::user();
            $token = '';
            if ($user === null) {
                return new JsonResponse($user);
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

            return new JsonResponse([
                'token' => $token?->plainTextToken,
            ]);
        }

        return new JsonResponse($attempt);
    }
}
