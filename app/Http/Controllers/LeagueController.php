<?php

namespace App\Http\Controllers;

use App\Exceptions\InputValidationException;
use App\Rules\Uppercase;
use App\Services\LeagueServiceInterface;
use App\Services\TeamServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Class LeagueController.
 *
 * @package App\Http\Controllers
 */
class LeagueController extends Controller
{
    /**
     * @var LeagueServiceInterface
     */
    private LeagueServiceInterface $leagueService;

    /**
     * @var TeamServiceInterface
     */
    private TeamServiceInterface $teamService;

    /**
     * LeagueController constructor.
     *
     * @param LeagueServiceInterface $leagueService
     * @param TeamServiceInterface $teamService
     */
    public function __construct(
        LeagueServiceInterface $leagueService,
        TeamServiceInterface $teamService
    )
    {
        $this->leagueService = $leagueService;
        $this->teamService = $teamService;
    }

    /**
     * Import data from footbal-data to database.
     *
     * @param string $leagueCode League code.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\InputValidationException
     * @throws \App\Exceptions\ApplicationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function import(string $leagueCode): JsonResponse
    {
        $validator = Validator::make(['league_code' => $leagueCode], [
            'league_code' => new Uppercase
        ]);

        if ($validator->fails()) {
            throw new InputValidationException($validator->errors()->getMessageBag()->get('league_code')[0]);
        }

        return $this->success($this->leagueService->importLeagueDataToDatabase($leagueCode), 201);
    }

    /**
     * Get the total amount of players belonging to all teams that participate in the given league.
     *
     * @param string $leagueCode League code.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\InputValidationException
     */
    public function getTotalPlayers(string $leagueCode): JsonResponse
    {
        $validator = Validator::make(['league_code' => $leagueCode], [
            'league_code' => new Uppercase
        ]);

        if ($validator->fails()) {
            throw new InputValidationException($validator->errors()->getMessageBag()->get('league_code')[0]);
        }

        return $this->success($this->teamService->getTeamPlayerTotal($leagueCode), 200);
    }
}
