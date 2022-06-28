<?php

namespace Lunia\Auditoria\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Lunia\Auditoria\Commands\ArchivaAuditoriaCommand;
use Symfony\Component\Console\Output\ConsoleOutput;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationsStarted;

class AuditoriaApplicationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {


        $this->mergeConfigFrom(realpath(__DIR__ . '/../../config/config.php'), 'auditoria');


        Event::listen(MigrationsStarted::class, function($event) {
            config()->set('auditoria.enable_audit',false);
        });

        Event::listen(MigrationsEnded::class, function($event) {
            config()->set('auditoria.enable_audit',true);
        });
        if( App::runningUnitTests()) {
            config()->set('auditoria.enable_audit',false);
        }
        if ($this->app->runningInConsole()) {

            $this->publishes([
                realpath(__DIR__ . '/../../config/config.php') => config_path('auditoria.php'),
            ], 'config');
            $this->publishes([
                realpath(__DIR__ . '/../../stubs/AuditoriaServiceProvider.stub') => app_path('Providers/AuditoriaServiceProvider.php'),
            ], 'auditoria-provider');

            if(config('auditoria.enable_audit') === TRUE)
            {
                if (is_null(config('database.connections.'.config('auditoria.db_connection')))){
                    config()->set('auditoria.enable_audit',false);
                    $output = new ConsoleOutput();
                    $output->writeln("<error>Debe configurar una conexion de base de datos para la auditoria</error>");
                    return;
                }
                if( config('auditoria.db_connection') == config('database.default')){
                    config()->set('auditoria.enable_audit',false);
                    $output = new ConsoleOutput();
                    $output->writeln("<error>La conexión de auditoría no puede coincidir con la conexión por defecto</error>");
                    return;
                }

                $this->loadMigrationsFrom(realpath(__DIR__ . '/../../database/migrations'));
                $this->commands([ArchivaAuditoriaCommand::class]);
            }
        }
    }

}
