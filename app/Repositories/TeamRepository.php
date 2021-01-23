<?php

namespace App\Repositories;

use App\Models\Team;

/**
 * Class TeamRepository.
 *
 * @package App\Repositories
 */
final class TeamRepository implements TeamRepositoryInterface
{
    /**
     * @var Team Team object.
     */
    private Team $team;

    /**
     * TeamRepository constructor.
     *
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Team
    {
        return $this->team->create($data);
    }
}
