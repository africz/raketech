<?php
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'api_all' => env('API_REST_COUNTRIES_ALL'),
    'items_per_page' => env('API_ITEMS_PER_PAGE', 25),
    'redis_key' => env('API_REDIS_KEY', 'REST_COUNTRIES'),
    'redis_cache_expire' => env('API_REDIS_CACHE_EXPIRE', 3600),
    // 'try_reconnect' => env('ALPHA_VANTAGE_API_TRY_TO_RECONNECT'),
    // 'reconnect_interval' => env('ALPHA_VANTAGE_API_RECONNECT_INTERVAL'),


];

