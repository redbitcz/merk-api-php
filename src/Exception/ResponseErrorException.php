<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi\Exception;

use Redbitcz\MerkApi\Response\IResponse;
use Throwable;

class ResponseErrorException extends NetworkException
{
    private IResponse $response;

    public function __construct(string $message, int $code, IResponse $response, ?Throwable $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): IResponse
    {
        return $this->response;
    }
}
