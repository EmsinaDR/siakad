<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeCustomController extends GeneratorCommand
{
    protected $signature = 'make:custom-controller {name}';
    protected $description = 'Create a new controller using a custom stub';
    protected $type = 'Controller';

    protected function getStub()
    {
        return base_path('stubs/custom-controller.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\Http\\Controllers';
    }

    public function handle()
    {
        // Ambil nama controller
        $name = $this->argument('name');

        // Tentukan namespace model dan view berdasarkan nama controller
        $modelNamespace = Str::studly(str_replace('Controller', '', class_basename($name)));
        $viewName = Str::slug(strtolower($modelNamespace));

        // Ganti placeholder di dalam stub
        $stub = $this->buildClass($name);

        // Ganti placeholder dengan model dan view yang sesuai
        $stub = str_replace(
            ['{{ model }}', '{{ view }}'],
            [$modelNamespace, $viewName],
            $stub
        );

        // Simpan file controller yang dihasilkan
        $path = $this->getPath($name);
        if (file_exists($path) && !$this->option('force')) {
            $this->error('Controller already exists!');
            return;
        }

        file_put_contents($path, $stub);
        $this->info('Controller created successfully.');
    }
}
