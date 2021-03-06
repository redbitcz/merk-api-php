<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi\Exception;

use Redbitcz\MerkApi\Response;
use Throwable;

class ResponseException extends RuntimeException
{
    private Response $response;

    public function __construct(string $message, int $code, Response $response, ?Throwable $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
