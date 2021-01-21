<?php

namespace App\Services;

use App\Clients\FootballClientInterface;
use App\Exceptions\ApplicationException;
use App\Exceptions\ResourceNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * Class ImporterService
 *
 * @package App\Services
 */
final class ImporterService implements ImporterServiceInterface
{
    /**
     * @var FootballClientInterface
     */
    private FootballClientInterface $footballClient;

    /**
     * ImporterService constructor.
     *
     * @param FootballClientInterface $footballClient
     */
    public function __construct(FootballClientInterface $footballClient)
    {
        $this->footballClient = $footballClient;
    }

    /**
     * @inheritDoc
     */
    public function importLeagueDataToDatabase(string $leagueCode): array
    {
        // TODO: Implement importLeagueDataToDatabase() method.
        // TODO: First save the top relation, then the next one deep and the last the deeper one.

        /*Exception for league already imported*/
        $this->isAlreadyImported();

        /*Exception for league not found, check the client response for not found league*/
        $this->leagueDoesNotExits();

        DB::transaction(function() {
            // TODO: a Database Transaction to avoid corrupted data.
        });

        return "Successfully imported";
    }

    /**
     * @throws ApplicationException
     */
    private function isAlreadyImported()
    {
        if (true) {
            throw new ApplicationException('League already imported', 409);
        }
    }

    /**
     * @throws ResourceNotFoundException
     */
    private function leagueDoesNotExits()
    {
        if (true) {
            throw new ResourceNotFoundException('Not found');
        }
    }
}
