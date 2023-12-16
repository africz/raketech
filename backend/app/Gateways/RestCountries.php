<?php
namespace App\Gateways;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use App\ResponseTrait;
use App\Gateways\BaseGateway;


class RestCountries implements BaseGateway
{
    use ResponseTrait;
    public function getData(): array
    {
        $client = new Client();
        $apiUrl = Config::get('countries.api_all');
        $response = $client->get($apiUrl);
        $retrievedData = json_decode($response->getBody(), true);
        return $this->processor($retrievedData);
    }

    private function processor(array $countries): array
    {
        $retVal = [];
        foreach ($countries as $country) {
            array_push($retVal,
                [
                    'name' => $country['name']['official'],
                    'flag' => $country['flags']['png']
                ]);
        }
        return $retVal;
    }
}