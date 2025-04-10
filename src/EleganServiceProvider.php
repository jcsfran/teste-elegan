<?php

namespace Jcsfran\Elegan;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Jcsfran\Elegan\Console\{
    GeneratePatchNoteCommand,
    GenerateRouteCommand,
};
use Jcsfran\Elegan\Views\Components\Container;
use Jcsfran\Elegan\Views\Components\Content;
use Jcsfran\Elegan\Views\Components\HeaderContainer;
use Jcsfran\Elegan\Views\Components\Routes;
use Jcsfran\Elegan\Views\Components\TableRoutes;

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

        Blade::component('elegan-container', Container::class);
        Blade::component('elegan-content', Content::class);
        Blade::component('elegan-header-container', HeaderContainer::class);
        Blade::component('elegan-routes', Routes::class);
        Blade::component('elegan-table-routes', TableRoutes::class);
    }
}
