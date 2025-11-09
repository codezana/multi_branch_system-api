<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeRepository extends Command
{
    protected $signature = 'app:repository {name}';
    protected $description = 'Create a new repository class inside app/Repositories folder';

    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = new Filesystem();

        $directory = app_path('Repositories');
        if (! $filesystem->exists($directory)) {
            $filesystem->makeDirectory($directory, 0755, true); // Create the directory
        }

        $filePath = $directory . '/' . $name . 'Repository.php';

        if ($filesystem->exists($filePath)) {
            $this->error("Repository already exists: {$filePath}");
            return Command::FAILURE;
        }

        $stub = <<<EOT
        <?php

        namespace App\Repositories;

        class {$name}Repository
        {
            public function all()
            {
                // TODO: implement all() method
            }

            public function find(\$id)
            {
                // TODO: implement find() method
            }

            public function create(array \$data)
            {
                // TODO: implement create() method
            }

            public function update(\$id, array \$data)
            {
                // TODO: implement update() method
            }

            public function delete(\$id)
            {
                // TODO: implement delete() method
            }
        }
        EOT;

        $filesystem->put($filePath, $stub);
        $this->info("Repository created successfully: {$filePath}");

        return Command::SUCCESS;
    }
}
