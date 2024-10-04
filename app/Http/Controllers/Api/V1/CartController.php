<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCartRequest;
use App\Http\Resources\V1\CartCollection;
use App\Http\Resources\V1\CartResource;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $carts = $user->carts()->get();

        return new CartCollection($carts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $cart = $user->carts()->where([
            'book_id' => $data['book_id'],
            'user_id' => $user->id,
        ])->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            $new = $user->carts()->create($data);
            $cart = $user->carts()->find($new->id);
        }

        return new CartResource($cart);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        try {
            $cart = Auth::user()->carts()->find($cart);

            return new CartCollection($cart);
        } catch (\Exception $exception) {
            return new JsonResponse($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        try {
            $user = Auth::user();
            if ($cart->user_id != $user->id) {
                throw new Exception('UnAuthorized');
            }

            return new JsonResponse($cart->delete());
        } catch (\Exception $exception) {
            return new JsonResponse($exception->getMessage());
        }
    }
}
