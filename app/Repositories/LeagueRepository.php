<?php

namespace App\Repositories;

use App\Models\League;

/**
 * Class LeagueRepository
 *
 * @package App\Repositories
 */
final class LeagueRepository implements LeagueRepositoryInterface
{
    /**
     * @var League League.
     */
    private League $league;

    /**
     * LeagueRepository constructor.
     *
     * @param League $league League object.
     */
    public function __construct(League $league)
    {
        $this->league = $league;
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data): bool
    {
        return $this->league->whereId($id)->update($data);
    }

    /**
     * @inheritDoc
     */
    public function findByCode(string $code): ?League
    {
        return $this->league->whereCode($code)->first();
    }
}
