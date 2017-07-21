<?php
/*
|--------------------------------------------------------------------------
| Your Application's PHP classes auto-loading
|
| All classes in PIMF are statically mapped. It's just a simple array of
| class to file path maps for ultra-fast file loading.
|--------------------------------------------------------------------------
*/
spl_autoload_register(
    function ($class) {

        // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
        // FEEL FREE TO CHANGE THE MAPPINGS AND DIRECTORIES
        // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

        /**
         * The mappings from class names to file paths.
         */
        static $mappings = [
            'Articles\\Application\\Dispatcher' => '/Articles/Application/Dispatcher.php',
            'Articles\\DataMapper\\Article' => '/Articles/DataMapper/Article.php',
            'Articles\\Model\\Article' => '/Articles/Model/Article.php',
            'Articles\\Service\\FindExistingArticle' => '/Articles/Service/FindExistingArticle.php',
            'Articles\\Service\\ListApiUsageOptions' => '/Articles/Service/ListApiUsageOptions.php',
            'Articles\\Service\\CreateNewArticle' => '/Articles/Service/CreateNewArticle.php',
            'Articles\\Service\\UpdateExistingArticle' => '/Articles/Service/UpdateExistingArticle.php',
            'Articles\\Service\\DeleteExistingArticle' => '/Articles/Service/DeleteExistingArticle.php',
            'Articles\\Service\\WriteAllowedRequestMethods' => '/Articles/Service/WriteAllowedRequestMethods.php',
        ];

        // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
        //  END OF USER CONFIGURATION!!!
        // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

        // load the class from the static heap of classes.
        if (isset($mappings[$class])) {
            return require __DIR__ . DIRECTORY_SEPARATOR . $mappings[$class];
        }

        return false;
    }
);
