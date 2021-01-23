<?php

namespace App\Repositories;

use App\Models\Competition;

/**
 * Class CompetitionRepository
 *
 * @package App\Repositories
 */
final class CompetitionRepository implements CompetitionRepositoryInterface
{
    /**
     * @var Competition Competition object.
     */
    private Competition $competition;

    /**
     * TeamRepository constructor.
     *
     * @param Competition $competition
     */
    public function __construct(Competition $competition)
    {
        $this->competition = $competition;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Competition
    {
        return $this->competition->create($data);
    }

    /**
     * @inheritDoc
     */
    public function findByLeagueCode(string $leagueCode): ?Competition
    {
        return $this->competition->whereCode($leagueCode)->first();
    }
}
