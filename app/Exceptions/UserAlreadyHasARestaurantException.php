<?php

namespace App\Exceptions;

class UserAlreadyHasARestaurantException extends DomainException
{
    protected int $statusCode = 409;

    public function __construct()
    {
        parent::__construct(
            'User already has a restaurant.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
