<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\ResponseTrait;
use GuzzleHttp\Client;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Redirect;




class AuthController extends Controller
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
        return Redirect::to('/api');
    }

    public function auth()
    {
        $retVal = [];

        try {
            if (!$this->auth0->isAuthenticated()) {
                $result = $this->auth0->login();
                //return Redirect::to('/login');
            }

            if ($this->auth0->isAuthenticated()) {
                $retVal = $this->getToken();
                $token = $this->auth0->decode($retVal->access_token);
                return $this->successResponse($retVal);
            } else {
                return $this->errorResponse('Login required: http://be.localhost/login');
            }

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getToken()
    {
        $requestData = [
            'client_id' => 'XXpysmpkzE35d7eBF7y1zhHTRQ2G7rdW',
            'client_secret' => '5NWF1uFT3ZhbU_2COm6rK8xdEBtiGd2VFQ0BenHfslkD9fIuSfIB4tzutT1EFLT4',
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
