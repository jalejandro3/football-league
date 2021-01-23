<?php

namespace App\Services;

use App\Models\Competition;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

interface CompetitionServiceInterface
{
    /**
     * Get a competition given a league code.
     *
     * @param string $leagueCode League code.
     * @return Competition|null
     */
    public function getCompetitionByLeagueCode(string $leagueCode): ?Competition;

    /**
     * Validate if there is a competition with a valid league code associated.
     *
     * @param string $leagueCode League code.
     * @throws ResourceNotFoundException
     */
    public function invalidCompetitionCode(string $leagueCode);

    /**
     * Save an return a competition.
     *
     * @param $competition
     * @return Competition
     */
    public function saveCompetition($competition): Competition;
}
