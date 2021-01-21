<?php

namespace App\Http\Controllers;

use App\Services\ImporterServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ImporterController.
 *
 * @package App\Http\Controllers
 */
class ImporterController extends Controller
{
    /**
     * @var ImporterServiceInterface
     */
    private ImporterServiceInterface $importerService;

    /**
     * ImporterController constructor.
     *
     * @param ImporterServiceInterface $importerService
     */
    public function __construct(ImporterServiceInterface $importerService)
    {
        $this->importerService = $importerService;
    }

    /**
     * @param Request $request
     */
    public function import(Request $request): JsonResponse
    {
        //TODO: Generate validation rules for the request league.

        return $this->success($this->importerService->importLeagueDataToDatabase($request->get('league_code')));
    }
}
