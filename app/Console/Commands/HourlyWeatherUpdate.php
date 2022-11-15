<?php

namespace App\Console\Commands;

use App\Models\Region;
use App\Models\Temperature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HourlyWeatherUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:get_temperature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get an hourly a region temperature';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $minutes = 60;
        Cache::remember('forecast', $minutes, function () {
            Log::info("Weather call");

            $apiKey = config("ow.api_key");
            $lat = config("ow.lat_default");
            $lng = config("ow.lng_default");
            $baseUrl = config("ow.url_default");
            $url = "${baseUrl}lat=${lat}&lon=${lng}&appid=${apiKey}&units=metric&lang=en&exclude=hourly,dayli";

            Log::info($url);

            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);
            if ($response->getStatusCode() !== 200) {
                Log::info($response->getStatusCode());
                return false;
            }

            try {
                $forecast = json_decode($response->getBody());
                $region = Region::where('name', 'Kyiv')->first();

                if (!$region instanceof Region) return false;

                Temperature::create([
                    'region_id' => $region->id,
                    'temperature_c' => $forecast->current->temp
                ]);
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }

            return true;
        });

        return true;
    }
}
