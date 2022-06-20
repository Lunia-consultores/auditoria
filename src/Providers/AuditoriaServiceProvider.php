<?php

namespace Lunia\Auditoria\Providers;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Lunia\Auditoria\Middlewares\AddToRequestAuthUser;
use Lunia\Auditoria\Services\Auditoria\CrearRegistroAuditoria;
use Lunia\Auditoria\Services\Auditoria\CrearRegistroAuditoriaRequest;
use Lunia\Auditoria\Commands\ArchivaAuditoriaCommand;
use Illuminate\Contracts\Http\Kernel;

class AuditoriaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(Kernel $kernel)
    {
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../../database/migrations'));
        $kernel->pushMiddleware(AddToRequestAuthUser::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                realpath(__DIR__ . '/../../config/config.php') => config_path('auditoria.php'),
            ], 'config');

            $this->commands([ArchivaAuditoriaCommand::class]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__ . '/../../config/config.php'), 'auditoria');
        DB::listen(function (QueryExecuted $query) {
            app()->make(CrearRegistroAuditoria::class)->handle(
                new CrearRegistroAuditoriaRequest(
                    $query->sql,
                    request()->input('auditable_user_id') ?? null,
                    request()->url(),
                    $query->bindings,
                    config('auditoria.excluded_tables')
                ));
        });
        // Automatically apply the package configuration

    }
}
