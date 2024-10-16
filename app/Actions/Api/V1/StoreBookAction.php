<?php

namespace App\Actions\Api\V1;

use App\Http\Resources\V1\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StoreBookAction extends ApiAction
{
    public function execute(array $apiData): BookResource|JsonResponse
    {

        $user = Auth::user();

        $response = Gate::inspect('create', Book::class);

        if (! $response->allowed()) {
            return $this->clientErrorResponse('Unauthorized', 401);
        }

        $book = $user->book()->create($apiData);

        return new BookResource($book);
    }
}
