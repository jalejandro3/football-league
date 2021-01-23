<?php

namespace App\Services;

use App\Models\Team;

interface PlayerServiceInterface
{
    /**
     * Save a the players of a team.
     *
     * @param array $players Team players.
     * @param Team $team Team object.
     */
    public function savePlayers(array $players, Team $team);
}
