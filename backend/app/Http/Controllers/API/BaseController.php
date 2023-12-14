<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller as Controller;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    protected LoggerInterface $log;
    public function __construct(
        LoggerInterface $logger,
    ) {
        $this->log = $logger;
    }

}
