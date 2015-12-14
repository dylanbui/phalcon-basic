<?php
$arrConfig = array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'pc-cms',
    ),
    'application' => array(
//        'controllersDir' => __SOURCE_PATH . '/app/controllers/',
//        'modelsDir'      => __APP_PATH . 'models/',
//        'viewsDir'       => __APP_PATH . 'views/',
        'libraryDir'     => __SOURCE_PATH . '/app/library/',
        'cacheDir'       => __SOURCE_PATH . '/app/cache/'
//        'baseUri'        => '/pc-cms/'
    )
);

$arrConfig['routers']['/admin-thu-1/:params'] = array(
    'namespace' => 'MyApp\Controllers\Index',
    'controller' => 'index',
    'action' => 'show',
    'params' => 1,
);

$arrConfig['routers']['/admin-thu-2/:params'] = array(
    'namespace' => 'MyApp\Controllers\Index',
    'controller' => 'index',
    'action' => 'show',
    'params' => 1,
);

//return new \Phalcon\Config($arrConfig);
return $arrConfig;