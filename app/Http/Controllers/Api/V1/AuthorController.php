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

        if ($user?->author?->id !== null) {
            return $this->clientErrorResponse(msg: 'Already an author!!');
        }

        $author = DB::transaction(static function () use ($validatedData, $user) {
            $user->update([
                'role' => UserRole::Author->value,
            ]);
            $validatedData['user_id'] = $user->id;

            return Author::create($validatedData);
        });

        $mutatedAuthor = new AuthorResource($author);

        return $this->successResponse(
            msg: 'Congrats! you have  become an author',
            data: $mutatedAuthor,
            statusCode: 201
        );
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

            return $this->successResponse(
                'Author Info updated',
                data: new AuthorResource($author),
            );
        } catch (\JsonException $e) {
            return $e->getMessage();
        }
    }

    public function books(string $name): JsonResponse
    {
        $books = Book::where(['author' => $name])?->get()->first();

        if (!$books) {
            return $this->notFoundResponse(msg: 'There is not book from this author');
        }

        return $this->successResponse(
            msg: 'Books found',
            data: new BookCollection($books),
        );
    }
}
