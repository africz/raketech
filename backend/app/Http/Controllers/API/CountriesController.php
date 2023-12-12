<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Gateways\RestCountries;
use Illuminate\Http\JsonResponse;
use App\ResponseTrait;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Config;


class CountriesController extends BaseController
{
    use ResponseTrait;

    public function list(RestCountries $restCountries,int $fromPage): JsonResponse
    {
        try {
            $data = $restCountries->getCountries();
            $retVal = $this->paginate($data, Config::get('app.restCountries.items_per_page'),$fromPage);
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
