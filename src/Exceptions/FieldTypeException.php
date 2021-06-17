<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class FieldTypeException extends Exception
{
    public function __construct(string $field, string $type)
    {
        parent::__construct("The field '$field' is should be of type '$type'.");
    }
}
