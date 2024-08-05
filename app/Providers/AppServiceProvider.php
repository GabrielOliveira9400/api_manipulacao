<?php

namespace App\Providers;

use App\Interface\IRepositoryClient;
use App\Interface\IRepositoryFormulaAtivo;
use App\Repository\RepositoryClient;
use App\Interface\IRepositoryFormula;
use App\Repository\RepositoryFormula;
use App\Interface\IRepositoryAtivo;
use App\Repository\RepositoryAtivo;

use App\Repository\RepositoryFormulaAtivo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application Services.
     */
    public function register(): void
    {
        $this->app->bind(IRepositoryClient::class, RepositoryClient::class);
        $this->app->bind(IRepositoryFormula::class, RepositoryFormula::class);
        $this->app->bind(IRepositoryAtivo::class, RepositoryAtivo::class);
        $this->app->bind(IRepositoryFormulaAtivo::class, RepositoryFormulaAtivo::class);
    }

    /**
     * Bootstrap any application Services.
     */
    public function boot(): void
    {

    }
}
