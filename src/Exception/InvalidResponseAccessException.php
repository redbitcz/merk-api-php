<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi\Exception;

use Redbitcz\MerkApi\Response;
use Throwable;

class InvalidResponseAccessException extends LogicException
{
    private Response $response;

    public function __construct(string $message, Response $response, int $code = 0, ?Throwable $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
