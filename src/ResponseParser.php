<?php

namespace Curia\PteroSDK;

use Curia\PteroSDK\Exceptions\UnknownResourceException;
use Curia\PteroSDK\Resources\Allocation;
use Curia\PteroSDK\Resources\Database;
use Curia\PteroSDK\Resources\Egg;
use Curia\PteroSDK\Resources\EggVariable;
use Curia\PteroSDK\Resources\Location;
use Curia\PteroSDK\Resources\Nest;
use Curia\PteroSDK\Resources\Node;
use Curia\PteroSDK\Resources\Server;
use Curia\PteroSDK\Resources\ServerVariable;
use Curia\PteroSDK\Resources\Stats;
use Curia\PteroSDK\Resources\Subuser;
use Curia\PteroSDK\Resources\User;

class ResponseParser
{
    /**
     * Parse response from panel
     *
     * @param Requester $requester
     * @param mixed $data
     * @return mixed
     */
    public function parse(Requester $requester, string $api_type, mixed $data)
    {
        // If $data is not an array, return $data
        if (!is_array($data)) {
            return $data;
        // $data is an array
        } else {
            // $data is an object
            if (key_exists('object', $data)) {
                // $data is a list of other objects
                if ($data['object'] == 'list') {
                    $list = array_map(function($item) use ($requester, $api_type) { return $this->parse($requester, $api_type, $item); }, $data['data']);
                    
                    $other_keys = array_diff(array_keys($data), ['object', 'data']);

                    foreach ($other_keys as $key) {
                        $list[$key] = $this->parse($requester, $api_type, $data[$key]);
                    }

                    return $list;
                }
                
                // Determine the type of resource of $data
                switch ($data['object']) {
                    case 'server':
                        return new Server($requester, $api_type, $data);
                    case 'allocation':
                        return new Allocation($requester, $api_type, $data);
                    case 'user':
                        return new User($requester, $api_type, $data);
                    case 'subuser':
                        return new Subuser($requester, $api_type, $data);
                    case 'nest':
                        return new Nest($requester, $api_type, $data);
                    case 'egg':
                        return new Egg($requester, $api_type, $data);
                    case 'server_variable':
                        return new ServerVariable($requester, $api_type, $data);
                    case 'location':
                        return new Location($requester, $api_type, $data);
                    case 'node':
                        return new Node($requester, $api_type, $data);
                    case 'database':
                        return new Database($requester, $api_type, $data);
                    case 'egg_variable':
                        return new EggVariable($requester, $api_type, $data);
                    case 'stats':
                        return new Stats($requester, $api_type, $data);
                    default:
                        throw new UnknownResourceException($data['object']);
                }
            } else {
                // $data is a simple array, in which case, parse all elements
                return array_map(function($item) use ($requester, $api_type) { return $this->parse($requester, $api_type, $item); }, $data);
            }
        }
    }
}
