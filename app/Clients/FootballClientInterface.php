<?php

namespace App\Clients;

interface FootballClientInterface
{
    /**
     * Execute a Football League request.
     *
     * @param string $request The Football League request endpoint.
     * @param string $requestType The Football League request type.
     *
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function exec(string $request, string $requestType);
}
