<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Pest\Laravel\put;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';
    protected $description = 'Generate a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        if (file_exists($path)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        $stub = "<?php
        
namespace App\Services;

class {$name}
{
    //
}
";
        File::ensureDirectoryExists(app_path('Services'));
        File::put($path, $stub);
        $this->info("Service {$name} created: {$path}");
    }
}
