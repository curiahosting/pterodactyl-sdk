<?php

namespace Curia\PteroSDK;

use Curia\PteroSDK\Resources\Server;

class PteroClientAPI extends PteroAPI {
    
    /**
     * Create new Client API instance
     *
     * @param string $base_url
     * @param string $api_key
     */
    public function __construct(string $base_url, string $api_key)
    {
        parent::__construct($base_url, $api_key, 'client');
    }

    /**
     * Lists all servers
     *
     * @param string $server Server UUID or short UUID
     * @param array $includes
     * @return Server
     * 
     * ### Available Include Parameters
     * | Parameter  | Description                               |
     * |------------|-------------------------------------------|
     * | `egg`      | Information about the egg the server uses |
     * | `subusers` | List of subusers on the server            |
     */
    public function servers(int $page = 1, array $filters = [], array $includes = [], string $sort = null)
    {
        $response = $this->requester->get("/", [
            'page' => $page,
            'sort' => $sort,
            'filter' => $filters,
            'include' => implode(',', $includes),
        ]);

        $parser = new ResponseParser();

        return $parser->parse($this->requester, $this->api_type, $response);
    }

    /**
     * Retrieves information about the specified server
     *
     * @param string $server Server UUID or short UUID
     * @param array $includes
     * @return Server
     * 
     * ### Available Include Parameters
     * | Parameter  | Description                               |
     * |------------|-------------------------------------------|
     * | `egg`      | Information about the egg the server uses |
     * | `subusers` | List of subusers on the server            |
     */
    public function server(string $server, array $includes = [])
    {
        $response = $this->requester->get("/servers/$server/", [
            'include' => implode(',', $includes),
        ]);

        return new Server($this->requester, $this->api_type, $response);
    }

    public function server(string $server, array $includes = [])
    {
        $response = $this->requester->get("/servers/$server/", [
            'include' => implode(',', $includes),
        ]);

        return new Server($this->requester, $this->api_type, $response);
    }
}
