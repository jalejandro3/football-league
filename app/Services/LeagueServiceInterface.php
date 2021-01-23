<?php

namespace App\Services;

use App\Exceptions\ApplicationException;
use App\Exceptions\ResourceNotFoundException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

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

    /**
     * Get all the team players in a competition by league.
     *
     * @param string $leagueCode League Code.
     * @return array
     * @throws ResourceNotFoundException
     */
    public function getTeamPlayerTotal(string $leagueCode): array;
}
