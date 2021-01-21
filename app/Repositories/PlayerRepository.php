<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PlayerRepository.
 *   All the method implementations for the PlayerRepositoryInterface.
 *
 * @package App\Repositories
 */
final class PlayerRepository implements PlayerRepositoryInterface
{
    /**
     * @var Player Player object.
     */
    private Player $player;

    /**
     * TeamRepository constructor.
     *
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->player->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Player
    {
        $this->player->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $this->player->destroy($id);
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id): bool
    {
        return $this->player->whereId($id)->update($data);
    }
}
