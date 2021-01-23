<?php

use App\Models\Competition;
use Illuminate\Support\Arr;

if (! function_exists('get_competition_team_ids')) {
    /**
     * Get competition team ids to validate if it is necessary import its players.
     *
     * @param Competition $competition Competition object.
     * @return array
     */
    function get_competition_team_ids(Competition $competition): array
    {
        return Arr::pluck($competition->teams, "id");
    }
}
