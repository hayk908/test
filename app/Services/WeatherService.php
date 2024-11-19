<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{

    /**
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function getWeather(array $data): array
    {
        if (!isset($data['city']) || !is_string($data['city'])) {
            throw new \InvalidArgumentException('City must be a non-empty string.');
        }

        $apiKey = config('services.weatherperson.key');

        $response = Http::get(env('WEATHER_URL') . "/data/2.5/weather", [
            'q' => $data['city'],
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'ru',
        ]);

        $responseData = $response->json();

        if ($response->successful() && is_array($responseData)) {
            if (isset($responseData['main'], $responseData['name'], $responseData['coord'])) {
                return [
                    'city' => $responseData['name'],
                    'weather' => [
                        'id' => $responseData['main']['temp'],
                        'main' => $responseData['main']['temp'],
                        'description' => $responseData['main']['humidity'],
                    ],
                    'coordinates' => $responseData['coord'],
                ];
            } else {
                throw new \RuntimeException('Unexpected response structure');
            }
        }

        throw new \RuntimeException('Unable to retrieve weather data', $response->status());
    }
}
