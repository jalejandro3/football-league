<?php

namespace App\Services;

use App\Models\Competition;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

interface TeamServiceInterface
{
    /**
     * Get all the team players in a competition by league.
     *
     * @param string $leagueCode League Code.
     * @return array
     * @throws ResourceNotFoundException
     */
    public function getTeamPlayerTotal(string $leagueCode): array;

    /**
     * Save teams from football-data into database.
     *
     * @param array $teams Teams from football-data.
     * @param Competition $competition Competition object.
     */
    public function saveTeams(array $teams, Competition $competition);
}
