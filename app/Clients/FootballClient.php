<?php

namespace App\Clients;

/**
 * Class FootballClient.
 *   Client to access to all the Football League endpoints and get their responses.
 *
 * @package App\Clients
 */
final class FootballClient extends Client implements FootballClientInterface
{
    /**
     * @inheritDoc
     */
    public function exec(string $request, string $requestType)
    {
        $this->setHeaders([
            'headers' => [
                'X-Auth-Token' => env('FOOTBALL_LEAGUE_TOKEN')
            ]
        ]);

        $this->setBaseUrl(env('FOOTBALL_LEAGUE_BASE_URL'));

        $this->setUrl($request);

        $res = $this->getClient()->request($requestType, $this->getUrl(), $this->getHeaders());

        return json_decode($res->getBody()->getContents());
    }
}
