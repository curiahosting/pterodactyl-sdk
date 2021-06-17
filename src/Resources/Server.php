<?php

namespace Curia\PteroSDK\Resources;

class Server extends Resource
{
    /**
     * Updates the server details, overwrites self with response
     *
     * @param array $fields
     * @return void
     * 
     * ### Fields
     * | Name           | Required? | Type      | Description                                   |
     * |----------------|-----------|-----------|-----------------------------------------------|
     * | `name`         | required  | string    | Name for the server                           |
     * | `user`         | required  | number    | ID of the user which the server belongs to    |
     * | `external_id`  |           | string    | External ID of the server                     |
     * | `description`  |           | string    | Description of the server                     |
     * 
     * ### Example
     * ```php
     * $server->details([
     *     'name' => 'My Server',
     *     'user' => 12,
     *     'external_id' => 'remote_id_1',
     *     'description' => 'This server is great!',
     * ]);
     * 
     * # Only required fields
     * $server->details([
     *     'name' => 'My Server',
     *     'user' => 12,
     * ]);
     * ```
     */
    public function details(array $fields)
    {
        $this->validate_fields($fields, [
            'name' => ['required', 'string'],
            'user' => ['required', 'number'],
            'external_id' => ['string'],
            'description' => ['string'],
        ]);

        $this->requester->patch($this->base_path."/servers/{$this->id}/details", $fields);
    }

    /**
     * Updates the server build information, overwrites self with response
     *
     * @param array $fields
     * @return void
     * 
     * ### Fields
     * | Name                       | Required?                 | Type                              | Description                                                                                                                                                                                                                                           |
     * |----------------------------|---------------------------|-----------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
     * | allocation                 | required                  | number                            | ID of primary allocation                                                                                                                                                                                                                              |
     * | memory                     | required without limits   | number                            | The maximum amount of memory allowed for this container. Setting this to 0 will allow unlimited memory in a container.                                                                                                                                |
     * | swap                       | required without limits   | number                            | Setting this to 0 will disable swap space on this server. Setting to -1 will allow unlimited swap.                                                                                                                                                    |
     * | io                         | required without limits   | number                            | IO performance of this server relative to other running containers                                                                                                                                                                                    |
     * | cpu                        | required without limits   | number                            | Each physical core on the system is considered to be 100%. Setting this value to 0 will allow a server to use CPU time without restrictions.                                                                                                          |
     * | disk                       | required without limits   | number                            | This server will not be allowed to boot if it is using more than this amount of space. If a server goes over this limit while running it will be safely stopped and locked until enough space is available. Set to 0 to allow unlimited disk usage.   |
     * | threads                    |                           | number or string                  | Enter the specific CPU cores that this process can run on, or leave blank to allow all cores. This can be a single number, or a comma seperated list. Example: 0, 0-1,3, or 0,1,3,4.                                                                  |
     * | feature_limits             | required                  | object (use associative array)    |                                                                                                                                                                                                                                                       |
     * | feature_limits.databases   | present                   | number                            | The total number of databases a user is allowed to create for this server.                                                                                                                                                                            |
     * | feature_limits.backups     | present                   | number                            | The total number of allocations a user is allowed to create for this server.                                                                                                                                                                          |
     * | feature_limits.allocations |                           | number                            | The total number of allocations a user is allowed to create for this server.                                                                                                                                                                          |
     * 
     * Alternatively place `memory`, `swap`, `io`, `cpu`, and `disk` into an associative array, `limits`, in much the same way as `feature_limts`.
     * 
     * ### Example
     * ```php
     * $server->build([
     *     'allocation' => 3,
     *     'memory' => 1024,
     *     // Here until 'threads', can alternatively be placed in a 'limits' array
     *     'swap' => 0,
     *     'io' => 500,
     *     'cpu' => 0,
     *     'disk' => 1048576,
     *     'threads' => null, // or alternatively: 1 or "1-2,3,5-6"
     *     'feature_limits' => [
     *         'databases' => 1,
     *         'backups' => 6,
     *         'allocations' => 1,
     *     ],
     * ]);
     * 
     * # Only required fields
     * $server->build([
     *     'allocation' => 3,
     *     'limits' => [
     *         'memory' => 1024,
     *         'swap' => 0,
     *         'io' => 500,
     *         'cpu' => 0,
     *         'disk' => 1048576,
     *     ],
     *     'feature_limits' => [
     *         'databases' => 1,
     *         'backups' => 6,
     *     ],
     * ]);
     * ```
     */
    public function build(array $fields)
    {
        $this->validate_fields($fields, [
            'allocation' => ['required', 'number'],
            
            'limits' => ['object'],
            'limits.memory' =>  ['required_without:memory', 'number'],
            'limits.swap' =>    ['required_without:swap', 'number'],
            'limits.io' =>      ['required_without:io', 'number'],
            'limits.cpu' =>     ['required_without:cpu', 'number'],
            'limits.disk' =>    ['required_without:disk', 'number'],
            
            'memory' => ['required_without:limits.memory', 'number'],
            'swap' =>   ['required_without:limits.swap', 'number'],
            'io' =>     ['required_without:limits.io', 'number'],
            'cpu' =>    ['required_without:limits.cpu', 'number'],
            'disk' =>   ['required_without:limits.disk', 'number'],

            'threads' => ['number_or_string'],
            'feature_limits' => ['required', 'object'],
            'feature_limits.databases' =>   ['present', 'number'],
            'feature_limits.backups' =>     ['present', 'number'],
            'feature_limits.allocations' => ['number'],
        ]);

        $this->requester->patch($this->base_path."/servers/{$this->id}/build", $fields);
    }

    /**
     */
    /**
     * Updates the server startup information
     *
     * @param array $fields
     * @return void
     * 
     * ### Fields
     * | Name           | Required? | Type                              | Description                                                                       |
     * |----------------|-----------|-----------------------------------|-----------------------------------------------------------------------------------|
     * | startup        | required  | string                            | Edit your server's startup command here.                                          |
     * | environment    | present   | object (use associative array)    | Environment variables that the egg requires/supports                              |
     * | egg            | required  | number                            | ID of the egg to use                                                              |
     * | image          | required  | string                            | The Docker image to use for this server                                           |
     * | skip_scripts   | present   | required                          | If enabled, if the Egg has an install script, it will NOT be ran during install.  |
     * 
     * ### Example
     * ```php
     * $server->startup([
     *     'startup' => 'java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{SERVER_JARFILE}}',
     *     'environment' => [
     *         'SERVER_JARFILE' => 'server.jar',
     *     ],
     *     'egg' => 5,
     *     'image' => 'quay.io/pterodactyl/core:java',
     *     'skip_scripts' => false,
     * ]);
     * 
     * # Only required fields
     * $server->startup([
     *     'startup' => 'java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{SERVER_JARFILE}}',
     *     'environment' => null,
     *     'egg' => 5,
     *     'image' => 'quay.io/pterodactyl/core:java',
     *     'skip_scripts' => null,
     * ]);
     * ```
     */
    public function startup(array $fields)
    {
        $this->validate_fields($fields, [
            'startup' =>        ['required', 'string'],
            'environment' =>    ['present', 'object'],
            'egg' =>            ['required', 'number'],
            'image' =>          ['required', 'string'],
            'skip_scripts' =>   ['present', 'boolean'],
        ]);

        $this->requester->patch($this->base_path."/servers/{$this->id}/startup", $fields);
    }

    /**
     * Suspends the server
     *
     * @return void
     */
    public function suspend()
    {
        $this->requester->post($this->base_path."/servers/{$this->id}/suspend");
    }

    /**
     * Unsuspends the server
     *
     * @return void
     */
    public function unsuspend()
    {
        $this->requester->post($this->base_path."/servers/{$this->id}/unsuspend");
    }

    /**
     * Reinstalls the server
     *
     * @return void
     */
    public function reinstall()
    {
        $this->requester->post($this->base_path."/servers/{$this->id}/reinstall");
    }
}
