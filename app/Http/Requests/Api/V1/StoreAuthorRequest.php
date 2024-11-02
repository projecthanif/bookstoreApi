<?php

namespace App\Http\Requests\Api\V1;

use App\Enum\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->role !== UserRole::Author->value;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:authors,name',
            'biography' => 'required|string',
            'dob' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.unique' => 'Pen name already taken.',
            'biography.required' => 'Biography is required.',
            'biography.string' => 'Biography must be a string.',
            'dob.required' => 'Date of Birth is required.',
            'dob.date' => 'Date of Birth must be a string.',
        ];
    }
}
