<?php

namespace Jcsfran\Elegan;

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
        $this->publishes([__DIR__ . '/../resources/publish' => public_path('elegan')]);
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'elegan');
        $this->commands([
            GeneratePatchNoteCommand::class,
            GenerateRouteCommand::class,
        ]);
    }
}
