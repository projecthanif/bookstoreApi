<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\MakeReviewAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreReviewRequest;
use App\Http\Requests\Api\V1\UpdateReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{

    public function store(StoreReviewRequest $request, MakeReviewAction $action)
    {
        $formData = $request->validated();
        $formData['user_id'] = auth()->id();
        return $action->exceute($formData);
    }


    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());
        return $this->successResponse('Review updated successfully');
    }
}
