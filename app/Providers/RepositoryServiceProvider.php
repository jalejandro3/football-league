<?php

namespace App\Providers;

use App\Repositories\CompetitionRepository;
use App\Repositories\CompetitionRepositoryInterface;
use App\Repositories\LeagueRepository;
use App\Repositories\LeagueRepositoryInterface;
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
        $this->app->singleton(LeagueRepositoryInterface::class, LeagueRepository::class);
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
