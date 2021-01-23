<?php

namespace App\Services;

use App\Models\Competition;
use App\Repositories\CompetitionRepositoryInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

final class CompetitionService implements CompetitionServiceInterface
{
    /**
     * @var CompetitionRepositoryInterface
     */
    private CompetitionRepositoryInterface $competitionRepository;

    /**
     * CompetitionService constructor.
     *
     * @param CompetitionRepositoryInterface $competitionRepository
     */
    public function __construct(
        CompetitionRepositoryInterface $competitionRepository
    ) {
        $this->competitionRepository = $competitionRepository;
    }

    /**
     * @inheritDoc
     */
    public function saveCompetition($competition): Competition
    {
        return $this->competitionRepository->create([
            'name' => $competition->name,
            'code' => $competition->code,
            'areaName' => $competition->area->name
        ]);
    }

    /**
     * Validate if there is a competition with a valid league code associated.
     *
     * @param string $leagueCode League code.
     * @throws ResourceNotFoundException
     */
    public function invalidCompetitionCode(string $leagueCode)
    {
        if (!$this->competitionRepository->findByLeagueCode($leagueCode)) {
            throw new ResourceNotFoundException('Not found', 404);
        }
    }

    /**
     * @inheritDoc
     */
    public function getCompetitionByLeagueCode(string $leagueCode): ?Competition
    {
        return $this->competitionRepository->findByLeagueCode($leagueCode);
    }
}
