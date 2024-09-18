<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreAuthorRequest;
use App\Http\Requests\Api\V1\UpdateAuthorRequest;
use App\Http\Resources\V1\AuthorCollection;
use App\Http\Resources\V1\AuthorResource;
use App\Http\Resources\V1\BookCollection;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AuthorCollection
    {
        return new AuthorCollection(Author::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request): AuthorResource|JsonResponse
    {
        $validatedData = $request->validated();
        $user = auth()->user();

        $check = $user?->author?->id === null;
        if (!$check) {
            return new JsonResponse([
                'message' => 'already an author!!',
            ]);
        }

        $return = DB::transaction(static function () use ($validatedData, $user) {
            $user->update([
                'role' => UserRole::Author->value,
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
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        try {
            $author->update($request->validated());
            return new AuthorResource($author);
        } catch (\JsonException $e) {
            return $e->getMessage();
        }
    }

    public function books(string $name): BookCollection
    {
        $books = Book::where(['author' => $name])->get();
        return new BookCollection($books);
    }
}
