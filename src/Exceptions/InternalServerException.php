<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class InternalServerException extends Exception
{
    public function __construct(string $error)
    {
        parent::__construct("Panel failed to process request, responded with:\n$error");
    }
}
