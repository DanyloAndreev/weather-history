<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $minutes = 60;
        $forecast = Cache::remember('forecast1', $minutes, function () {
            Log::info("Weather call");
            $apiKey = config("ow.api_key");
            $lat = config("ow.lat_default");
            $lng = config("ow.lng_default");
            $baseUrl = config("ow.url_default");
            $url = "${baseUrl}lat=${lat}&lon=${lng}&appid=${apiKey}&units=metric&lang=en&exclude=hourly,dayli";

            Log::info($url);
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);
            if ($response->getStatusCode() == 200) {
                try {
                    $forecast = json_decode($response->getBody());
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }

            }

            return $forecast;
        });
        return view('forecastview', ["forecast" => $forecast]);
    }
}
