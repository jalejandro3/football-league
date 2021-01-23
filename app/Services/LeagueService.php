<?php

namespace App\Services;

use App\Clients\FootballClientInterface;
use App\Exceptions\ApplicationException;
use App\Models\Competition;
use App\Models\League;
use App\Repositories\LeagueRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class LeagueService
 *
 * @package App\Services
 */
final class LeagueService implements LeagueServiceInterface
{
    /**
     * @var CompetitionServiceInterface
     */
    private CompetitionServiceInterface $competitionService;

    /**
     * @var FootballClientInterface
     */
    private FootballClientInterface $footballClient;

    /**
     * @var LeagueRepositoryInterface
     */
    private LeagueRepositoryInterface $leagueRepository;

    /**
     * @var TeamServiceInterface
     */
    private TeamServiceInterface $teamService;

    /**
     * LeagueService constructor.
     *
     * @param CompetitionServiceInterface $competitionService
     * @param FootballClientInterface $footballClient
     * @param LeagueRepositoryInterface $leagueRepository
     * @param TeamServiceInterface $teamService
     */
    public function __construct(
        CompetitionServiceInterface $competitionService,
        FootballClientInterface $footballClient,
        LeagueRepositoryInterface $leagueRepository,
        TeamServiceInterface $teamService
    )
    {
        $this->competitionService = $competitionService;
        $this->footballClient = $footballClient;
        $this->leagueRepository = $leagueRepository;
        $this->teamService = $teamService;
    }

    /**
     * @inheritDoc
     */
    public function importLeagueDataToDatabase(string $leagueCode): array
    {
        $league = $this->leagueRepository->findByCode($leagueCode);

        $this->notExists($league);

        $this->isImported($league->status);

        $response = $this->footballClient->exec("competitions/{$leagueCode}/teams", 'get');
        $competition = $response->competition;
        $teams = $response->teams;

        DB::beginTransaction();

        try {
            $newCompetition = $this->competitionService->saveCompetition($competition);

            $this->teamService->saveTeams($teams, $newCompetition);

            $this->leagueRepository->update($league->id, ['status' => League::STATUS_IMPORTED]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage(), 504);
        }

        return ["message" => "Successfully imported"];
    }

    /**
     * Validate if a league is already imported.
     *
     * @param string $status League status.
     *
     * @throws ApplicationException
     */
    private function isImported(string $status)
    {
        if ($status === League::STATUS_IMPORTED) {
            throw new ApplicationException('League already imported', 409);
        }
    }

    /**
     * Validate if a league code exists into the TIER1 free code leagues.
     *
     * @param League|null $league League object.
     * @throws ResourceNotFoundException
     */
    private function notExists(?League $league)
    {
        if (is_null($league)) {
            throw new ResourceNotFoundException('Not found', 404);
        }
    }
}
