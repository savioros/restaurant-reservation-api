<?php

namespace App\Exceptions;

class ReservationConflictException extends DomainException
{
    protected int $statusCode = 409;

    public function __construct()
    {
        parent::__construct(
            'Table already reserved at this time.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
