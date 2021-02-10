<?php

namespace App\Services\VirusTotal;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class ApiClient
 */
class ApiClient
{
    const URL_API_BASIS = 'https://www.virustotal.com/api/v3/';

    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var Client
     */
    private $client;

    /**
     * VirusTotalAPI constructor.
     * @param string $apiKey
     * @param ClientInterface|null $client
     * @throws \Exception
     */
    public function __construct(string $apiKey, ClientInterface $client = null)
    {
        if (empty($apiKey)) {
            throw new \Exception(sprintf('Key %s is invalid', $this->apiKey));
        }

        $this->apiKey = $apiKey;

        if (empty($client)) {
            $this->client = new Client(array(
                'base_uri' => self::URL_API_BASIS,
                'headers'  => [
                    'x-apikey' => $this->apiKey
                ]
            ));
        }
    }

    /**
     * @param $response
     * @return mixed
     */
    protected function to_json($response)
    {
        return json_decode($response->getBody(), true);
    }

    /**
     * Util function to make post request
     *
     * @param string $endpoint
     * @param array $params
     * @param string $type form_params or multipart
     *
     * @return mixed
     *
     * @throws GuzzleException
     * @throws \Exception
     */
    protected function makePostRequest(string $endpoint, array $params, string $type = 'form_params')
    {
        try {

            $params[$type] = $params;

            $response = $this->client->post($endpoint, $params);
            $this->validateResponse($response->getStatusCode());
            return $this->to_json($response);
        } catch (ClientException $e) {

            $this->validateResponse($e->getResponse()->getStatusCode());
        }
    }

    /**
     * Util function to make get request
     *
     * @param string $endpoint
     * @param array $params
     *
     * @return mixed
     *
     * @throws GuzzleException
     * @throws \Exception
     */
    protected function makeGetRequest(string $endpoint, array $params)
    {
        try {
            $url = self::URL_API_BASIS . $endpoint . '?' . http_build_query($params);
            $response = $this->client->get($url);
            $this->validateResponse($response->getStatusCode());
           // return $response;
            return $this->to_json($response);
        } catch (ClientException $e) {
            dd($e->getMessage());

            $this->validateResponse($e->getResponse()->getStatusCode());
        }
    }

    /**
     * Validate response by looking up the http status code
     *
     * @param int $statusCode - http status code
     *
     * @throws \Exception
     */
    protected function validateResponse(int $statusCode)
    {
        switch ($statusCode) {
            case 204:
                throw new \Exception('Too many requests');
            case 403:
                throw new \Exception(sprintf('Key %s is invalid', $this->apiKey));
            default:
                return;
        }
    }
}
