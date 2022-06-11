<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

class MakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create starter CRUD module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
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
        $this->container['name']  = $this->argument('name');
        $this->container['model'] = Str::studly($this->container['name']);

        $isCorrected = false;

        if ($this->confirmModelNameIsCorrected()) {
            $isCorrected = true;
        }
        else {
            $isCorrected = $this->askModelName();
        }

        if ($isCorrected) {
            $this->comment('You have provided the following information:');
            $this->comment('Name:  ' . $this->container['name']);
            $this->comment('Model: ' . $this->container['model']);

            if ($this->confirm('Do you wish to continue?', 'yes')) {
                $this->comment('Success!');
                $this->init();
                $this->generate();
            } else {
                return false;
            }

            $this->info('Starter '.$this->container['name'].' module installed successfully.');

            return true;
        }

        return false;
    }

    protected function confirmModelNameIsCorrected() : bool
    {
        $isCorrected = false;

        if ($this->confirm("Is '{$this->container['model']}' the correct name for the Model?", 'yes')) {
            $isCorrected = true;
        }

        return $isCorrected;
    }

    /**
     * ???
     *
     * @return void
     */
    protected function askModelName() : bool
    {
        $model = Str::studly($this->ask('Please enter the Model name'));

        $isCorrected = false;

        if (strlen($model) == 0) {
            $this->error("\Model name cannot be empty.");
        } else {
            $this->container['model'] = $model;

            if ($this->confirmModelNameIsCorrected()) {
                $isCorrected = true;
            }
            else {
                $isCorrected = $this->askModelName();
            }
        }

        return $isCorrected;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The names of modules will be created.'],
        ];
    }

    /**
     * ???
     *
     * @return void
     */
    protected function init()
    {
        $this->container['studly_name'] = Str::studly($this->container['name']);
        $this->container['lower_name']  = strtolower($this->container['name']);

        $name_parts = preg_split('/(?=[A-Z])/', $this->container['studly_name'], -1, PREG_SPLIT_NO_EMPTY);
        $name_parts = array_map('strtolower', $name_parts);
        $this->container['hyphen_name'] = implode('-', $name_parts);
        $this->container['snake_name']  = implode('_', $name_parts);


        $this->container['studly_model'] = Str::studly($this->container['model']);
        $this->container['lower_model']  = strtolower($this->container['model']);

        $model_parts = preg_split('/(?=[A-Z])/', $this->container['studly_model'], -1, PREG_SPLIT_NO_EMPTY);
        $model_parts = array_map('strtolower', $model_parts);
        $this->container['hyphen_model'] = implode('-', $model_parts);
        $this->container['snake_model']  = implode('_', $model_parts);
    }

    /**
     * ???
     *
     * @return void
     */
    protected function generate()
    {
        $Module = $this->container['studly_name'];
        $module = $this->container['lower_name'];

        $Model  = $this->container['studly_model'];
        $model  = $this->container['lower_name'];

        $targetPath = base_path('packages/code-for-food/'.$this->container['hyphen_name']);

        // Copy folders
        $this->copy(base_path('resources/laravel-modules/base-module'), $targetPath);

        // Replace contents
        $this->replaceInFile($targetPath.'/config/config.php');
        $this->replaceInFile($targetPath.'/database/factories/ModelFactory.php');
        $this->replaceInFile($targetPath.'/database/migrations/create_module_table.php');
        $this->replaceInFile($targetPath.'/database/seeders/ModelDatabaseSeeder.php');
        $this->replaceInFile($targetPath.'/src/Http/Controllers/ModuleController.php');
        $this->replaceInFile($targetPath.'/src/Models/Model.php');
        $this->replaceInFile($targetPath.'/src/Providers/ModuleServiceProvider.php');
        $this->replaceInFile($targetPath.'/src/Providers/RouteServiceProvider.php');
        $this->replaceInFile($targetPath.'/resources/views/create.blade.php');
        $this->replaceInFile($targetPath.'/resources/views/edit.blade.php');
        $this->replaceInFile($targetPath.'/resources/views/index.blade.php');
        $this->replaceInFile($targetPath.'/routes/api.php');
        $this->replaceInFile($targetPath.'/routes/web.php');
        $this->replaceInFile($targetPath.'/tests/Feature/ModuleTest.php');
        $this->replaceInFile($targetPath.'/composer.json');
        $this->replaceInFile($targetPath.'/module.json');
        $this->replaceInFile($targetPath.'/webpack.mix.js');

        //rename
        $this->rename($targetPath.'/database/factories/ModelFactory.php',         $targetPath.'/database/factories/'.$Model.'Factory.php');
        $this->rename($targetPath.'/database/migrations/create_module_table.php', $targetPath.'/database/migrations/create_'.$module.'_table.php', 'migration');
        $this->rename($targetPath.'/database/seeders/ModelDatabaseSeeder.php',    $targetPath.'/database/seeders/'.$Module.'DatabaseSeeder.php');
        $this->rename($targetPath.'/src/Http/Controllers/ModuleController.php',   $targetPath.'/src/Http/Controllers/'.$Module.'Controller.php');
        $this->rename($targetPath.'/src/Models/Model.php',                        $targetPath.'/src/Models/'.$Model.'.php');
        $this->rename($targetPath.'/src/Providers/ModuleServiceProvider.php',     $targetPath.'/src/Providers/'.$Module.'ServiceProvider.php');
        $this->rename($targetPath.'/tests/Feature/ModuleTest.php',                $targetPath.'/tests/Feature/'.$Module.'Test.php');
    }

    /**
     * ???
     *
     * @param  string  $path
     * @param  string  $target
     * @param  mix  $type
     *
     * @return void
     */
    protected function rename($path, $target, $type = null)
    {
        $filesystem = new SymfonyFilesystem;
        if ($filesystem->exists($path)) {
            if ($type == 'migration') {
                $timestamp = date('Y_m_d_his_');
                $target = str_replace("create", $timestamp."create", $target);
                $filesystem->rename($path, $target, true);
                $this->replaceInFile($target);
            } else {
                $filesystem->rename($path, $target, true);
            }
        }
    }

    /**
     * ???
     *
     * @param  string  $path
     * @param  string  $target
     *
     * @return void
     */
    protected function copy($path, $target)
    {
        $filesystem = new SymfonyFilesystem;
        if ($filesystem->exists($path)) {
            $filesystem->mirror($path, $target);
        }
    }

    /**
     * ???
     *
     * @param  string  $path
     *
     * @return void
     */
    protected function replaceInFile($path)
    {
        $types = [
            '{Module}'  => $this->container['studly_name'],
            '{module}'  => $this->container['lower_name'],
            '{module-}' => $this->container['hyphen_name'],
            '{module_}' => $this->container['snake_name'],
            '{Model}'   => $this->container['studly_model'],
            '{model}'   => $this->container['lower_model'],
            '{model-}'  => $this->container['hyphen_model'],
            '{model_}'  => $this->container['snake_model'],
        ];

        foreach ($types as $key => $value) {
            if (file_exists($path)) {
                file_put_contents($path, str_replace($key, $value, file_get_contents($path)));
            }
        }
    }
}
