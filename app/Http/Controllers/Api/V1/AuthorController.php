<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\BecomeAuthorAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreAuthorRequest;
use App\Http\Requests\Api\V1\UpdateAuthorRequest;
use App\Http\Resources\V1\AuthorCollection;
use App\Http\Resources\V1\AuthorResource;
use App\Http\Resources\V1\BookCollection;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

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
    public function store(StoreAuthorRequest $request, BecomeAuthorAction $action): AuthorResource|JsonResponse
    {
        $validatedData = $request->validated();

        return $action->execute($validatedData);
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

        if (! $books) {
            return $this->notFoundResponse(msg: 'There is not book from this author');
        }

        return $this->successResponse(
            msg: 'Books found',
            data: new BookCollection($books),
        );
    }
}
