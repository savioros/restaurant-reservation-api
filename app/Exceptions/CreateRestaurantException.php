<?php

namespace App\Exceptions;

class CreateRestaurantException extends DomainException
{
    protected int $statusCode = 500;

    public function __construct()
    {
        parent::__construct(
            'Error creating restaurant.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
