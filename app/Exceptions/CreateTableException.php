<?php

namespace App\Exceptions;

class CreateTableException extends DomainException
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
