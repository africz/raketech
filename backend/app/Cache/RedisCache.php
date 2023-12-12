<?php
namespace App\Cache;

use Config;

use Illuminate\Support\Facades\Redis;

class RedisCache
{

    public function set(string $key, array $data, int $expire = 3600): void
    {
        Redis::setex($key, $expire, json_encode($data));
    }
    public function get(string $key): null|array
    {
        return json_decode(Redis::get($key));
    }

}
