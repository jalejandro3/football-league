<?php

namespace App\Clients;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Interface FootballClientInterface
 *
 * @package App\Clients
 */
interface FootballClientInterface
{
    /**
     * Execute a Football League request.
     *
     * @param string $request The Football League request endpoint.
     * @param string $requestType The Football League request type.
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function exec(string $request, string $requestType);
}
