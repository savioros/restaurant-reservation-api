<?php

namespace App\Exceptions;

class InvalidCredentialsException extends DomainException
{
    protected int $statusCode = 401;

    public function __construct()
    {
        parent::__construct(
            'Invalid credentials provided.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
