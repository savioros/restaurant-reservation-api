<?php

namespace App\Exceptions;

class UserAreProhibitedCreateOrModifyingThirdpartyRestaurantException extends DomainException
{
    protected int $statusCode = 403;

    public function __construct()
    {
        parent::__construct(
            'You do not have permission to create or modify this restaurant\'s information.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
