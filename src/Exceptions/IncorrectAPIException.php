<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class IncorrectAPIException extends Exception
{
    public function __construct(string $api_type)
    {
        parent::__construct("This function is only allowed for API type, '{$api_type}'.");
    }
}
