<?php

namespace App\Exceptions;

class CreateUserException extends DomainException
{
    protected int $statusCode = 500;

    public function __construct()
    {
        parent::__construct(
            'Error creating user.'
        );
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
