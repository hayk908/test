<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoinGeckoRequest;
use App\Service\CoinGeckoService;
use Illuminate\Http\JsonResponse;

class CoinGeckoController extends Controller
{
    protected CoinGeckoService $coinGeckoService;

    public function __construct(CoinGeckoService $coinGeckoService)
    {
        $this->coinGeckoService = $coinGeckoService;
    }

    public function getBitcoinPrice(CoinGeckoRequest $request): JsonResponse
    {
        $data = $request->validated();

        $ids = array_map(fn($item) => is_scalar($item) ? (string)$item : '', (array)$data['ids']);
        $vsCurrencies = array_map(fn($item) => is_scalar($item) ? (string)$item : '', (array)$data['vs_currencies']);

        $ids = array_filter($ids, fn($item) => $item !== '');
        $vsCurrencies = array_filter($vsCurrencies, fn($item) => $item !== '');

        $response = $this->coinGeckoService->getPrice($ids, $vsCurrencies);

        if ($response) {
            return response()->json($response);
        }

        return response()->json(['error' => 'Failed to retrieve data from CoinGecko'], 500);
    }
}