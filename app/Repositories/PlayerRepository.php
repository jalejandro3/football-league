<?php

namespace App\Repositories;

use App\Models\Player;

/**
 * Class PlayerRepository.
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
    public function create(array $data): Player
    {
        return $this->player->create($data);
    }
}
