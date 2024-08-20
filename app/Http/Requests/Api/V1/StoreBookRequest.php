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
            'publication_date' => 'required|date',
            'price' => 'required|int',
            'currency' => 'required|string',
            'author' => 'required|string',
            'quantity' => 'required|int',
            'genre_id' => 'required|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'publication_date' => $this->publicationDate,
            'genre_id' => $this->genreId,
        ]);
    }
}
