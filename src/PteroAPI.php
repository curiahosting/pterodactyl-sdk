<?php

namespace Curia\PteroSDK;

abstract class PteroAPI {
    
    protected $requester;
    protected $api_type;

    /**
     * Create new API instance
     *
     * @param string $base_url
     * @param string $api_key
     */
    public function __construct(string $base_url, string $api_key, string $api_type)
    {
        $this->requester = new Requester("$base_url/api/$api_type", $api_key);

        $this->api_type = $api_type;
    }
}
