<?php

namespace Lunia\Auditoria\Providers;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Lunia\Auditoria\Services\Auditoria\CrearRegistroAuditoria;
use Lunia\Auditoria\Services\Auditoria\CrearRegistroAuditoriaRequest;

class AuditoriaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../../database/migrations'));
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('auditoria.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/auditoria'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/auditoria'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/auditoria'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        DB::listen(function (QueryExecuted $query) {
            app()->make(CrearRegistroAuditoria::class)->handle(
                new CrearRegistroAuditoriaRequest(
                    $query->sql,
                    auth()->id(),
                    request()->url(),
                    $query->bindings
                ));
        });
        // Automatically apply the package configuration
        $this->mergeConfigFrom(realpath(__DIR__ . '/../../config/config.php'), 'auditoria');

    }
}
