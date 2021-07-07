<?php

namespace Curia\PteroSDK\Resources;

class Node extends Resource
{
    ///////////////////////////////////////////
    //////// APPLICATION API FUNCTIONS ////////
    ///////////////////////////////////////////

    /**
     * `[APPLICATION API]` Displays the Wings configuration.
     *
     * @return void
     */
    public function configuration()
    {
        $this->force_api_type('application');

        $this->requester->get("/nodes/{$this->id}/configuration");
    }

    /**
     * `[APPLICATION API]` List allocations added to the node.
     *
     * @param array $includes
     * @return void
     * 
     * ### Available Include Parameters
     * | Parameter  | Description                                               |
     * |------------|-----------------------------------------------------------|
     * | `node`     | Information about the node the allocation belongs to      |
     * | `server`   | Information about the server the allocation belongs to    |
     */
    public function allocations(array $includes = [])
    {
        $response = $this->requester->get("/nodes/{$this->id}/allocations/", [
            'include' => implode(',', $includes),
        ]);

        return new Node($this->requester, $this->api_type, $response);
    }
}
