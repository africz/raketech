<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\ResponseTrait;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Redirect;



class AuthController extends Controller
{
    use ResponseTrait;

    public function callback(Request $request, LoggerInterface $log): JsonResponse
    {
        try {
            $content = $request->all();
            $log->info('auth0.callback', ['request' => $content, 'method' => $request->method()]);
            return $this->errorResponse('error',$content);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


}
