<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class BadRequestException extends Exception
{
    public function __construct(string $error)
    {
        parent::__construct("Request is invalid. Panel responded with:\n$error");
    }
}
