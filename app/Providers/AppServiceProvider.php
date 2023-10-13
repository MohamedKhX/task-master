<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {

            if(auth()->guest()) { return; }

            $user     = auth()->user();
            $employee = $user->employee;
            $team     = $employee?->team;
            $members  = $team?->members;

            $cacheKey = 'team_projects_' . $team?->id;
            $projects = Cache::remember($cacheKey, 3600, function () use ($team) {
                return $team?->projects()->limit(5)->get();
            });


            $view->with('signedInUser', $user);
            $view->with('signedInEmployee', $employee);
            $view->with('signedInTeam', $team);
            $view->with('signedInTeamMembers', $members);
            $view->with('signedInTeamProjects', $projects);
        });
    }
}
