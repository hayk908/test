<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoinGeckoRequest;
use App\Service\CoinGeckoService;
use App\Traits\GreetableTraits;
use Illuminate\Http\JsonResponse;

class CoinGeckoController extends Controller
{
//    use GreetableTraits;

    protected CoinGeckoService $coinGeckoService;

    public function __construct(CoinGeckoService $coinGeckoService)
    {
        $this->coinGeckoService = $coinGeckoService;
    }

    public function getBitcoinPrice(CoinGeckoRequest $request): JsonResponse
    {
        $data = $request->validated();

        $response = $this->coinGeckoService->getPrice($data['ids'], $data['vs_currencies']);

        if ($response) {
            return response()->json($response);
        }

        return response()->json(['error' => 'Failed to retrieve data from CoinGecko'], 500);
    }
}
