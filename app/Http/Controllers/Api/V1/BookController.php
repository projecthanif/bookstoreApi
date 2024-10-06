<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreBookRequest;
use App\Http\Requests\Api\V1\UpdateBookRequest;
use App\Http\Resources\V1\BookCollection;
use App\Http\Resources\V1\BookResource;
use App\Models\Book;
use App\Models\UserBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function store(StoreBookRequest $request)
    {
        $apiData = $request->validated();

        $user = Auth::user();

        $book = DB::transaction(static function () use ($apiData, $user) {
            $book = Book::create($apiData);
            UserBook::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
            ]);
            return $book;
        });
        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return new BookResource($book);
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
