<?php

namespace App\Actions\Api\V1;

use App\Models\Review;
use Illuminate\Http\JsonResponse;

class MakeReviewAction extends ApiAction
{
    public function __construct(
        public Review $review
    )
    {
    }

    public function exceute(mixed $validated): JsonResponse
    {

        $this->review->create($validated);

        return $this->successResponse('Review created successfully', statusCode: 201);
    }
}
