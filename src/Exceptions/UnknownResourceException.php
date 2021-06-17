<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class UnknownResourceException extends Exception
{
    public function __construct(string $resource)
    {
        parent::__construct("Unknown resource, '$resource', if you are seeing this, please contact the package developer.");
    }
}
