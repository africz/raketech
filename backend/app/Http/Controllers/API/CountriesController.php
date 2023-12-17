<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Gateways\RestCountries;
use Illuminate\Http\JsonResponse;
use App\ResponseTrait;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use App\Cache\RedisCache;


class CountriesController extends Controller
{
    use ResponseTrait;

    public function list(RestCountries $restCountries): JsonResponse
    {
        try {
            $cache = new RedisCache();
            $data = $cache->get(Config::get('countries.redis_key'));
            if (empty($data)) {
                $data = $restCountries->getData();
                $cache->set(Config::get('countries.redis_key'), $data,
                    Config::get('countries.redis_cache_expire'));
            }
            $retVal = $this->paginate($data, Config::get('countries.items_per_page'));
            return $this->successResponse($retVal);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }



}
