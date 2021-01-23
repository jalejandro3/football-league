<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\PlayerRepositoryInterface;

final class PlayerService implements PlayerServiceInterface
{
    /**
     * @var PlayerRepositoryInterface
     */
    private PlayerRepositoryInterface $playerRepository;

    /**
     * PlayerService constructor.
     *
     * @param PlayerRepositoryInterface $playerRepository
     */
    public function __construct(
        PlayerRepositoryInterface $playerRepository
    )
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @inheritDoc
     */
    public function savePlayers($players, Team $team)
    {
        foreach ($players as $player) {
            $this->playerRepository->create([
                'team_id' => $team->id,
                'name' => $player->name,
                'position' => $player->position,
                'dateOfBirth' => $player->dateOfBirth,
                'countryOfBirth' => $player->countryOfBirth,
                'nationality' => $player->nationality
            ]);
        }
    }
}
