<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        
        $segments = request()->segments();
        $id = $segments[3];
        return ($user?->author?->id === (int) $id);
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
