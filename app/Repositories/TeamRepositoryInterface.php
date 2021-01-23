<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface TeamRepositoryInterface.
 *   Use to access to all the database methods for the Team.
 * @package App\Repositories
 */
interface TeamRepositoryInterface
{
    /**
     * Return a parameter collection
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Create a team
     *
     * @param $data
     * @return Team
     */
    public function create(array $data): Team;

    /**
     * Update a team
     *
     * @param int $id Team id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;
}
