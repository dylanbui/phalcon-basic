<?php

$router = new Phalcon\Mvc\Router(false);
$router->removeExtraSlashes(true);

// -- Nhung router custom thi de phia sau, no se match voi router gan giong nhat --
// Custom router
//$router->add('/admin/:params', array(
//    'namespace' => 'MyApp\Controllers\Index',
//    'controller' => 'index',
//    'action' => 'show',
//    'params' => 1,
//));

$router->add('/', array(
    'sub-name' => 'index',
    'controller' => 'index',
    'action' => 'index'
));

$router->add('/([a-zA-Z0-9\_\-]+)/:controller/:action/:params', array(
    'sub-name' => 1,
    'controller' => 2,
    'action' => 3,
    'params' => 4
));

$router->add('/([a-zA-Z0-9\_\-]+)/:controller[/]{0,1}', array(
    'sub-name' => 1,
    'controller' => 2,
    'action' => 'index'
));

$router->add('/([a-zA-Z0-9\_\-]+)[/]{0,1}', array(
    'sub-name' => 1,
    'controller' => 'index',
    'action' => 'index'
));

return $router;