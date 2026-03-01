<?php

namespace App\Exceptions;

use Exception;

abstract class DomainException extends Exception
{
    protected int $statusCode = 400;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
