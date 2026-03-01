<?php

namespace App\Exceptions;

class UpdateRestaurantException extends DomainException
{
    protected int $statusCode = 500;

    public function __construct()
    {
        parent::__construct(
            'Error updating restaurant.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
