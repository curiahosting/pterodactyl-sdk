<?php

namespace Curia\PteroSDK;

use Curia\PteroSDK\Exceptions\BadRequestException;
use Curia\PteroSDK\Exceptions\InternalServerException;
use Curia\PteroSDK\Exceptions\UnauthorisedException;
use Curia\PteroSDK\Exceptions\UnprocessableEntityException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Requester {
    /**
     * Panel Base URL
     * 
     * @var string
     */
    public $base_url;

    /**
     * Panel API Key
     * 
     * @var string
     */
    public $api_key;

    /**
     * Guzzle HTTP Client
     * 
     * @var Client
     */
    private $client;

    public function __construct(string $base_url, string $api_key)
    {
        $this->base_url = $base_url;
        $this->api_key = $api_key;
        
        $this->client = new Client();
    }

    public function request(string $method, string $url, array $query = [], array $body = null)
    {
        try {
            $response = $this->client->request($method, $this->base_url.$url, [
                'query' => $query,
                'body' => json_encode($body),
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->api_key,
                ],
            ]);

            return $response;
        } catch (ClientException|ServerException $e) {
            $response = $e->getResponse();
            switch ($response->getStatusCode()) {
                case 400:
                    $error_str = json_encode(json_decode($response->getBody()->getContents()), JSON_PRETTY_PRINT);
                    throw new BadRequestException($error_str);
                case 401:
                    throw new UnauthorisedException();
                case 422:
                    $error_str = json_encode(json_decode($response->getBody()->getContents()), JSON_PRETTY_PRINT);
                    throw new UnprocessableEntityException($error_str);
                case 500:
                    $error_str = json_encode(json_decode($response->getBody()->getContents()), JSON_PRETTY_PRINT);
                    throw new InternalServerException($error_str);
                default:
                    throw $e;
            }
        }
    }

    public function get(string $url, array $query = [])
    {
        return json_decode($this->request('GET', $url, $query)->getBody(), true);
    }

    public function patch(string $url/*, array $query = []*/, array $body=[])
    {
        return json_decode($this->request('PATCH', $url, /*$query*/[], $body)->getBody(), true);
    }

    public function post(string $url/*, array $query = []*/, array $body=[])
    {
        return json_decode($this->request('POST', $url, /*$query*/[], $body)->getBody(), true);
    }
    
}
