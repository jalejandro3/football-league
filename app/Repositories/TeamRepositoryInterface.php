<?php

namespace App\Repositories;

use App\Models\Team;

/**
 * Interface TeamRepositoryInterface.
 *   Use to access to all the database methods for the Team.
 * @package App\Repositories
 */
interface TeamRepositoryInterface
{
    /**
     * Create a team
     *
     * @param $data
     * @return Team
     */
    public function create(array $data): Team;
}
