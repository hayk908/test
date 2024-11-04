<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequestName extends FormRequest
{
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';

    public function rules(): array
    {
        return [
            self::NAME => 'required|string',
            self::EMAIL => 'required|string',
            self::PASSWORD => 'required|int',
        ];
    }
}
