<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDateList extends FormRequest
{
    public const START = 'start';

    public const END = 'end';

    public function rules(): array
    {
        return [
            self::START => 'required|string|date_format:Y-m-d',
            self::END => 'required|string|date_format:Y-m-d',
        ];
    }

}
