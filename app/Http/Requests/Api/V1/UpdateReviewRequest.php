<?php

namespace App\Http\Requests\Api\V1;

use App\Models\Review;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[CurrentUser] $authenticatedUser,
        #[RouteParameter('review')] Review $reviewId
    ): bool
    {
        return $authenticatedUser->id === $reviewId->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => 'sometimes|required|integer|between:1,5',
            'review_text' => 'sometimes|required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'review_text' => $this->reviewText
        ]);
    }
}
