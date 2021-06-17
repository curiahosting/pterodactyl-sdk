<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class UnauthorisedException extends Exception
{
    public function __construct()
    {
        parent::__construct("This action is unauthorised. Panel responding with '401 Unauthorized'.");
    }
}
