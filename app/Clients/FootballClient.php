<?php

namespace App\Clients;

use App\Exceptions\InputValidationException;
use Exception;

use Illuminate\Support\Facades\Log;

/**
 * Class FootballClient.
 *   Client to access to all the Football League endpoints and get their responses.
 *
 * @package App\Clients
 */
final class FootballClient extends Client implements FootballClientInterface
{
    /**
     * REQUEST RESET THRESHOLD
     */
    const REQUEST_RESET_THRESHOLD = 70;

    /**
     * @inheritDoc
     */
    public function exec(string $request, string $requestType)
    {
        $this->verifyRequestType($requestType);

        $this->setHeaders(['X-Auth-Token' => env('FOOTBALL_LEAGUE_TOKEN')]);

        $this->setBaseUrl(env('FOOTBALL_LEAGUE_BASE_URL'));

        $this->setUrl($request);

        try {
            $response = $this->getClient()->request($requestType, $this->getUrl(), $this->getHeaders());

            $this->setResponseHeaders($response->getHeaders());

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            //The client throws an exception about the remaining request number is zero (error code: 429), then
            //the process will sleep until we recover the maximum number of requests again, this will be in
            //X-RequestCounter-Reset seconds, taking back the last paused request.
            if ((int)$e->getCode() === 429) {
                //I'm having some issues about the X-RequestCounter-Reset header value, for some reason, not matter if
                //I use this value or a 60 seconds hardcore, I getting an 429 error 'Too many request', so I did this
                //workaround using more seconds before to resume the requests.
                sleep(self::REQUEST_RESET_THRESHOLD);

                $this->exec($request, $requestType);
            }

            throw new Exception($e->getMessage(), $e->getCode());
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
