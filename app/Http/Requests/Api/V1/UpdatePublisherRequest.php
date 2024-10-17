<?php

namespace App\Http\Requests\Api\V1;

use App\Enum\UserRole;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UpdatePublisherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[CurrentUser]                 $user,
        #[RouteParameter('publisher')] $publisher
    ): bool
    {
        return $user->id === $publisher->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (Request::method() === 'PUT') {
            return [
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'website' => 'required|string|max:255',
            ];
        }

        return [
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'website' => 'sometimes|string|max:255',
        ];
    }
}
