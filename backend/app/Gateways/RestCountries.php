<?
namespace App\Gateways;

use GuzzleHttp\Client;
use Config;
use App\ResponseTrait;

class RestCountries
{
    use ResponseTrait;
    public function getCountries()
    {
        $client = new Client();
        $apiUrl = Config::get('app.restCountries.all');
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