<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'name' => 'required',
        ];
    }
}
