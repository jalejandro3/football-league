<?php

namespace App\Repositories;

use App\Models\League;

/**
 * Interface LeagueRepositoryInterface.
 *
 * @package App\Repositories
 */
interface LeagueRepositoryInterface
{
    /**
     * Update a league.
     *
     * @param int $id League id.
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Find a league record by its code.
     *
     * @param string $code League code.
     * @return League|null
     */
    public function findByCode(string $code): ?League;
}
