<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class UnprocessableEntityException extends Exception
{
    public function __construct(string $error)
    {
        parent::__construct("Panel was unable to process supplied entity, responded with:\n$error");
    }
}
