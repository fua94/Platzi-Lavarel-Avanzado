<?php

namespace App\Exceptions;

use Exception;

class InvalidScoreException extends Exception
{
    public function __construct($from, $to)
    {
        $this->message = trans("rating.invalidScore", [
            "from" => $from,
            "to" => $to
        ]);
    }
}
