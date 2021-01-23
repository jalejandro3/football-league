<?php

namespace App\Clients;

use App\Exceptions\ClientException;
use App\Exceptions\InputValidationException;
use Exception;

/**
 * Class FootballClient.
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
        try {
            $this->verifyRequestType($requestType);

            $this->setHeaders(['X-Auth-Token' => env('FOOTBALL_LEAGUE_TOKEN')]);

            $this->setBaseUrl(env('FOOTBALL_LEAGUE_BASE_URL'));

            $this->setUrl($request);

            $response = $this->getClient()->request($requestType, $this->getUrl(), $this->getHeaders());

            $this->setResponseHeaders($response->getHeaders());

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            //The client throws an exception about the remaining request number is zero (error code: 429), then
            //the process will sleep until we recover the maximum number of requests again, this will be in
            //X-RequestCounter-Reset seconds, taking back the last paused request.
            if ((int)$e->getCode() === 429) {
                sleep((int)$this->getResponseHeaders()['X-RequestCounter-Reset'][0]);

                $this->exec($request, $requestType);
            } else {
                throw new ClientException($e->getMessage(), 504);
            }
        }
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
