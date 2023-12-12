<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Gateways\RestCountries;
use Illuminate\Http\JsonResponse;
use App\ResponseTrait;

class CountriesController extends BaseController
{
    use ResponseTrait;

    public function list(RestCountries $restCountries): JsonResponse
    {
        try {
            return $this->successResponse($restCountries->getCountries());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
