<?php

namespace App\Services;

use App\Exceptions\ApplicationException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Interface LeagueServiceInterface
 *
 * @package App\Services
 */
interface LeagueServiceInterface
{
    /**
     * Import all the data from the Football League into the database.
     *
     * @param string $leagueCode League Code.
     * @return array
     * @throws ApplicationException
     * @throws Exception
     * @throws GuzzleException
     * @throws ResourceNotFoundException
     */
    public function importLeagueDataToDatabase(string $leagueCode): array;
}
