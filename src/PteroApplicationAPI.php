<?php

namespace Curia\PteroSDK;

use Curia\PteroSDK\Resources\Location;
use Curia\PteroSDK\Resources\Nest;
use Curia\PteroSDK\Resources\Node;
use Curia\PteroSDK\Resources\Server;

class PteroApplicationAPI extends PteroAPI {

    /**
     * Create new Application API instance
     *
     * @param string $base_url
     * @param string $api_key
     */
    public function __construct(string $base_url, string $api_key)
    {
        parent::__construct($base_url, $api_key, 'application');
    }

    /**
     * Retrieves all servers, uses pagination
     *
     * @param int $page
     * @param array $filters
     * @param string $sort
     * @return array array of `Server` objects
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
    public function servers(int $page = 1, array $filters = [], array $includes = [], string $sort = null)
    {
        $response = $this->requester->get("/servers/", [
            'page' => $page,
            'sort' => $sort,
            'filter' => $filters,
            'include' => implode(',', $includes),
        ]);

        $parser = new ResponseParser();

        return $parser->parse($this->requester, $this->api_type, $response);
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
        $response = $this->requester->get("/servers/$server", [
            'include' => implode(',', $includes),
        ]);

        return new Server($this->requester, $this->api_type, $response);
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
        $response = $this->requester->get("/external/$external_id", [
            'include' => implode(',', $includes),
        ]);

        return new Server($this->requester, $this->api_type, $response);
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
        $response = $this->requester->get("/nodes/", [
            'page' => $page,
            'sort' => $sort,
            'filter' => $filters,
            'include' => implode(',', $includes),
        ]);

        $parser = new ResponseParser();

        return $parser->parse($this->requester, $this->api_type, $response);
    }

    /**
     * Retrieves the specified node
     *
     * @param int $node Node ID
     * @param array $includes
     * @return Node
     * 
     * ### Available Include Parameters
     * | Parameter      | Description                                               |
     * |----------------|-----------------------------------------------------------|
     * | `allocations`  | List of allocations added to the node                     |
     * | `location`     | Information about the location the node is assigned to    |
     * | `servers`      | List of servers on the node                               |
     */
    public function node(int $node, array $includes = [])
    {
        $response = $this->requester->get("/nodes/$node", [
            'include' => implode(',', $includes),
        ]);

        return new Node($this->requester, $this->api_type, $response);
    }

    /**
     * Retrieves all locations, uses pagination
     *
     * @param int $page
     * @param array $filters
     * @param array $includes
     * @param string $sort
     * @return array array of `Location` objects
     * 
     * ### Available Include Parameters
     * | Parameter  | Description                                   |
     * |------------|-----------------------------------------------|
     * | `nodes`    | List of allocations assigned to the server    |
     * | `servers`  | List of servers on the node                   |
     */
    public function locations(int $page = 1, array $filters = [], array $includes = [], string $sort = null)
    {
        $response = $this->requester->get("/locations/", [
            'page' => $page,
            'sort' => $sort,
            'filter' => $filters,
            'include' => implode(',', $includes),
        ]);

        $parser = new ResponseParser();

        return $parser->parse($this->requester, $this->api_type, $response);
    }

    /**
     * Retrieves the specified location
     *
     * @param int $location Location ID
     * @param array $includes
     * @return Location
     * 
     * ### Available Include Parameters
     * | Parameter  | Description                                   |
     * |------------|-----------------------------------------------|
     * | `nodes`    | List of allocations assigned to the server    |
     * | `servers`  | List of servers on the node                   |
     */
    public function location(int $location, array $includes = [])
    {
        $response = $this->requester->get("/locations/$location", [
            'include' => implode(',', $includes),
        ]);

        return new Location($this->requester, $this->api_type, $response);
    }

    /**
     * Retrieves all nests, uses pagination
     *
     * @param int $page
     * @param array $filters
     * @param array $includes
     * @param string $sort
     * @return array array of `Nest` objects
     * 
     * ### Available Include Parameters
     * | Parameter  | Description                   |
     * |------------|-------------------------------|
     * | `eggs`     | List of eggs in the nest      |
     * | `servers`  | List of servers in the nest   |
     */
    public function nests(int $page = 1, array $filters = [], array $includes = [], string $sort = null)
    {
        $response = $this->requester->get("/nests/", [
            'page' => $page,
            'sort' => $sort,
            'filter' => $filters,
            'include' => implode(',', $includes),
        ]);

        $parser = new ResponseParser();

        return $parser->parse($this->requester, $this->api_type, $response);
    }

    /**
     * Retrieves the specified nest
     *
     * @param int $nest Nest ID
     * @param array $includes
     * @return Nest
     * 
     * ### Available Include Parameters
     * | Parameter  | Description                   |
     * |------------|-------------------------------|
     * | `eggs`     | List of eggs in the nest      |
     * | `servers`  | List of servers in the nest   |
     */
    public function nest(int $nest, array $includes = [])
    {
        $response = $this->requester->get("/nests/$nest", [
            'include' => implode(',', $includes),
        ]);

        return new Nest($this->requester, $this->api_type, $response);
    }
}
