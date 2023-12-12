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

    // private function getUrlContent($url): string
    // {
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_FAILONERROR, true);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HEADER, 0);
    //     $tryToReconnect = Config::get('symbols.try_reconnect', 5);
    //     $recInterval = Config::get('symbols.reconnect_interval', 30);
    //     for ($i = 0; $i < $tryToReconnect; $i++) {
    //         $result = curl_exec($ch);
    //         if (!curl_errno($ch)) {
    //             $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //             if ($http_code === 200) {
    //                 break;
    //             }
    //         } else {
    //             Log::error(self::LID . __FUNCTION__ . ':' . curl_error($ch));
    //         }
    //         Log::info(self::LID . __FUNCTION__ . 'try to reconnect(' . ($i + 1) . '/' . $tryToReconnect . ') after ' . $recInterval . 'sec sleep');
    //         sleep($recInterval);
    //     }
    //     if ($i >= $tryToReconnect) {
    //         throw new \Exception('Reconnections are  failed.');
    //     }
    //     return $result;
    // }

}