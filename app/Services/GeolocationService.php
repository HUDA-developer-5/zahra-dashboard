<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeolocationService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_CLIENT_ID');
    }

    public function getGeolocation($ip)
    {
        // Get location data based on IP
        $response = Http::get("https://ipinfo.io/{$ip}/json");
        dd($response->json());

        if ($response->successful()) {
            $data = $response->json();
            dd($data);
            $location = explode(',', $data['loc']);

            return [
                'latitude' => $location[0],
                'longitude' => $location[1],
            ];
        }

        return null;
    }
}