<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class CoinGeckoService
{
    protected string $apikey;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apikey = 'CG-Yi7Roocf4QigAsV6xdfXUTJJ';
        $this->apiUrl = env('COIN_URL') . '/api/v3/simple/price';
    }

    /**
     * Получить цену для выбранных валют.
     *
     * @param array<string>|string $ids
     * @param array<string>|string $vsCurrencies
     * @return array<string, mixed>|null
     */
    public function getPrice(array|string $ids, array|string $vsCurrencies): ?array
    {
        $ids = is_array($ids) ? implode(',', $ids) : $ids;
        $vsCurrencies = is_array($vsCurrencies) ? implode(',', $vsCurrencies) : $vsCurrencies;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apikey,
        ])->get($this->apiUrl, [
            'ids' => $ids,
            'vs_currencies' => $vsCurrencies,
        ]);

        $data = $response->successful() ? $response->json() : null;

        return is_array($data) ? (array)$data : null;
    }
}
