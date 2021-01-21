<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ImporterRepositoryInterface.
 *
 * @package App\Repositories
 */
interface ImporterRepositoryInterface
{
    /**
     * Return a importer record collection
     *
     * @return Collection
     */
    public function all(): Collection;
}
