<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeatherRequestName extends FormRequest
{
    public const CITY = 'city';


    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            self::CITY => 'required|string'
        ];
    }
}
