<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{

    
    public function boot()
{
    $this->commands([
        InstallCommand::class,
        ClientCommand::class,
        KeysCommand::class,
    ]);
}
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
        Passport::routes(null, ['middleware' => [
        // You can make this simpler by creating a tenancy route group
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ]]);
        \Laravel\Passport\Passport::ignoreMigrations();
    }

}
