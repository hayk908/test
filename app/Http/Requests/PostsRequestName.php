<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequestName extends FormRequest
{
    public const TITLE = 'title';
    public const CONTENT = 'content';
    public function rules(): array
    {
        return [
            self::TITLE => 'required|string',
            self::CONTENT => 'string|nullable',
        ];
    }
}
