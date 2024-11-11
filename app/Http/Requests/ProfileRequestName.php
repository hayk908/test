<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequestName extends FormRequest
{

    public const  BIO = 'bio';
    public const AVATAR = 'avatar';

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
            self::BIO => 'nullable|string',
            self::AVATAR => 'required|string'
        ];
    }
}
