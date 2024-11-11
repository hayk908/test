<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDeleteRequest extends FormRequest
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
            'id' => 'required|int',
        ];
    }
}
