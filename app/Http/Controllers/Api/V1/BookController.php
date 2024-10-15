<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\StoreBookAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreBookRequest;
use App\Http\Requests\Api\V1\UpdateBookRequest;
use App\Http\Resources\V1\BookCollection;
use App\Http\Resources\V1\BookResource;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): BookCollection
    {
        return new BookCollection(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request, StoreBookAction $action)
    {
        return $action->execute($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        try {
            return $this->successResponse('', new BookResource($book));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $apiData = $request->validated();

        $book->update($apiData);

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //        $res = $book->softDeletes();
        //
        //        dd($res);
    }
}
