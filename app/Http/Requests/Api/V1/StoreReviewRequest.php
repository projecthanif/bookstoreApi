<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id' => 'required|integer|exists:books,id',
            'rating' => 'required|integer|between:1,5',
            'review_text' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'review_text' => $this->reviewText,
        ]);
    }

    public function messages()
    {
        return [
            'book_id.required' => 'The book_id is required',
            'book_id.integer' => 'The book_id must be an integer',
            'book_id.exists' => 'This book does not exist',
            'rating.required' => 'Rating is required',
            'rating.integer' => 'Rating must be an integer',
            'rating.between' => 'Rating must be between 1 and 5',
            'review_text.required' => 'Review text is required',
            'review_text.string' => 'Review text must be string',
        ];
    }
}
