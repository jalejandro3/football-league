<?php

namespace App\Services;

use App\Models\Team;

interface PlayerServiceInterface
{
    /**
     * @param $players
     * @param Team $team
     */
    public function savePlayers($players, Team $team);
}
