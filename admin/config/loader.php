<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of Namespaces taken from the configuration file
 */

$loader->registerNamespaces(
    array (
        'MyApp' => $config->application->libraryDir,
        'MyApp\Controllers' => $config->application->controllersDir,
        'MyApp\Models' => $config->application->modelsDir
    )
);

// Register autoloader
$loader->register();
