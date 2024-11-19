<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\WeatherRequestName;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    public function __construct(protected WeatherService $weatherService)
    {
    }

    public function getWeather(WeatherRequestName $weatherRequestName): JsonResponse
    {
        try {
            $weatherData = $this->weatherService->getWeather($weatherRequestName->validated());

            return response()->json($weatherData);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
