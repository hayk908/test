<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthsRequestName extends FormRequest
{
   public const EMAIL = 'email';
   public const PASSWORD = 'password';

    public function rules(): array
    {
        return [
            self::EMAIL => 'required|string|email|max:255',
            self::PASSWORD => 'required|string',
        ];
    }
}
