<?php

namespace App\Actions\Api\V1;

use App\Http\Resources\V1\CartResource;

class CreateCartAction
{
    public function execute(array $data)
    {
        $user = auth()->user();

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
}
