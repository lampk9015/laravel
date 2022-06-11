<?php

use Nwidart\Modules\Activators\FileActivator;
use Nwidart\Modules\Commands;

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

    'namespace' => 'Modules',

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    'stubs' => [
        'enabled' => true,
        'path' => base_path() . '/resources/laravel-modules/stubs',
        'files' => [
            'routes/web'      => 'routes/web.php',
            'routes/api'      => 'routes/api.php',
            'views/index'     => 'resources/views/index.blade.php',
            'views/master'    => 'resources/views/layouts/master.blade.php',
            'scaffold/config' => 'config/config.php',
            'composer'        => 'composer.json',
            'assets/js/app'   => 'resources/assets/js/app.js',
            'assets/sass/app' => 'resources/assets/sass/app.scss',
            'webpack'         => 'webpack.mix.js',
            'package'         => 'package.json',
        ],
        'replacements' => [
            'routes/web'      => ['LOWER_NAME', 'HYPHEN_NAME', 'STUDLY_NAME'],
            'routes/api'      => ['LOWER_NAME', 'HYPHEN_NAME'],
            'webpack'         => ['LOWER_NAME', 'HYPHEN_NAME'],
            'json'            => ['LOWER_NAME', 'HYPHEN_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index'     => ['LOWER_NAME', 'HYPHEN_NAME'],
            'views/master'    => ['LOWER_NAME', 'HYPHEN_NAME', 'STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'composer'        => [
                'LOWER_NAME',
                'HYPHEN_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
            ],
        ],
        'gitkeep' => true,
    ],

    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path('packages/code-for-food'),

        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

        'assets' => public_path('modules'),

        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path('database/migrations'),

        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */

        'generator' => [
            'config'          => ['path' => 'config',                     'generate' => true],
            'command'         => ['path' => 'src/Console',                'generate' => true,  'namespace' => "Console"],
            'migration'       => ['path' => 'database/migrations',        'generate' => true],
            'seeder'          => ['path' => 'database/seeders',           'generate' => true,  'namespace' => "Database\\Seeders"],
            'factory'         => ['path' => 'database/factories',         'generate' => true,  'namespace' => "Database\\Factories"],
            'model'           => ['path' => 'src/Models',                 'generate' => true,  'namespace' => "Models"],
            'routes'          => ['path' => 'routes',                     'generate' => true],
            'controller'      => ['path' => 'src/Http/Controllers',       'generate' => true,  'namespace' => "Http\\Controllers"],
            'filter'          => ['path' => 'src/Http/Middleware',        'generate' => true,  'namespace' => "Http\\Middleware"],
            'request'         => ['path' => 'src/Http/Requests',          'generate' => true,  'namespace' => "Http\\Requests"],
            'provider'        => ['path' => 'src/Providers',              'generate' => true,  'namespace' => "Providers"],
            'assets'          => ['path' => 'resources/assets',           'generate' => true],
            'lang'            => ['path' => 'resources/lang',             'generate' => true],
            'views'           => ['path' => 'resources/views',            'generate' => true],
            'test'            => ['path' => 'tests/Unit',                 'generate' => true,  'namespace' => "Tests\\Unit"],
            'test-feature'    => ['path' => 'tests/Feature',              'generate' => true,  'namespace' => "Tests\\Feature"],
            'repository'      => ['path' => 'src/Repositories',           'generate' => false, 'namespace' => "Repositories"],
            'event'           => ['path' => 'src/Events',                 'generate' => false, 'namespace' => "Events"],
            'listener'        => ['path' => 'src/Listeners',              'generate' => false, 'namespace' => "Listeners"],
            'policies'        => ['path' => 'src/Policies',               'generate' => false, 'namespace' => "Policies"],
            'rules'           => ['path' => 'src/Rules',                  'generate' => false, 'namespace' => "Rules"],
            'jobs'            => ['path' => 'src/Jobs',                   'generate' => false, 'namespace' => "Jobs"],
            'emails'          => ['path' => 'src/Emails',                 'generate' => false, 'namespace' => "Emails"],
            'notifications'   => ['path' => 'src/Notifications',          'generate' => false, 'namespace' => "Notifications"],
            'resource'        => ['path' => 'src/Transformers',           'generate' => false, 'namespace' => "Transformers"],
            'component-view'  => ['path' => 'resources/views/components', 'generate' => false],
            'component-class' => ['path' => 'src/View/Component',         'generate' => false, 'namespace' => "View\\Component"],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example you don't use some of the commands provided
    | you can simply comment them out.
    |
    */

    'commands' => [
        Commands\CommandMakeCommand::class,
        Commands\ComponentClassMakeCommand::class,
        Commands\ComponentViewMakeCommand::class,
        Commands\ControllerMakeCommand::class,
        Commands\DisableCommand::class,
        Commands\DumpCommand::class,
        Commands\EnableCommand::class,
        Commands\EventMakeCommand::class,
        Commands\JobMakeCommand::class,
        Commands\ListenerMakeCommand::class,
        Commands\MailMakeCommand::class,
        Commands\MiddlewareMakeCommand::class,
        Commands\NotificationMakeCommand::class,
        Commands\ProviderMakeCommand::class,
        Commands\RouteProviderMakeCommand::class,
        Commands\InstallCommand::class,
        Commands\ListCommand::class,
        Commands\ModuleDeleteCommand::class,
        Commands\ModuleMakeCommand::class,
        Commands\FactoryMakeCommand::class,
        Commands\PolicyMakeCommand::class,
        Commands\RequestMakeCommand::class,
        Commands\RuleMakeCommand::class,
        Commands\MigrateCommand::class,
        Commands\MigrateRefreshCommand::class,
        Commands\MigrateResetCommand::class,
        Commands\MigrateRollbackCommand::class,
        Commands\MigrateStatusCommand::class,
        Commands\MigrationMakeCommand::class,
        Commands\ModelMakeCommand::class,
        Commands\PublishCommand::class,
        Commands\PublishConfigurationCommand::class,
        Commands\PublishMigrationCommand::class,
        Commands\PublishTranslationCommand::class,
        Commands\SeedCommand::class,
        Commands\SeedMakeCommand::class,
        Commands\SetupCommand::class,
        Commands\UnUseCommand::class,
        Commands\UpdateCommand::class,
        Commands\UseCommand::class,
        Commands\ResourceMakeCommand::class,
        Commands\TestMakeCommand::class,
        Commands\LaravelModulesV6Migrator::class,
        Commands\ComponentClassMakeCommand::class,
        Commands\ComponentViewMakeCommand::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for composer.json file, generated by this package
    |
    */

    'composer' => [
        'vendor' => 'code-for-food',
        'author' => [
            'name' => 'Lam Pham',
            'email' => 'phamkhaclam90@gmail.com',
        ],
        'composer-output' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */

    'cache' => [
        'enabled' => false,
        'key' => 'laravel-modules',
        'lifetime' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */

    'register' => [
        'translations' => true,

        /**
         * Load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
    */

    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604800,
        ],
    ],

    'activator' => 'file',
];
