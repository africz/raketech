<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\JsonResponse;
use App\ResponseTrait;
use GuzzleHttp\Client;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;




class AuthController extends BaseController
{
    use ResponseTrait;

    private $client;
    private $auth0;
    protected LoggerInterface $log;

    public function __construct(LoggerInterface $logger)
    {
        $this->client = new Client();
        $config = new SdkConfiguration(
            strategy: SdkConfiguration::STRATEGY_API,
            domain: 'https://attilafricz.eu.auth0.com',
            audience: ['https://github.com/auth0/laravel-auth0']
        );

        $this->auth0 = new Auth0($config);
        $this->log = $logger;
    }

    public function callback(Request $request)
    {
        $this->log->info('callback', $request->toArray());
    }

    public function login(): JsonResponse
    {
        $retVal = [];

        try {
            $retVal = $this->getToken();
            $token = $this->auth0->decode($retVal->access_token);

            return $this->successResponse($retVal);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getToken()
    {
        $requestData = [
            'client_id' => '2fVoy8d9vhDnx5uDHHwW9kkCKHe0vS6b',
            'client_secret' => '_dJjwFblTCgSOuv1UNi_qniikVvT7D9I3C9zYjUbkOvN40TF2_gAJjQHP6s8HyE_',
            'audience' => 'https://github.com/auth0/laravel-auth0',
            'grant_type' => 'client_credentials'
        ];

        $res = $this->client->request('POST', 'https://attilafricz.eu.auth0.com/oauth/token',
            [
                'headers' => ['content-type' => 'application/json'],
                'body' => json_encode($requestData)]);
        //echo $res->getStatusCode();
        // "200"
        //$header= $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        //echo $res->getBody();
        //$body=$res->getBody();
        //echo $body;
        return json_decode($res->getBody());

    }





}
