<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreAuthorRequest;
use App\Http\Resources\V1\AuthorCollection;
use App\Http\Resources\V1\AuthorResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AuthorCollection(Author::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $validatedData = $request->validated();
        $user = auth()->user();

        $check = $user?->author?->id === null;
        if (!$check || $user === null) {
            return new JsonResponse([
                'message' => 'already an author!!'
            ]);
        }

        $return = DB::transaction(static function () use ($validatedData, $user) {
            $user->update([
                'role' => UserRole::Author->value
            ]);
            $validatedData['user_id'] = $user->id;

            return Author::create($validatedData);
        });

        return new AuthorResource($return);

    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
