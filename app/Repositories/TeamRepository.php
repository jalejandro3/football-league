<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TeamRepository.
 *   All the method implementations for the TeamRepositoryInterface.
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
    public function all(): Collection
    {
        return $this->team->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Team
    {
        $this->team->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $this->team->destroy($id);
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id): bool
    {
        return $this->team->whereId($id)->update($data);
    }
}
