<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class CountriesControllerTest extends TestCase
{

    private const TEST_TOKEN_URL = 'https://attilafricz.eu.auth0.com/oauth/token';
    private const APP_URL = 'http://be.localhost';

    /**
     * A basic test CountriesController.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_api_countries_list_is_on_protected_path()
    {
        $response = $this->get('/api/countries/list');

        $response->assertStatus(302);
    }

    //retrieved token not get authenticated
    public function xtest_api_countries_list()
    {
        $accessToken = $this->getTestToken()['access_token'];
        //dd($accessToken);
        $response = $this->get('/api/countries/list',
             ['Accept' => 'application/json',
              'Authorization' => 'Bearer ' . $accessToken
             ]);
        //  //dd($response);
        // $apiUrl=self::APP_URL.'/api/countries/list';
        // $response = Http::withHeaders(
        //     ['Accept' => 'application/json',
        //         'Authorization' => 'Bearer ' . $accessToken
        //     ]
        // )->get($apiUrl);

        //$data = json_decode($response, true);
        dd($response);


    }

    private function getTestToken()
    {
        $response = Http::withHeaders(
            ['content-type' => 'application/json']
        )->post(self::TEST_TOKEN_URL,
                [
                    'client_id' => 'XXpysmpkzE35d7eBF7y1zhHTRQ2G7rdW',
                    'client_secret' => '5NWF1uFT3ZhbU_2COm6rK8xdEBtiGd2VFQ0BenHfslkD9fIuSfIB4tzutT1EFLT4',
                    'audience' => 'https://github.com/auth0/laravel-auth0',
                    'grant_type' => 'client_credentials'
                ]);

        return json_decode($response, true);

    }


}
