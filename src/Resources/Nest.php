<?php

namespace Curia\PteroSDK\Resources;

use Curia\PteroSDK\ResponseParser;

class Nest extends Resource
{
    ///////////////////////////////////////////
    //////// APPLICATION API FUNCTIONS ////////
    ///////////////////////////////////////////

    /**
     * `[APPLICATION API]` Retrieves a list of eggs, uses pagination.
     *
     * @param int $page
     * @param array $filters
     * @param array $includes
     * @param string $sort
     * @return array array of `Egg` objects
     * 
     * ### Available Include Parameters
     * | Parameter      | Description                                   |
     * |----------------|-----------------------------------------------|
     * | `nest`         | Information about the nest that owns the egg  |
     * | `servers`      | List of servers using the egg                 |
     * | `config`       | Config options of the egg                     |
     * | `script`       | Egg install script                            |
     * | `variables`    | List of egg variables                         |
     */
    public function eggs(int $page = 1, array $filters = [], array $includes = [], string $sort = null)
    {
        $this->force_api_type('application');

        $response = $this->requester->get("/nests/{$this->id}/eggs/", [
            'page' => $page,
            'sort' => $sort,
            'filter' => $filters,
            'include' => implode(',', $includes),
        ]);

        $parser = new ResponseParser();

        return $parser->parse($this->requester, $this->api_type, $response);
    }

    /**
     * `[APPLICATION API]` Retrieves the specified egg.
     *
     * @param int $egg Egg ID
     * @param array $includes
     * @return Egg
     * 
     * ### Available Include Parameters
     * | Parameter      | Description                                   |
     * |----------------|-----------------------------------------------|
     * | `nest`         | Information about the nest that owns the egg  |
     * | `servers`      | List of servers using the egg                 |
     * | `config`       | Config options of the egg                     |
     * | `script`       | Egg install script                            |
     * | `variables`    | List of egg variables                         |
     */
    public function egg(int $egg, array $includes = [])
    {
        $this->force_api_type('application');

        $response = $this->requester->get("/nests/{$this->id}/eggs/{$egg}", [
            'include' => implode(',', $includes),
        ]);

        return new Egg($this->requester, $this->api_type, $response);
    }
}
