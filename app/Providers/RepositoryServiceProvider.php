<?php

namespace App\Providers;

use App\Repositories\CompetitionRepository;
use App\Repositories\CompetitionRepositoryInterface;
use App\Repositories\ImporterRepository;
use App\Repositories\ImporterRepositoryInterface;
use App\Repositories\PlayerRepository;
use App\Repositories\PlayerRepositoryInterface;
use App\Repositories\TeamRepository;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CompetitionRepositoryInterface::class, CompetitionRepository::class);
        $this->app->singleton(ImporterRepositoryInterface::class, ImporterRepository::class);
        $this->app->singleton(PlayerRepositoryInterface::class, PlayerRepository::class);
        $this->app->singleton(TeamRepositoryInterface::class, TeamRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
