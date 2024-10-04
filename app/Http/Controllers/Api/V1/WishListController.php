<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreWishListRequest;
use App\Http\Resources\V1\WishListResource;
use App\Models\WishList;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishLists = WishList::where('user_id', Auth::id())->with('book')->get();

        return WishListResource::collection($wishLists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWishListRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        $wishList = $user->wishLists()->create($data);

        return $this->successResponse(
            msg: 'Book added to wishlist',
            data: new WishListResource($wishList),
            statusCode: 201,
        );
    }

    /**
     * @throws \Exception
     */
    public function destroy(WishList $list, string $id)
    {
        try {
            $AuthUserId = auth()->user()->id;
            $currentWishList = $list::find(10);

            if ($AuthUserId !== $currentWishList->user_id) {
                throw new \Exception('Wrong Request');
            }

            $currentWishList->delete();

            return $this->successResponse(
                msg: 'Book removed from wishlist',
                statusCode: true,
            );
        } catch (\JsonException $e) {
            return new JsonResponse($e->getMessage());
        }
    }
}
