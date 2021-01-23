<?php

namespace App\Services;

use App\Clients\FootballClientInterface;
use App\Exceptions\ApplicationException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\Competition;
use App\Models\League;
use App\Repositories\CompetitionRepositoryInterface;
use App\Repositories\LeagueRepositoryInterface;
use App\Repositories\PlayerRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class LeagueService
 *
 * @package App\Services
 */
final class LeagueService implements LeagueServiceInterface
{
    /**
     * @var CompetitionRepositoryInterface
     */
    private CompetitionRepositoryInterface $competitionRepository;

    /**
     * @var FootballClientInterface
     */
    private FootballClientInterface $footballClient;

    /**
     * @var LeagueRepositoryInterface
     */
    private LeagueRepositoryInterface $leagueRepository;

    /**
     * @var PlayerRepositoryInterface
     */
    private PlayerRepositoryInterface $playerRepository;

    /**
     * @var TeamRepositoryInterface
     */
    private TeamRepositoryInterface $teamRepository;

    /**
     * LeagueService constructor.
     *
     * @param CompetitionRepositoryInterface $competitionRepository
     * @param FootballClientInterface $footballClient
     * @param LeagueRepositoryInterface $leagueRepository
     * @param PlayerRepositoryInterface $playerRepository
     * @param TeamRepositoryInterface $teamRepository
     */
    public function __construct(
        CompetitionRepositoryInterface $competitionRepository,
        FootballClientInterface $footballClient,
        LeagueRepositoryInterface $leagueRepository,
        PlayerRepositoryInterface $playerRepository,
        TeamRepositoryInterface $teamRepository
    )
    {
        $this->competitionRepository = $competitionRepository;
        $this->footballClient = $footballClient;
        $this->leagueRepository = $leagueRepository;
        $this->playerRepository = $playerRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * @inheritDoc
     */
    public function importLeagueDataToDatabase(string $leagueCode): array
    {
        $league = $this->leagueRepository->findByCode($leagueCode);

        $this->notExists($league);

        $this->isImported($league->status);

        $teamIds = [];
        $request = "competitions/{$leagueCode}/teams";
        $response = $this->footballClient->exec($request, 'get');
        $competition = $response->competition;
        $teams = $response->teams;

        DB::beginTransaction();

        try {
            $newCompetition = $this->competitionRepository->create([
                'name' => $competition->name,
                'code' => $competition->code,
                'areaName' => $competition->area->name
            ]);

            foreach ($teams as $team) {
                $newTeam = $this->teamRepository->create([
                    'competition_id' => $newCompetition->id,
                    'name' => $team->name,
                    'tla' => $team->tla,
                    'shortName' => $team->shortName,
                    'areaName' => $team->area->name,
                    'email' => $team->email
                ]);

                array_push($teamIds, $newTeam->id);

                if (!in_array($newTeam->id, get_competition_team_ids($newCompetition))) {
                    $teamResponse = $this->footballClient->exec("teams/{$team->id}", 'get');
                    $players = $teamResponse->squad;

                    foreach ($players as $player) {
                        $this->playerRepository->create([
                            'team_id' => $newTeam->id,
                            'name' => $player->name,
                            'position' => $player->position,
                            'dateOfBirth' => $player->dateOfBirth,
                            'countryOfBirth' => $player->countryOfBirth,
                            'nationality' => $player->nationality
                        ]);
                    }
                }
            }

            $this->saveCompetitionTeamRelations($newCompetition, $teamIds);

            $this->leagueRepository->update($league->id, ['status' => League::STATUS_IMPORTED]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return ["message" => "Successfully imported"];
    }

    /**
     * @inheritDoc
     */
    public function getTeamPlayerTotal(string $leagueCode): array
    {
        $this->invalidCompetitionCode($leagueCode);

        $totalPlayer = 0;
        $competition = $this->competitionRepository->findByLeagueCode($leagueCode);

        foreach ($competition->teams()->get() as $team) {
            $totalPlayer += $team->players()->count();
        }

        return ["total" => "<em><strong>$totalPlayer</strong></em>"];
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
            throw new ResourceNotFoundException('Not found');
        }
    }

    /**
     * Validate if there is a competition with a valid league code associated.
     *
     * @param string $leagueCode League code.
     * @throws ResourceNotFoundException
     */
    private function invalidCompetitionCode(string $leagueCode)
    {
        if (!$this->competitionRepository->findByLeagueCode($leagueCode)) {
            throw new ResourceNotFoundException('Not found');
        }
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
