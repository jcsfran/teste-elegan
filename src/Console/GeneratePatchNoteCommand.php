<?php

namespace Labi9\Elegan\Console;

use Carbon\Carbon;
use Illuminate\{
    Console\Command,
    Support\Str,
};

class GeneratePatchNoteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:note {name} {--routes=1 : The number of routes modified in this update }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a file yaml for patch notes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->createFolderIfNotExists();

        $path = config('elegan.patch_note_path') . '/';
        $fileName = $this->fileName();
        $structure = $this->structure();

        $file = fopen($path . $fileName . '.yaml', 'w');

        fwrite($file, $structure);
        fclose($file);

        return $this->info('Created patch note file: ' . $fileName);
    }

    private function createFolderIfNotExists(): void
    {
        if (!is_dir(config('elegan.patch_note_path'))) {
            mkdir(config('elegan.patch_note_path'), 755, true);
        }
    }

    private function fileName(): string
    {
        $fileName =  Carbon::now()->format('Y_m_d_His');
        $fileName .= '_';
        $fileName .=  Str::snake(trim($this->argument('name')));

        return $fileName;
    }

    private function structure(): string
    {
        $routes = $this->option('routes');

        $structure = "info: " . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 2) . "version: 0.0." . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 2) . "title: ''" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 2) . "date: '" .
            Carbon::now()->isoFormat('Y-MM-DD') .
            "'" .
            PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 2) . "content:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 2) . "- tag: ''" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 4) . "description: ''" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 4) . "routes: " . PHP_EOL;

        for ($i = 1; $i <= $routes; $i++) {
            $structure .= str_repeat(config('elegan.space'), 4) . "- description: ''" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 6) . "method: '' # GET - POST - PUT or DELETE" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 6) . "endpoint: ''" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 6) . "action: ''" . PHP_EOL;
        }

        return $structure;
    }
}
