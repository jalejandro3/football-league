<?php

namespace App\Repositories;

use App\Models\Importer;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ImporterRepository
 *
 * @package App\Repositories
 */
final class ImporterRepository implements ImporterRepositoryInterface
{
    /**
     * @var Importer Importer.
     */
    private Importer $importer;

    /**
     * ImporterRepository constructor.
     *
     * @param Importer $importer Importer object.
     */
    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->importer->all();
    }
}
