<?php

namespace App\Exceptions;

class RestaurantDoesNotBelongToUserException extends DomainException
{
    protected int $statusCode = 403;

    public function __construct()
    {
        parent::__construct(
            'Restaurant does not belong to this user.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
