<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRequestName extends FormRequest
{
    public const NAME = 'name';

    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            self::NAME => 'required|string',
        ];
    }
}
