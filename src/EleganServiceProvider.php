<?php

namespace Jcsfran\Elegan;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Jcsfran\Elegan\Console\{
    GeneratePatchNoteCommand,
    GenerateRouteCommand,
};

class EleganServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config';
        $resourcesPath = __DIR__ . '/../resources';

        $this->publishes([
            $configPath => config_path(),
            $resourcesPath . '/publish' => public_path('elegan'),
            $resourcesPath . '/views/index.blade.php' => config('l5-swagger.defaults.paths.views') . '/index.blade.php',
        ]);
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'elegan');
        $this->commands([
            GeneratePatchNoteCommand::class,
            GenerateRouteCommand::class,
        ]);

        Blade::component('elegan-container', 'elegan::components.container');
        Blade::component('elegan-content', 'elegan::components.content');
        Blade::component('elegan-header-container', 'elegan::components.header-container');
        Blade::component('elegan-routes', 'elegan::components.routes');
        Blade::component('elegan-table-routes', 'elegan::components.table-routes');
    }
}
