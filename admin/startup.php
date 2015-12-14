<?php
// Define application environment => 'production'; 'staging'; 'test'; 'development';
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

//if(!defined('APPLICATION_ENV')) {
//    if(FALSE === stripos($_SERVER['SERVER_NAME'], 'www.example.com')) {
//        define(APPLICATION_ENV, 'development');
//    } else {
//        define(APPLICATION_ENV, 'production');
//    }
//}

    $loader = new \Phalcon\Loader();
    $loader->registerNamespaces(
        array (
            'Helper' => __SOURCE_PATH.'/app/helper',
            'PCLib' => $config['application']['libraryDir'],
            'Phalcon' => $config['application']['libraryDir'].'Phalcon/',
            'App\Models' => __SOURCE_PATH.'/app/models/'
        )
    );
    // Register autoloader
    $loader->register();


