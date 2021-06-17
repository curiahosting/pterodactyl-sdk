<?php

namespace Curia\PteroSDK;

use Curia\PteroSDK\Resources\Server;

class ApplicationAPI {
    
    private $requester;

    private $base_path;

    /**
     * Create new Application API instance
     *
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->requester = $requester;

        $this->base_path = '/api/application';
    }

    /**
     * Retrieves all servers, uses pagination
     *
     * @param int $page
     * @param array $filters
     * @param string $sort
     * @return array array of `Server` objects
     */
    public function servers(int $page = 1, array $filters = [], string $sort = null)
    {
        $response = $this->requester->get($this->base_path."/servers/", [
            'page' => $page,
            'sort' => $sort,
            'filter' => $filters,
        ]);

        $parser = new ResponseParser();

        return $parser->parse($this->requester, $this->base_path, $response);
    }

    /**
     * Retrieves the specified server
     *
     * @param int $server Server ID
     * @param array $includes
     * @return Server
     * 
     * ### Available Include Parameters
     * | Parameter      | Description                                   |
     * |----------------|-----------------------------------------------|
     * | `allocations`  | List of allocations assigned to the server    |
     * | `user`         | Information about the server owner            |
     * | `subusers`     | List of users added to the server             |
     * | `pack`         | Information about the server pack             |
     * | `nest`         | Information about the server's egg nest       |
     * | `egg`          | Information about the server's egg            |
     * | `variables`    | List of server variables                      |
     * | `location`     | Information about server's node location      |
     * | `node`         | Information about the server's node           |
     * | `databases`    | List of databases on the server               |
     */
    public function server(int $server, array $includes = [])
    {
        $response = $this->requester->get($this->base_path."/servers/$server", [
            'include' => implode(',', $includes),
        ]);

        return new Server($this->requester, $this->base_path, $response);
    }

    /**
     * Retrieves a server by its external ID
     *
     * @param string $external_id External ID
     * @param array $includes
     * @return Server
     * 
     * ### Available Include Parameters
     * | Parameter      | Description                                   |
     * |----------------|-----------------------------------------------|
     * | `allocations`  | List of allocations assigned to the server    |
     * | `user`         | Information about the server owner            |
     * | `subusers`     | List of users added to the server             |
     * | `pack`         | Information about the server pack             |
     * | `nest`         | Information about the server's egg nest       |
     * | `egg`          | Information about the server's egg            |
     * | `variables`    | List of server variables                      |
     * | `location`     | Information about server's node location      |
     * | `node`         | Information about the server's node           |
     * | `databases`    | List of databases on the server               |
     */
    public function external(string $external_id, array $includes = [])
    {
        $response = $this->requester->get($this->base_path."/external/$external_id", [
            'include' => implode(',', $includes),
        ]);

        return new Server($this->requester, $this->base_path, $response);
    }

    /**
     * Retrieves all nodes, uses pagination
     *
     * @param int $page
     * @param array $filters
     * @param array $includes
     * @param string $sort
     * @return array array of `Node` objects
     * 
     * ### Available Include Parameters
     * | Parameter      | Description                                               |
     * |----------------|-----------------------------------------------------------|
     * | `allocations`  | List of allocations assigned to the server                |
     * | `location`     | Information about the location the node is assigned to    |
     * | `servers `     | List of servers on the node                               |
     */
    public function nodes(int $page = 1, array $filters = [], array $includes = [], string $sort = null)
    {
        $response = $this->requester->get($this->base_path."/nodes/", [
            'page' => $page,
            'sort' => $sort,
            'filter' => $filters,
            'include' => implode(',', $includes),
        ]);

        $parser = new ResponseParser();

        return $parser->parse($this->requester, $this->base_path, $response);
    }
}
