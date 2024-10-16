<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\CreateCartAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCartRequest;
use App\Http\Resources\V1\CartCollection;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class CartController extends Controller
{
    public function index(): CartCollection
    {
        $user = Auth::user();
        $carts = $user->carts()->get();

        return new CartCollection($carts);
    }

    public function store(StoreCartRequest $request, CreateCartAction $action)
    {
        $data = $request->validated();

        return $action->execute($data);
    }


    public function show(Cart $cart)
    {
        try {
            $cart = Auth::user()->carts()->find($cart);

            return new CartCollection($cart);
        } catch (\Exception $exception) {
            return new JsonResponse($exception->getMessage());
        }
    }

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
