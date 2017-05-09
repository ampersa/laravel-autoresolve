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
            __DIR__.'/../config/autoresolve.php' => config_path('autoresolve.php'),
        ]);

        // The autoresolve directory is set in the config/autoresolve.php configuration
        // file via the artisan_autoresolve_directory key. This should be set to a
        // valid directory containing Artisan Commands to be autoresolved here
        if (!empty(config('autoresolve.artisan_autoresolve_directory')) and is_dir(config('autoresolve.artisan_autoresolve_directory', 'App/Console/Command'))) {
            $autoResolvedCommands = [];

            $autoResolveDirectoryGlob = sprintf(config('autoresolve.artisan_autoresolve_pattern', '%s/*.php'), rtrim(config('autoresolve.artisan_autoresolve_directory'), '/'));

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
