<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{

    protected $signature = 'app:service {name}';
    protected $description = 'Create a new service class inside app/Services folder';


    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = new Filesystem();

        $directory = app_path('Services');
        if (! $filesystem->exists($directory)) {
            $filesystem->makeDirectory($directory, 0755, true); // Create the directory
        }

        $filePath = $directory . '/' . $name . 'Service.php';

        if ($filesystem->exists($filePath)) {
            $this->error("Service already exists: {$filePath}");
            return Command::FAILURE;
        }

        $stub = <<<EOT
        <?php

        namespace App\Services;

        class {$name}Service
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

            public function update(array \$data, \$id)
            {
                // TODO: implement update() method
            }    

            public function delete(\$id)
            {
                // TODO: implement delete() method
            }
        }

        EOT;;

        $filesystem->put($filePath, $stub);

        $this->info("Service created successfully: {$filePath}");
        return Command::SUCCESS;
      
        
        
    }
}
