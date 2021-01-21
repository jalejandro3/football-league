<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface PlayerRepositoryInterface.
 *   Use to access to all the database methods for the Player.
 * @package App\Repositories
 */
interface PlayerRepositoryInterface
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
     * @return Player
     */
    public function create(array $data): Player;

    /**
     * Update a player
     *
     * @param array $data
     * @param int $id Player id
     * @return bool
     */
    public function update(array $data, int $id): bool;

    /**
     * Delete a player
     *
     * @param int $id Player id
     * @return bool
     */
    public function delete(int $id): bool;
}
