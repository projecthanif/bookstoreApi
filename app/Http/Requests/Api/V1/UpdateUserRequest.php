<?php

namespace App\Http\Requests\Api\V1;

use App\Enum\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        if ($user?->role === UserRole::ADMIN->value) {
            return $user !== null && $user->tokenCan('user:update');;
        }

        $arr = request()->segments();
        $check = $user->id === (int) $arr[3];

        if ($check) {
            return $user !== null && $user->tokenCan('user:update');
        }
        return false;

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
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'role' => 'required|string',
            ];
        }
        return [
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'password' => 'sometimes|required|string',
            'role' => 'sometimes|required|string',
        ];
    }
}
