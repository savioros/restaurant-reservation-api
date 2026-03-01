<?php

namespace App\Exceptions;

class InvalidTokenException extends DomainException
{
    protected int $statusCode = 401;

    public function __construct()
    {
        parent::__construct(
            'Invalid reservation token.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
