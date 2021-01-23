<?php

namespace App\Repositories;

use App\Models\Competition;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CompetitionRepositoryInterface.
 *   Use to access to all the database methods for the Team.
 * @package App\Repositories
 */
interface CompetitionRepositoryInterface
{
    /**
     * Return a parameter collection
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Create a competition
     *
     * @param $data
     * @return Competition
     */
    public function create(array $data): Competition;

    /**
     * Update a competition
     *
     * @param array $data
     * @param int $id Competition id
     * @return bool
     */
    public function update(array $data, int $id): bool;

    /**
     * Return a competition by league code.
     *
     * @param string $leagueCode League code.
     * @return Competition|null
     */
    public function findByLeagueCode(string $leagueCode): ?Competition;
}
