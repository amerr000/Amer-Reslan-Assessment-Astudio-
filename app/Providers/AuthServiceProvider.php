<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Models\Timesheet;





class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::loadKeysFrom(storage_path());


        Gate::define('update-timesheet', function ($user, Timesheet $timesheet) {
            return $user->id === $timesheet->user_id;
        });
    }
}
