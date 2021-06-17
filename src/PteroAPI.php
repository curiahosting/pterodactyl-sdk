<?php

namespace Curia\PteroSDK;

use Curia\PteroSDK\Exceptions\InvalidApiTypeException;
use Curia\PteroSDK\Exceptions\UnauthorisedException;
use GuzzleHttp\Client;

class PteroAPI {
    
    /**
     * Requester Instance
     * 
     * @var Requester
     */
    private $requester;

    /**
     * ClientAPI instance, used to access panel client API
     *
     * @var ClientAPI
     */
    public $client;

    /**
     * ApplicationAPI instance, used to access panel application API
     *
     * @var ApplicationAPI
     */
    public $application;

    /**
     * Create new API instance
     *
     * @param string $base_url  Panel Base URL
     * @param string $api_key   Panel API Key
     * @param string $api_type  API Type, 'application' or 'client' 
     */
    public function __construct(string $base_url, string $api_key)
    {
        $this->requester = new Requester($base_url, $api_key);

        $this->client = new ClientAPI($this->requester);
        $this->application = new ApplicationAPI($this->requester);
    }
    
}
