<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class FieldRequiredException extends Exception
{
    public function __construct(string $field)
    {
        parent::__construct("The field '$field' is required, but was absent or empty.");
    }
}
