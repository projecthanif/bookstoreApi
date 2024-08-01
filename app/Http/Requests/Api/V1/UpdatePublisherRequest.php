<?php

namespace App\Http\Requests\Api\V1;

use App\Enum\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UpdatePublisherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        if ($user?->role === UserRole::ADMIN->value) {
            return $user !== null;
        }

        $arr = request()->segments();
        $check = $user?->publisher?->id === (int) $arr[3];

        if ($check) {
            return $user !== null && $user->tokenCan('publisher:update');
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
