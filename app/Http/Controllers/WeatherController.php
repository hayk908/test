<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\WeatherRequestName;

class WeatherController extends Controller
{
    public function getWeather(WeatherRequestName $weatherRequestName): JsonResponse
    {
        $data = $weatherRequestName->validated();

        $city = $data['city'];

        $apiKey = config('services.weatherperson.key');

        $response = Http::get(env('WEATHER_URL') . "/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'ru',
        ]);

        $responseData = $response->json();

        if ($response->successful() && is_array($responseData)) {
            if (isset($responseData['main'], $responseData['name'], $responseData['coord'])) {
                $weatherData = [
                    'id' => $responseData['main']['temp'],
                    'main' => $responseData['main']['temp'],
                    'description' => $responseData['main']['humidity'],
                ];

                return response()->json([
                    'city' => $responseData['name'],
                    'weather' => $weatherData,
                    'coordinates' => $responseData['coord'],
                ]);
            } else {
                return response()->json(['error' => 'Unexpected response structure'], 500);
            }
        }

        return response()->json(['error' => 'Unable to retrieve weather data'], $response->status());
    }
}
