<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreWishListRequest extends FormRequest
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
            'book_id' => [
                'required',
                'exists:books,id',
                Rule::unique('wish_lists')->where('user_id', auth()->id()),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'book_id' => $this->bookId,
        ]);
    }

    public function messages()
    {
        return [
            'book_id.unique' => 'Book already added to wish list',
        ];
    }
}
