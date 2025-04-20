<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';
    protected $description = 'Generate an Repository class with Interface';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $interfaceName = "{$name}Interface";

        $interfacePath = app_path("Repositories/Interfaces/{$interfaceName}.php");
        $classPath = app_path("Repositories/{$name}.php");

        if(File::exists($classPath) || File::exists($interfacePath)) {
            $this->error('REpository or Interface already exists!');
            return;
        }

        $interfaceStub = "<?php

namespace App\Repositories\Interfaces;

interface {$interfaceName}
{
    //
}
";
        $classStub = "<?php

namespace App\Repositories;

use App\Repositories\Interfaces\\{$interfaceName};

class {$name} implements {$interfaceName}
{
    //
}
";
        File::ensureDirectoryExists(app_path('Repositories/Interfaces'));
        File::ensureDirectoryExists(app_path('Repositories'));
        File::put($interfacePath, $interfaceStub);
        File::put($classPath, $classStub);
        $this->info("Repository {$name} created: {$classPath}");
        $this->info("Interface {$interfaceName} created: {$interfacePath}");
    }
}
