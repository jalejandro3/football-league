<?php

namespace App\Services;

interface ImporterServiceInterface
{
    /**
     * Import all the data from the Football League into the database.
     *
     * @param string $leagueCode League Code.
     * @return array
     */
    public function importLeagueDataToDatabase(string $leagueCode): array;
}
