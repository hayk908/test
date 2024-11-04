<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilRequestName extends FormRequest
{

    public const  BIO = 'bio';
    public const AVATAR = 'avatar';

    public function rules()
    {
        return [
            self::BIO => 'nullable|string',
            self::AVATAR => 'required|string'
        ];
    }
}
