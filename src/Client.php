<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi;

use JsonException;
use Redbitcz\MerkApi\Exception\AccessDeniedException;
use Redbitcz\MerkApi\Exception\ConnectionException;
use Redbitcz\MerkApi\Exception\InvalidRequestException;
use Redbitcz\MerkApi\Exception\NotFoundException;
use Redbitcz\MerkApi\Exception\ResponseErrorException;
use Redbitcz\MerkApi\Exception\UnauthorizedException;
use Redbitcz\MerkApi\Exception\UnexpectedResponseException;

class Client
{
    private const USER_AGENT = 'Merk.cz API client for PHP (https://github.com/redbitcz/merk-api-php/)';

    private Credentials $credentials;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @param array<string, string> $query
     */
    public function requestGet(string $urlPath, array $query = []): Response
    {
        return $this->processRequest('GET', $urlPath, [], $query);
    }

    /**
     * @param array<string, string> $query
     * @param array<int|string, mixed> $post
     */
    public function requestPost(string $urlPath, array $post = [], array $query = []): Response
    {
        return $this->processRequest('POST', $urlPath, $post, $query);
    }

    /**
     * @param array<int|string, mixed> $post
     * @param array<string, string> $query
     */
    public function requestPut(string $urlPath, array $post = [], array $query = []): Response
    {
        return $this->processRequest('PUT', $urlPath, $post, $query);
    }

    /**
     * @param array<int|string, mixed> $post
     * @param array<string, string> $query
     */
    public function requestDelete(string $urlPath, array $post = [], array $query = []): Response
    {
        return $this->processRequest('DELETE', $urlPath, $post, $query);
    }

    /**
     * @param array<int|string, mixed> $post
     * @param array<string, string> $query
     */
    private function processRequest(
        string $method,
        string $urlPath,
        array $post = [],
        array $query = []
    ): Response {
        $requestHeaders = [];
        $responseHeaders = [];

        if (count($query)) {
            $urlPath .= (strpos($urlPath, '?') === false ? '?' : '&') . http_build_query($query);
        }

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            [
                CURLOPT_URL => $this->credentials->getUrl() . '/' . $urlPath,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FAILONERROR => false,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_USERAGENT => self::USER_AGENT,
                CURLOPT_HEADERFUNCTION => static function ($curl, $header) use (&$responseHeaders) {
                    $parts = explode(':', $header, 2);
                    if (count($parts) === 2) {
                        $responseHeaders[strtolower(trim($parts[0]))][] = trim($parts[1]);
                    }
                    return strlen($header);
                },
            ]
        );

        if (count($post) && in_array(strtoupper($method), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $requestHeaders[] = 'Content-Type: application/json';
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->jsonEncode($post));
        }

        $requestHeaders[] = 'Authorization: Token ' . $this->credentials->getApiKey();

        curl_setopt($curl, CURLOPT_HTTPHEADER, $requestHeaders);

        $this->injectCaBundle($curl);

        $responseContent = curl_exec($curl);
        if ($error = curl_error($curl)) {
            $curl_errno = curl_errno($curl);
            curl_close($curl);
            throw new ConnectionException($error, $curl_errno);
        }

        $response = new Response((string)$responseContent, $responseHeaders, curl_getinfo($curl, CURLINFO_HTTP_CODE));
        curl_close($curl);

        if ($response->isEmpty()) {
            return $response;
        }

        if ($response->getStatusCode() >= 400) {
            throw $this->createResponseErrorException($response);
        }

        if ($response->isJson() === false) {
            $type = $response->getHeaderValue('content-type') ?? 'undefined';
            throw new UnexpectedResponseException(
                "Expected JSON response, got '{$type}' type response instead",
                0,
                $response
            );
        }

        return $response;
    }

    /**
     * @param array<int|string, mixed> $data
     */
    private function jsonEncode(array $data): string
    {
        try {
            return json_encode(
                $data,
                JSON_THROW_ON_ERROR
                | JSON_UNESCAPED_UNICODE
                | JSON_UNESCAPED_SLASHES
                | JSON_PRESERVE_ZERO_FRACTION
            );
        } catch (JsonException $e) {
            throw new InvalidRequestException('JSON: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    private function createResponseErrorException(Response $response): ResponseErrorException
    {
        $map = [
            401 => UnauthorizedException::class,
            403 => AccessDeniedException::class,
            404 => NotFoundException::class,
        ];
        $exceptionClass = $map[$response->getStatusCode()] ?? ResponseErrorException::class;

        return new $exceptionClass(
            "Server returns error status code: {$response->getStatusCode()}",
            $response->getStatusCode(),
            $response
        );
    }

    /**
     * @param resource|\CurlHandle $curl Curl resource
     * @noinspection PhpUndefinedClassInspection Package `CaBundle` may not exists - only suggested dependency
     * @noinspection PhpUndefinedNamespaceInspection Package `CaBundle` may not exists - only suggested dependency
     */
    private function injectCaBundle($curl): void
    {
        if (class_exists(Composer\CaBundle\CaBundle::class, true) === false) {
            return;
        }

        $caPathOrFile = Composer\CaBundle\CaBundle::getSystemCaRootBundlePath();
        if (is_dir($caPathOrFile)) {
            curl_setopt($curl, CURLOPT_CAPATH, $caPathOrFile);
        } else {
            curl_setopt($curl, CURLOPT_CAINFO, $caPathOrFile);
        }
    }
}
