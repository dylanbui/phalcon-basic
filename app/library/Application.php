<?php
/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 10/23/15
 * Time: 3:48 PM
 *
 * Application driver class to initialize Phalcon and
 * other resources.
 */

namespace App;

use Phalcon\DiInterface,
    Phalcon\DI\FactoryDefault,
    Phalcon\Mvc\View,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Events\Manager as EventsManager,
    Phalcon\Mvc\Router,
    Phalcon\Mvc\Url as UrlResolver,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
    Phalcon\Mvc\View\Engine\Volt as VoltEngine,
    Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter,
    Phalcon\Session\Adapter\Files as SessionAdapter,
    Phalcon\Session\Adapter\Database as SessionDatabase,
    Phalcon\Text;

class Application extends \Phalcon\Mvc\Application
{
    private $config = null;

    const ENV_PRODUCTION   = 'production';
    const ENV_STAGING      = 'staging';
    const ENV_TEST         = 'test';
    const ENV_DEVELOPMENT  = 'development';

    public function __construct(DiInterface  $dependencyInjector = null, $config = null)
    {
        ErrorHandler::register();
        $this->config = $config;

        parent::__construct($dependencyInjector);
    }

    protected function _registerView($config)
    {
        /**
         * Setting up the view component
         */
        $this->getDI()->set('view', function() use ($config) {
            $view = new View();
//            $view->setViewsDir($this->config['application']['viewsDir']);
            $view->setViewsDir(__APP_PATH.'views/');
            $view->registerEngines(array(
                '.volt' => function($view, $di) use ($config) {

                    $volt = new VoltEngine($view, $di);

                    $volt->setOptions(array(
                        'compiledPath' => $this->config['application']['cacheDir'],
                        'compiledSeparator' => '_'
                    ));

                    return $volt;
                },
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php' // Generate Template files uses PHP itself as the template engine
            ));
            return $view;
        }, true);
    }

    /**
     * Database connection is created based in the parameters defined in the configuration file
     */
    protected function _registerDatabase($config)
    {
        $this->getDI()->set('db', function() use ($config) {
            return new DbAdapter(array(
                'host' => $this->config['database']['host'],
                'username' => $this->config['database']['username'],
                'password' => $this->config['database']['password'],
                'dbname' => $this->config['database']['dbname']
            ));
        });
    }

    /**
     * Start the session the first time some component request the session service
     */
    protected function _registerSession()
    {
//        $this->getDI()->setShared('session', function() {
        $this->getDI()->setShared('session', function() {
//            $session = new SessionAdapter();
//            $session->start();
//            return $session;

            // Create a connection
//            $connection = new DbAdapter(array(
//                'host' => $this->config['database']['host'],
//                'username' => $this->config['database']['username'],
//                'password' => $this->config['database']['password'],
//                'dbname' => $this->config['database']['dbname']
//            ));

            $connection = $this->getDI()->get('db');
            $session = new SessionDatabase(array(
                'db' => $connection,
                'table' => 'session_data'
            ));

            $session->start();
            return $session;
        });

    }

    /**
     * Register the services here to make them general or register in
     * the ModuleDefinition to make them module-specific.
     */
    protected function _registerRouters($config)
    {
        $this->getDI()->set('router', function () {

            $router = new Router(false);
            $router->removeExtraSlashes(true);

            // -- Load custom router --
            foreach ($this->config['routers'] as $link => $itemRouter)
                $router->add($link, $itemRouter);

            $router->add('/([a-zA-Z0-9\_\-]+)/:controller/:action/:params', array(
                'sub-path' => 'app',
                'sub-module' => 1,
                'controller' => 2,
                'action' => 3,
                'params' => 4
            ))->convert('action', function($action){
                return Text::camelize($action);
            });;

            $router->add('/([a-zA-Z0-9\_\-]+)/:controller[/]{0,1}', array(
                'sub-path' => 'app',
                'sub-module' => 1,
                'controller' => 2,
                'action' => 'index'
            ));

            $router->add('/([a-zA-Z0-9\_\-]+)[/]{0,1}', array(
                'sub-path' => 'app',
                'sub-module' => 1,
                'controller' => 'index',
                'action' => 'index'
            ));

            $router->add('[/]{0,1}', array(
                'sub-path' => 'app',
                'sub-module' => 'index',
                'controller' => 'index',
                'action' => 'index'
            ));

            // -- Nhung router Admin thi de phia sau, no se match voi router gan giong nhat --

            $router->add('/admin/([a-zA-Z0-9\_\-]+)/:controller/:action/:params', array(
                'sub-path' => 'admin',
                'sub-module' => 1,
                'controller' => 2,
                'action' => 3,
                'params' => 4
            ))->convert('action', function($action){
                return Text::camelize($action);
            });;

            $router->add('/admin/([a-zA-Z0-9\_\-]+)/:controller[/]{0,1}', array(
                'sub-path' => 'admin',
                'sub-module' => 1,
                'controller' => 2,
                'action' => 'index'
            ));

            $router->add('/admin/([a-zA-Z0-9\_\-]+)[/]{0,1}', array(
                'sub-path' => 'admin',
                'sub-module' => 1,
                'controller' => 'index',
                'action' => 'index'
            ));

            $router->add('/admin[/]{0,1}', array(
                'sub-path' => 'admin',
                'sub-module' => 'index',
                'controller' => 'index',
                'action' => 'index'
            ));

            return $router;

        }, true);
    }

    protected function _registerDispatcher($config)
    {
        $this->getDI()->set('dispatcher', function(){
            $dispatcher = new Dispatcher();

            // Create an EventsManager
            $eventsManager = new EventsManager();

            $eventsManager->attach('dispatch:beforeException', function($event, $dispatcher, $exception) {
                // -- Overwrite ErrorHandler --
                }
            );

            //Attach a listener for type "dispatch"
//            $eventsManager->attach("dispatch", function($event, $dispatcher) {
//                echo "dispatch<br>";
//                $actionName = lcfirst(\Phalcon\Text::camelize($dispatcher->getActionName()));
//                $dispatcher->setActionName($actionName);
//            });

            // Attach a listener
            $eventsManager->attach("dispatch:beforeDispatchLoop", function ($event, $dispatcher) {
                echo "<pre><b>";
                print_r($event->getType());
                echo "</pre></b>";

                $sub_path = $dispatcher->getParam('sub-path');
                if(!empty($sub_path)) {
                    $sub_module = $dispatcher->getParam('sub-module');
                    $dispatcher->setNamespaceName(Text::camelize($sub_path)."\\Controllers\\".Text::camelize($sub_module));
//                    $view = $dispatcher->getDI()->get('view');
//                    $view->setViewsDir(__SOURCE_PATH."/{$sub_path}/views/");

//                    echo "<pre>";
//                    print_r(__SOURCE_PATH."/{$sub_path}/{$sub_module}/views/");
//                    echo "</pre>";
//                    exit();

                }


//                $sub_module = $dispatcher->getParam('sub-module');
//                if(!empty($sub_module)) {
////                    $dispatcher->setDefaultNamespace("MyApp\\Controllers\\".Text::camelize($sub_module));
//                    $dispatcher->setNamespaceName("MyApp\\Controllers\\".Text::camelize($sub_module));
////                    $dispatcher->getDI()->get('router')->setDefaultNamespace("MyApp\\Controllers\\".Text::camelize($sub_module));
//                }

                // -- Load view file by 'pick' function --
//                $controller = $dispatcher->getDI()->get('router')->getControllerName();
//                $action = $dispatcher->getDI()->get('router')->getActionName();
//                $dispatcher->getDI()->get('view')->pick("{$sub_module}/{$controller}/{$action}");

                // Override parameters
//                $dispatcher->setParams(array('pick-view-path' => "{$sub_module}/{$controller}/{$action}"));

                echo "<b>FIX action name<b>";
//                $controllerName = Text::camelize($dispatcher->getControllerName());
//                $dispatcher->setControllerName($controllerName);

//                $actionName = lcfirst(Text::camelize($dispatcher->getActionName()));
//                $dispatcher->setActionName($actionName);

                echo "<pre>";
                print_r($this->dispatcher->getNamespaceName().' ---------- '.$dispatcher->getControllerName() . ' ----- ' . $dispatcher->getActionName());
                echo "</pre>";
                echo "        <b>--------------------<b>";

            });

            $eventsManager->attach("dispatch:beforeDispatch", function($event, $dispatcher) {

//                echo "<pre><b>";
//                print_r($event->getType());
//                echo "</pre></b>";
//
//                echo "<pre>";
//                print_r($dispatcher->getControllerName() . ' ----- ' . $dispatcher->getActionName());
//                echo "</pre>";
//                $actionName = lcfirst(\Phalcon\Text::camelize($dispatcher->getActionName()));
//                $this->dispatcher->setActionName($actionName);



            });

            $eventsManager->attach("dispatch:beforeExecuteRoute", function ($event, $dispatcher) {


                echo "<pre><b>";
                print_r($event->getType());
                echo "</pre></b>";

//                echo "<pre>";
//                print_r($this->dispatcher->getNamespaceName());
//                echo "</pre>";
//
//                echo "<pre>";
//                print_r($this->dispatcher->getControllerName());
//                echo "</pre>";
//
//                echo "<pre>";
//                print_r($this->dispatcher->getActionName());
//                echo "</pre>";


//                $namespace = str_replace("MyApp\\Controllers\\", '', $dispatcher->getNamespaceName());
                // -- Get last item in namespace controller --
                $arrExplode = explode('\\',$dispatcher->getNamespaceName());
                $sub_path = str_replace('_', '-', Text::uncamelize($arrExplode[0]));
//                $namespace = end($arrExplode);
                $namespace = str_replace('_', '-', Text::uncamelize(end($arrExplode)));
                $controller = str_replace('_', '-', Text::uncamelize($dispatcher->getControllerName()));
                $action = str_replace('_', '-', Text::uncamelize($dispatcher->getActionName()));

                echo "<pre>";
                print_r("[PICK] - {$namespace}/{$controller}/{$action}");
                echo "</pre>";

                $view = $dispatcher->getDI()->get('view');
                $view->setViewsDir(__SOURCE_PATH."/{$sub_path}/views/");
                $view->setLayoutsDir($namespace.'/');
                $view->setLayout($namespace);


                // -- [BUG] Phalcon\Mvc\View::pick() disables layout --
                // -- https://github.com/phalcon/cphalcon/issues/670 --
                $view->pick(["{$namespace}/{$controller}/{$action}"]); // magic is in brackets

//                echo "<pre>";
//                print_r($view->getViewsDir());
//                echo "</pre>";
//                exit();


                // -- Function : $this->view->render => khong su dung duoc --

//                echo "<pre>321312";
//                print_r($dispatcher->getDI()->get('view'));
//                echo "</pre>";
//                exit();

                // -- Day la 1 cach dung 'sub-module' nhung phai kiem tra ca 2 truong hop
//                $pick_view_path = $dispatcher->getParam('pick-view-path');
//                $view = $dispatcher->getDI()->get('view');
//                $view->pick($pick_view_path);
            });

            $eventsManager->attach("dispatch:afterDispatch", function($event, $dispatcher) {

//                echo "<pre><b>";
//                print_r($event->getType());
//                echo "</pre></b>";
//
//                $view = $dispatcher->getDI()->get('view');
//                echo "<pre>";
//                print_r($view->getLayoutsDir());
//                echo "</pre>";
//                exit();

            });

            $eventsManager->attach('application:viewRender', new CustomRenderer());

            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('MyApp\Controllers');
            return $dispatcher;
        });



    }

    public function main()
    {
        // -- Do not use \Exception because it was captured in ErrorHandle --

        $this->_registerDatabase($this->config);
        $this->_registerSession($this->config);
        $this->_registerRouters($this->config);
        $this->_registerView($this->config);
        $this->_registerDispatcher($this->config);

        echo $this->handle()->getContent();
    }
}

