<?php

namespace App\Services;

use App\Clients\FootballClientInterface;
use App\Models\Competition;
use App\Repositories\TeamRepositoryInterface;

/**
 * Class TeamService
 *
 * @package App\Services
 */
final class TeamService implements TeamServiceInterface
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
     * @var PlayerServiceInterface
     */
    private PlayerServiceInterface $playerService;

    /**
     * @var TeamRepositoryInterface
     */
    private TeamRepositoryInterface $teamRepository;

    /**
     * TeamService constructor.
     *
     * @param CompetitionServiceInterface $competitionService
     * @param FootballClientInterface $footballClient
     * @param PlayerServiceInterface $playerService
     * @param TeamRepositoryInterface $teamRepository
     */
    public function __construct(
        CompetitionServiceInterface $competitionService,
        FootballClientInterface $footballClient,
        PlayerServiceInterface $playerService,
        TeamRepositoryInterface $teamRepository
    )
    {
        $this->competitionService = $competitionService;
        $this->footballClient = $footballClient;
        $this->playerService = $playerService;
        $this->teamRepository = $teamRepository;
    }

    /**
     * @inheritDoc
     */
    public function saveTeams(array $teams, Competition $competition)
    {
        $teamIds = [];

        foreach ($teams as $team) {
            $newTeam = $this->teamRepository->create([
                'competition_id' => $competition->id,
                'name' => $team->name,
                'tla' => $team->tla,
                'shortName' => $team->shortName,
                'areaName' => $team->area->name,
                'email' => $team->email
            ]);

            array_push($teamIds, $newTeam->id);

            if (!in_array($newTeam->id, get_competition_team_ids($competition))) {
                $teamResponse = $this->footballClient->exec("teams/{$team->id}", 'get');

                if ($teamResponse) {
                    $this->playerService->savePlayers($teamResponse->squad, $newTeam);
                }
            }
        }

        $this->saveCompetitionTeamRelations($competition, $teamIds);
    }

    /**
     * @inheritDoc
     */
    public function getTeamPlayerTotal(string $leagueCode): array
    {
        $this->competitionService->invalidCompetitionCode($leagueCode);

        $totalPlayer = 0;
        $competition = $this->competitionService->getCompetitionByLeagueCode($leagueCode);

        foreach ($competition->teams()->get() as $team) {
            $totalPlayer += $team->players()->count();
        }

        return ["total" => "<em><strong>$totalPlayer</strong></em>"];
    }

    /**
     * Save competition-team relations for new team ids.
     *
     * @param Competition $competition Competition object.
     * @param array $newTeamIds Array with new team ids.
     */
    private function saveCompetitionTeamRelations(Competition $competition, array $newTeamIds)
    {
        $nonExistingIds = array_diff($newTeamIds, get_competition_team_ids($competition));

        sort($nonExistingIds);

        if (count($nonExistingIds) > 0) {
            $competition->teams()->syncWithoutDetaching($nonExistingIds);
        }
    }
}
