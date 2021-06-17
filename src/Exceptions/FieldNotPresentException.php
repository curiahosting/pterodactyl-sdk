<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class FieldNotPresentException extends Exception
{
    public function __construct(string $field)
    {
        parent::__construct("The field '$field' should be present, but was absent.");
    }
}
