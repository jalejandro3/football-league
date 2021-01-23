<?php

namespace App\Repositories;

use App\Models\Competition;

/**
 * Interface CompetitionRepositoryInterface.
 *
 * @package App\Repositories
 */
interface CompetitionRepositoryInterface
{
    /**
     * Create a competition
     *
     * @param $data
     * @return Competition
     */
    public function create(array $data): Competition;

    /**
     * Return a competition by league code.
     *
     * @param string $leagueCode League code.
     * @return Competition|null
     */
    public function findByLeagueCode(string $leagueCode): ?Competition;
}
