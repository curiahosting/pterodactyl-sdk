<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class BadGatewayException extends Exception
{
    public function __construct(string $error)
    {
        parent::__construct("Bad gateway, panel responded with:\n$error");
    }
}
