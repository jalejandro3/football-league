<?php

namespace App\Repositories;

use App\Models\Player;

/**
 * Interface PlayerRepositoryInterface.
 *
 * @package App\Repositories
 */
interface PlayerRepositoryInterface
{
    /**
     * Create a player
     *
     * @param array $data Player data.
     * @return Player
     */
    public function create(array $data): Player;
}
