<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'surname' => 'required|string|min:1|max:100',
            'name' => 'required|string|min:1|max:100',
            'patronymic' => 'string|min:1|max:100',
            'login' => 'required|string|min:1|max:255|unique:users',
            'password' => 'required|string|min:1|max:255',
            'photo_file' => 'string|min:1|max:255',
            'status' => 'enum|min:1|max:255',
        ];
    }
}
