<?php

namespace App\Http\Controllers;

use App\Exceptions\InputValidationException;
use App\Rules\Uppercase;
use App\Services\LeagueServiceInterface;
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
     * LeagueController constructor.
     *
     * @param LeagueServiceInterface $leagueService
     */
    public function __construct(LeagueServiceInterface $leagueService)
    {
        $this->leagueService = $leagueService;
    }

    /**
     * Import the given League to the database.
     *
     * @param string $leagueCode League code.
     * @return JsonResponse
     * @throws \App\Exceptions\InputValidationException
     * @throws \App\Exceptions\ApplicationException
     * @throws \App\Exceptions\ResourceNotFoundException
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
     * @return JsonResponse
     * @throws InputValidationException
     * @throws \App\Exceptions\ApplicationException
     * @throws \App\Exceptions\ResourceNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTotalPlayers(string $leagueCode): JsonResponse
    {
        $validator = Validator::make(['league_code' => $leagueCode], [
            'league_code' => new Uppercase
        ]);

        if ($validator->fails()) {
            throw new InputValidationException($validator->errors()->getMessageBag()->get('league_code')[0]);
        }

        return $this->success($this->leagueService->getTeamPlayerTotal($leagueCode), 200);
    }
}
