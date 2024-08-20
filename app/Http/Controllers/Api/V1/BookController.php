<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreBookRequest;
use App\Http\Resources\V1\BookCollection;
use App\Http\Resources\V1\BookResource;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Policies\V1\BookPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new BookCollection(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $formData = $request->validated();

        $user = Auth::user();


        $book = DB::transaction(static function () use ($formData, $user) {
            $book = Book::create($formData);
            BookAuthor::create([
                'book_id' => $book->id,
                'author_id' => $user->author()->get()->first()->id,
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

    public function update(BookPolicy $policy, Book $book)
    {
//        dd($policy);
//        if($policy){
//
//        }
        return new JsonResponse([
            'message' => "You can't update someone's work"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
