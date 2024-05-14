<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class RecordConflictException extends Exception implements HttpExceptionInterface
{
    use Httpable;

    protected $message = 'The record was updated since reading.';
    protected $statusCode = Response::HTTP_CONFLICT;
}
