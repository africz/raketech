<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Gateways\RestCountries;
use Illuminate\Http\JsonResponse;

class CountriesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(RestCountries $restCountries): JsonResponse
    {
        return $this->sendResponse($restCountries->ping(), 'OK');
    }

}
