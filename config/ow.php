<?php
return [
    'api_key' => env('OW_API_KEY', "NOAPPID"),
    'lat_default' => env('OW_LAT_DEFAULT', 0),
    'lng_default' => env('OW_LNG_DEFAULT', 0),
    'url_default' => env('OW_URL_DEFAULT', 'NOURL'),
    'token' => env('API_TEMPERATURE_TOKEN', 'NOTOKEN')
];
