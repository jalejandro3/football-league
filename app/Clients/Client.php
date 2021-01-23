<?php

namespace App\Clients;

use Exception;
use GuzzleHttp;

/**
 * Class Client
 *
 * @package App\Clients
 */
abstract class Client
{
    /**
     * @var GuzzleHttp\Client
     */
    private GuzzleHttp\Client $client;

    /**
     * @var null|string
     */
    private ?string $baseUrl;

    /**
     * @var array
     */
    private array $headers;

    /**
     * @var array
     */
    private array $responseHeaders;

    /**
     * @var null|string
     */
    private ?string $url;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(['verify' => false]);
        $this->headers = [];
        $this->responseHeaders = [];
    }

    /**
     * Set the client base url
     *
     * @param string $baseUrl Client base url.
     * @return void
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Get the client url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the client object.
     *
     * @return GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Get the request headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the client headers.
     *
     * @param array $headerOptions
     */
    public function setHeaders(array $headerOptions)
    {
        $this->headers = [
            'headers' => $headerOptions
        ];
    }

    /**
     * Get the response headers
     *
     * @return array
     */
    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }

    /**
     * Set the response headers.
     *
     * @param array $headers
     */
    public function setResponseHeaders(array $headers)
    {
        $this->responseHeaders = $headers;
    }

    /**
     * Set the client url.
     *
     * @param string $request Request data to set the client url.
     * @throws Exception
     */
    public function setUrl(string $request)
    {
        $this->isBaseUrlEmpty();

        $this->url = $this->baseUrl . $request;
    }

    /**
     * Verify if the base url is not configured.
     *
     * @throws Exception
     */
    private function isBaseUrlEmpty()
    {
        if (is_null($this->baseUrl)) {
            throw new Exception("Base URL is not configured.");
        }
    }
}
