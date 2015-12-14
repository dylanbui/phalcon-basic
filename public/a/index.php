<?php
// Define application environment => 'production'; 'staging'; 'test'; 'development';
//defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

//if(!defined('APPLICATION_ENV')) {
//    if(FALSE === stripos($_SERVER['SERVER_NAME'], 'www.example.com')) {
//        define(APPLICATION_ENV, 'development');
//    } else {
//        define(APPLICATION_ENV, 'production');
//    }
//}

//https://docs.phalconphp.com/en/latest/reference/tutorial-invo.html
//error_reporting(E_ALL);

//echo "<pre>";
//print_r(basename($_SERVER['SCRIPT_NAME']));
//echo "<br>";
//print_r(dirname(dirname($_SERVER['SCRIPT_NAME'])));
//echo "</pre>";
//exit();

//echo "<pre>";
//print_r($_SERVER);
//echo "</pre>";
//exit();
//
//echo "<pre>";
//print_r($_REQUEST);
//echo "</pre>";

//use Phalcon\Mvc\Application,
//    Phalcon\DI\FactoryDefault,
//    Phalcon\Mvc\Url as UrlResolver;

// define the site path __SITE_PATH : c:\xampp\htdocs\adv_mvc
define ('__SITE_PATH', realpath(dirname(dirname(__FILE__))));
// __SITE_URL : /adv_mvc/
//  	define ('__SITE_URL', dirname(str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME'])).'/');
define ('__SITE_URL', str_replace('//','/', dirname(str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME'])).'/'));
// __BASE_URL : /adv_mvc/admin/
define ('__BASE_URL', str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']));
// Co thu muc public_html
define ('__PUBLIC_HTML', __SITE_URL.'public_html/');

// define the MySite path : c:\xampp\htdocs\pc-simple
define ('__SOURCE_PATH', realpath(dirname(dirname(dirname(__FILE__)))));

// define the MySite path __ADMIN_PATH : c:\xampp\htdocs\pc-simple\admin
//define ('__ADMIN_PATH', __SOURCE_PATH.'/admin/');

// define the MySite path __APP_PATH : c:\xampp\htdocs\pc-simple\app
define ('__APP_PATH', __SOURCE_PATH.'/admin/');

// __APP_URL : /pc-simple/public/
define ('__APP_URL', str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']));

// ---- Khong Thay Doi ---- //
//define ('__ADMIN_THEMES_URL', __APP_URL.'a/');

define ('__ASSET_URL', __PUBLIC_HTML.'assets/');
define ('__TEMPLATE_URL', __PUBLIC_HTML.'a/flaty_template/');

define ('__IMAGE_URL', __PUBLIC_HTML.'a/images/');
define ('__CSS_URL', __PUBLIC_HTML.'a/stylesheets/');
define ('__JS_URL', __PUBLIC_HTML.'a/javascripts/');


//define ('__ASSET_URL', __APP_URL.'assets/');
//define ('__IMAGE_URL', __ASSET_URL.'images/');
//define ('__CSS_URL', __ASSET_URL.'css/');
//define ('__JS_URL', __ASSET_URL.'js/');

 	$const = get_defined_constants(true);
 	echo "<pre>";
 	print_r($const['user']);
 	echo "</pre>";
 	exit();

//try {

/**
 * Read the configuration
 */
$config = include __APP_PATH . "config/config.php";

// Init a DI
$di = new \Phalcon\DI\FactoryDefault();

$loader = null;
include __SOURCE_PATH . "/admin/startup.php";
/**
 * Read auto-loader
 */
//    $loader = new \Phalcon\Loader();
//    $loader->registerNamespaces(
//        array (
//            'Helper' => __SOURCE_PATH.'/app/helper',
//            'PCLib' => $config['application']['libraryDir'],
//            'Phalcon' => $config['application']['libraryDir'].'Phalcon/'
////            'App\Controllers' => __APP_PATH.'controllers/',
////            'App\Models' => __APP_PATH.'models/',
////            'Admin\Controllers' => __ADMIN_PATH.'controllers/',
////            'Admin\Models' => __ADMIN_PATH.'models/'
////            'MyApp\Plugins' => $config->application->pluginsDir,
////            'MyApp\MyClass' => __APP_PATH.'myapp-class'
//        )
//    );
//    // Register autoloader
//    $loader->register();


//    use Helper\Common as Common;

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function() use ($config) {
    $url = new Phalcon\Mvc\Url(); //UrlResolver();
    $url->setBaseUri($config['application']['baseUri']);
    return $url;
}, true);

/**
 * Handle the request
 */
$application = new \PCLib\Application($di, 'app');
$application->config = $config;
$application->loader = $loader;

// -- Do not use \Exception because it was captured in ErrorHandle --
$application->run();
//    echo $application->handle()->getContent();

//} catch (\Exception $e) {
//
//    echo "<pre>";
//    print_r('Exception Application');
//    echo "</pre>";
//
//    echo "<pre>";
//    print_r($e);
//    echo "</pre>";
//    exit();
//
//
//    echo $e->getMessage();
//}
