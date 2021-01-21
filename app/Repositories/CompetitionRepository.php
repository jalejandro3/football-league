<?php

namespace App\Repositories;

use App\Models\Competition;
use Illuminate\Database\Eloquent\Collection;

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
    public function all(): Collection
    {
        return $this->competition->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Competition
    {
        $this->competition->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $this->competition->destroy($id);
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id): bool
    {
        return $this->competition->whereId($id)->update($data);
    }
}
