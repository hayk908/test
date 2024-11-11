<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetUsersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'enable' => 'nullable|in:0,1',
            'users' => 'nullable|array',
            'users.*' => 'integer|exists:users,id'
        ];
    }
}
