<?php
/*
|--------------------------------------------------------------------------
| PIMF Application Configuration
|--------------------------------------------------------------------------
|
| The PIMF configuration is responsible for returning an array
| of configuration options. By default, we use the variable $config provided 
| with PIMF - however, you are free to use your own storage mechanism for 
| configuration arrays.
|
*/
return [

    /*
    |------------------------------------------------------------------------
    | The default environment mode for your application [testing|production]
    |------------------------------------------------------------------------
    */
    'environment' => 'production',

    /*
    |------------------------------------------------------------------------
    | The default character encoding used by your application.
    |------------------------------------------------------------------------
    */
    'encoding'    => 'UTF-8',

    /*
    |------------------------------------------------------------------------
    | The default timezone of your application.
    | Supported timezones list: http://www.php.net/manual/en/timezones.php
    |------------------------------------------------------------------------
    */
    'timezone'    => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Is it regular HTTP or secure HTTPS
    |--------------------------------------------------------------------------
    */
    'ssl'         => false,

    /*
    |------------------------------------------------------------------------
    | Application meta
    |------------------------------------------------------------------------
    */
    'app'         => [

        'name'               => 'Articles',

        // secret application key or try out http://randomkeygen.com
        'key'                => 'some5secret5key5here',

        // the name of the fallback controller
        'default_controller' => 'articles',

        // get cleaner URLs or not
        'routeable'          => true,

        // URL used to access your application without a trailing slash.
        'url'                => 'http://10.0.49.227:666',

        // if using mod_rewrite to get cleaner URLs let it empty otherwise set index.php
        'index'              => '',

        // the base URL used for your application's asset files
        'asset_url'          => '',
    ],

    /*
    |------------------------------------------------------------------------
    | Nuclear Reactor settings
    |------------------------------------------------------------------------
    */
    'reactive'    => [
        'host' => '0.0.0.0',
        'port' => 666,
    ],

    /*
    |------------------------------------------------------------------------
    | Production environment settings
    |------------------------------------------------------------------------
    */
    'production'  => [
        'db' => [
            'driver'   => 'sqlite',
            'database' => 'app/Articles/_database/blog-production.db',
            'options'  => [
                \PDO::ATTR_PERSISTENT               => false,
                \PDO::ATTR_ERRMODE                  => \PDO::ERRMODE_EXCEPTION,
            ],
        ],
    ],

    /*
    |------------------------------------------------------------------------
    | Bootstrapping meta
    |------------------------------------------------------------------------
    */
    'bootstrap'   => [
        'local_temp_directory' => '/tmp/',
    ],

    /*
    |------------------------------------------------------------------------
    | Settings for the error handling behavior
    |------------------------------------------------------------------------
    */
    'error'       => [

        // set which error-levels should be ignored
        // find more http://de2.php.net/manual/errorfunc.constants.php
        'ignore_levels' => [E_USER_DEPRECATED],

        // developing=true production=false
        'debug_info'    => false,

        'log' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Session settings
    |--------------------------------------------------------------------------
    */
    'session'     => [

        // Session storage 'cookie', 'file', 'pdo', 'memcached', 'apc', 'redis',
        // 'dba', 'wincache', 'memory'  or '' for non
        'storage'            => '',

        // If using file storage - default is null
        'storage_path'       => 'app/Articles/_session/',

        // If using the PDO (database) session storage
        'database'           => [
            'driver'   => 'sqlite',
            'database' => 'app/Articles/_session/blog-session.db',
        ],

        // Garbage collection has a 2% chance of occurring for any given request to
        // the application. Feel free to tune this to your requirements.
        'garbage_collection' => [2, 100],

        // Session lifetime number of minutes
        'lifetime'           => 60,

        // Session expiration on web browser close
        'expire_on_close'    => false,

        // Session cookie name
        'cookie'             => 'pimf_session',

        // Session cookie path
        'path'               => '/',

        // Domain for which the session cookie is available.
        'domain'             => null,

        // If the cookie should only be sent over HTTPS.
        'secure'             => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache settings
    |--------------------------------------------------------------------------
    */
    'cache'       => [

        // Cache storage 'pdo', 'file', 'memcached', 'apc', 'redis', 'dba',
        // 'wincache', 'memory' or '' for non
        'storage'      => '',

        // If using file storage - default is null
        'storage_path' => 'app/Articles/_cache/',

        // If using the PDO (database) cache storage
        'database'     => [
            'driver'   => 'sqlite',
            'database' => 'app/Articles/_cache/blog-cache.db',
        ],

        // If using Memcached and APC to prevent collisions with other applications on the server.
        'key'          => 'pimfmaster',

        // Memcached servers - for more check out: http://memcached.org
        'memcached'    => [
            'servers' => ['host' => '127.0.0.1', 'port' => 11211, 'weight' => 100],
        ],
    ],

];
