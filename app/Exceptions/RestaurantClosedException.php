<?php

namespace App\Exceptions;

class RestaurantClosedException extends DomainException
{
    protected int $statusCode = 409;

    public function __construct()
    {
        parent::__construct(
            'Restaurant closed on this day.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
