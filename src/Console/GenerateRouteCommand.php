<?php

namespace Labi9\Elegan\Console;

use Illuminate\Console\Command;
use Labi9\Elegan\EleganHelper;

class GenerateRouteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:route
                            {path : "file path, use : to pass parameters"}
                            {action* : array with the actions to be created}
                            {--name=* : name of each action file}
                            {--a|auth : whether to have authentication}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new file with your actions';

    public function __construct(private EleganHelper $eleganHelper)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->checkIfAtLeastOneActionWasReported();
        $this->checkOptionsReportedExists();

        $message = 'Copy path file: ' . config('elegan.route_path') . '/';
        $path = $this
            ->eleganHelper
            ->createRoute(
                $this->argument('path'),
                $this->argument('action'),
                $this->option('auth'),
                $this->option('name')
            );

        return $this->info($message . $path);
    }

    private function checkIfAtLeastOneActionWasReported(): void
    {
        if (empty($this->argument('action'))) {
            $message = $this->error(
                'Please select at least one action.'
            );

            $message .= $this->alert(
                '--index --show --store --update or --destroy'
            );

            exit;
        }
    }

    private function checkOptionsReportedExists(): void
    {
        $validActions = [
            'index',
            'show',
            'store',
            'update',
            'destroy'
        ];

        foreach ($this->argument('action') as $action) {
            if (!in_array($action, $validActions)) {
                $message = $this->error(
                    'This action is invalid: ' . $action
                );

                $message .= $this->alert(
                    'index show store update or destroy'
                );

                exit;
            }
        }
    }
}
