<?php

namespace App\Http\Requests\Api\V1;

use App\Models\Author;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[CurrentUser]              $user,
        #[RouteParameter('author')] Author $author
    ): bool
    {
        return $user->id === $author->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (request()->method() === 'PUT') {
            return [
                'name' => 'required|string|max:100',
                'biography' => 'required|string',
                'dob' => 'required|date',
            ];
        }

        return [
            'name' => 'sometimes|required|string|max:100',
            'biography' => 'sometimes|required|string',
            'dob' => 'sometimes|required|date',
        ];
    }
}
