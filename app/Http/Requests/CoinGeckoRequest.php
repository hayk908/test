<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoinGeckoRequest extends FormRequest
{
    public const IDS = 'ids';
    public const VS_CURRENCIES = 'vs_currencies';

    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            self::IDS => 'required',
            self::VS_CURRENCIES => 'required',
        ];
    }

}