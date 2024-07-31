<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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
        $request['password'] = Hash::make($request->password);
        $data = $request->validated();
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
        return User::find($id)->delete();
    }

    /**
     * Login User
     * @throws \JsonException
     */

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'string',
            'password' => 'string'
        ]);
        $attempt = Auth::attempt($data);

        if($attempt) {
            $user = Auth::user();
            $token  = $user->createToken('user_token');
            return new JsonResponse([
                'token' => $token->plainTextToken
            ]);
        }

        return new JsonResponse($attempt);
    }

}
