<?php

namespace Ampersa\LaravelAutoresolve;

use Illuminate\Support\ServiceProvider;

class LaravelAutoresolveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-autoresolve.php' => config_path('laravel-autoresolve.php'),
        ]);

        // The directories to be autoresolved are set via an array in the
        // config/laravel-autoresolve.php file. If this value is set and
        // is not empty then we know we must continue with the process
        if (!empty(config('laravel-autoresolve.autoresolve_commands_directories'))) {
            $autoResolvedCommands = [];
            
            // For each autoresolve directory that has been specified, we will iterate the
            // files matching the glob pattern found in "autoresolve_commands_pattern"
            // config value. This will give us the list of Commands to autoresolve.
            foreach (config('laravel-autoresolve.autoresolve_commands_directories') as $autoResolveDirectory) {
                $autoResolveDirectoryGlob = sprintf(config('laravel-autoresolve.autoresolve_commands_pattern', '%s/*.php'), rtrim($autoResolveDirectory, '/'));

                foreach (glob($autoResolveDirectoryGlob) as $fileName) {
                    // To resolve the namespaces classname from each command file, firstly extract
                    // the filename from the path string minus file extensions before parsing
                    // the file content and extracting the namespace definition line
                    $resolvedFileName = pathinfo($fileName, PATHINFO_FILENAME);

                    $namespace = 'App\\Console\\Commands';
                    $namespaceFinder = preg_match('/^namespace\s+(.+?);\s*/ism', file_get_contents($fileName), $namespaceMatches);
                    if ($namespaceFinder) {
                        $namespace = $namespaceMatches[1];
                    }

                    $resolvedClassName = sprintf('%s\\%s', $namespace, $resolvedFileName);
                    $autoResolvedCommands[] = $resolvedClassName;
                }
            }
            
            $this->commands($autoResolvedCommands);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
