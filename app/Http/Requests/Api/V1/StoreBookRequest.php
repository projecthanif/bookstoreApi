<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => 'required|string|max:255|min:5',
            'description' => 'required|string',
            'isbn' => 'required|string',
            'publicationDate' => 'required|date',
            'price' => 'required|int',
            'currency' => 'required|string',
            'quantity' => 'required|int',
            'publisherId' => 'required|string',
            'genreId' => 'required|string',
        ];
    }

    public function prepareForValidation()
    {
        return [
            'publicationDate' => 'publication_date',
            'publisherId' => 'publisher_id',
            'genreId' => 'genre_id',
        ];
    }
}
