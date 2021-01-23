<?php

namespace App\Repositories;

use App\Models\League;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface LeagueRepositoryInterface.
 *
 * @package App\Repositories
 */
interface LeagueRepositoryInterface
{
    /**
     * Return all the leagues for the TIER1.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Update a league.
     *
     * @param int $id League id.
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Return a league record by its code.
     *
     * @return League
     */
    public function findByCode(string $code): ?League;
}
