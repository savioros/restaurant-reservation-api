<?php

namespace App\Exceptions;

class CreateReservationException extends DomainException
{
    protected int $statusCode = 500;

    public function __construct()
    {
        parent::__construct(
            'Error creating table.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
