<?php

namespace App\Providers;

use App\Services\CompetitionService;
use App\Services\CompetitionServiceInterface;
use App\Services\LeagueService;
use App\Services\LeagueServiceInterface;
use App\Services\PlayerService;
use App\Services\PlayerServiceInterface;
use App\Services\TeamService;
use App\Services\TeamServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CompetitionServiceInterface::class, CompetitionService::class);
        $this->app->singleton(LeagueServiceInterface::class, LeagueService::class);
        $this->app->singleton(PlayerServiceInterface::class, PlayerService::class);
        $this->app->singleton(TeamServiceInterface::class, TeamService::class);
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
