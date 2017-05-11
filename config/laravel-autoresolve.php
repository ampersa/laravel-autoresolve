<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Command Directories
    |--------------------------------------------------------------------------
    |
    | Here you can list the directories in which Commands to be autoresolved
    | are located. Each of the directories will be listed and any Commands
    | within will be resolved and automatically loaded to the Container.
    |
    */
    'autoresolve_commands_directory' => [

        'App/Console/Commands',
    
    ],

    /*
    |--------------------------------------------------------------------------
    | Commands Pattern
    |--------------------------------------------------------------------------
    |
    | Here you can specify the glob pattern to be used to locate Command files
    | within the Command directories. The directory is passed in via sprintf
    | so %s or ? may be used to placehold the directory path in the pattern
    |
    */
    'autoresolve_commands_pattern' => '%s/*.php',

];
