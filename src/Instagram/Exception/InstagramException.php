<?php

namespace Meta\InstagramSDK\Exception;

use Exception;
use Throwable;

class InstagramException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(json_decode($message), $code, $previous);
    }
}