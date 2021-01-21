<?php

namespace App\Clients;

use Exception;
use GuzzleHttp;

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

    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the client headers
     *
     * @param array $headerOptions
     */
    public function setHeaders(array $headerOptions)
    {
        $this->headers[] = $headerOptions;
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
