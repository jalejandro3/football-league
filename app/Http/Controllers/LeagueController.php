<?php

namespace App\Http\Controllers;

use App\Exceptions\InputValidationException;
use App\Services\LeagueServiceInterface;
use Illuminate\Http\JsonResponse;

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
     * @param string $leagueCode
     * @return JsonResponse
     * @throws InputValidationException
     * @throws \App\Exceptions\ApplicationException
     * @throws \App\Exceptions\ResourceNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function import(string $leagueCode): JsonResponse
    {
        if (empty($leagueCode)) {
            throw new InputValidationException('You must pass a valid league code');
        }

        return $this->success($this->leagueService->importLeagueDataToDatabase($leagueCode));
    }

    /**
     * @param string $leagueCode
     * @return JsonResponse
     * @throws InputValidationException
     * @throws \App\Exceptions\ApplicationException
     * @throws \App\Exceptions\ResourceNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTotalPlayers(string $leagueCode): JsonResponse
    {
        if (empty($leagueCode)) {
            throw new InputValidationException('You must pass a valid league code');
        }

        return $this->success($this->leagueService->getTeamPlayerTotal($leagueCode));
    }
}
