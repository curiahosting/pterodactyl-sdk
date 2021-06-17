<?php

namespace Curia\PteroSDK;

class ClientAPI {
    
    private $requester;

    /**
     * Create new Client API instance
     *
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->requester = $requester;

        $this->base_path = '/api/client';
    }
}
