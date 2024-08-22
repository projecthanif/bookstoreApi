<?php

namespace App\Http\Requests\Api\V1;

use App\Models\UserBook;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        $url = url()->current();
        $array = explode('/', $url);
        $urlArr = end($array);
        $userBookId = UserBook::find($urlArr)?->user_id ?? '';
        return $userBookId === $user?->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->method() === 'PUT') {
            return [
                'title' => 'required|string|max:255|min:5',
                'description' => 'required|string',
                'isbn' => 'required|string',
                'publication_date' => 'required|date',
                'price' => 'required|int',
                'currency' => 'required|string',
                'quantity' => 'required|int',
                'genre_id' => 'required|string',
            ];
        }
        return [
            'title' => 'sometimes|required|string|max:255|min:5',
            'description' => 'sometimes|required|string',
            'isbn' => 'sometimes|required|string',
            'publication_date' => 'sometimes|required|date',
            'price' => 'sometimes|required|int',
            'currency' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|int',
            'genre_id' => 'sometimes|required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'publication_date' => $this->publicationDate,
            'genre_id' => $this->genreId,
        ]);
    }
}
