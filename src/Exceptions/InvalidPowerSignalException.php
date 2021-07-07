<?php

namespace Curia\PteroSDK\Exceptions;

use Exception;

class InvalidPowerSignalException extends Exception
{
    public function __construct(string $signal, array $power_signals)
    {
        parent::__construct("Invalid power signal, '$signal', should be either '".implode("', '", array_slice($power_signals, 0, -1))."', or '".$power_signals[count($power_signals)-1]."'.");
    }
}
