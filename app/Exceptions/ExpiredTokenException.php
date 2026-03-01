<?php

namespace App\Exceptions;

class ExpiredTokenException extends DomainException
{
    protected int $statusCode = 401;

    public function __construct()
    {
        parent::__construct(
            'Reservation token expired.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
