<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreWishListRequest;
use App\Http\Resources\V1\BookCollection;
use App\Http\Resources\V1\WishListCollection;
use App\Http\Resources\V1\WishListResource;
use App\Models\Book;
use App\Models\WishList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishList = WishList::where('user_id', Auth::id())->get();
        $books = [];
        $wishList->each(function ($wishList) use (&$books) {
            $books[] = Book::find($wishList->book_id);
        })->collect();
        return new BookCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWishListRequest $request): WishListResource
    {
        $data = $request->validated();
        $user = auth()->user();

        $wishList = $user->wishLists()->create([
            'book_id' => $data['book_id'],
        ]);

        return new WishListResource($wishList);

    }

    public function destroy(WishList $list, string $id)
    {
        try {
            $AuthUserId = auth()->user()->id;
            $currentWishList = $list::find($id);

            if ($AuthUserId !== $currentWishList?->user_id) {
                throw new \Exception('wrong request');
            }

            $res = $currentWishList->delete();
            return new JsonResponse($res);
        } catch (\JsonException $e) {
            return new JsonResponse($e->getMessage());
        }
    }
}
