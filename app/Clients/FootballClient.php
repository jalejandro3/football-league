<?php

namespace App\Clients;

use App\Exceptions\InputValidationException;

/**
 * Class FootballClient.
 *   Client to access to all the Football League endpoints and get their responses.
 *
 * @package App\Clients
 */
final class FootballClient extends Client implements FootballClientInterface
{
    const REQUEST_RESET_TRESHOLD = 60;

    /**
     * @inheritDoc
     */
    public function exec(string $request, string $requestType)
    {
        $this->verifyRequestType($requestType);

        $this->setHeaders([
            'X-Auth-Token' => env('FOOTBALL_LEAGUE_TOKEN')
        ]);

        $this->setBaseUrl(env('FOOTBALL_LEAGUE_BASE_URL'));

        $this->setUrl($request);

        $response = $this->getClient()->request($requestType, $this->getUrl(), $this->getHeaders());
        $responseHeaders = $response->getHeaders();

        //The client validate if the request counter is zero
        //then, the process will be sleep until we recover the time to reset the maximum number of requests again,
        //this will be in 60 seconds, taking back the last paused request.
        if ((int)$responseHeaders['X-Requests-Available-Minute'][0] === 1) {
            usleep((int)$responseHeaders['X-RequestCounter-Reset'][0] * 1000000);

            $this->exec($request, $requestType);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Verify if the request type was given.
     *
     * @param string $requestType Request type.
     * @throws InputValidationException
     */
    private function verifyRequestType(string $requestType)
    {
        if (is_null($requestType)) {
            throw new InputValidationException('Request type is required.');
        }
    }
}
