<?php
/*
 * https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Error
*/
namespace MyApp;

use Phalcon\Di;

/**
 * Class Error
 * @package Phalcon\Error
 *
 * @method int type()
 * @method string message()
 * @method string file()
 * @method string line()
 * @method \Exception exception()
 * @method bool isException()
 * @method bool isError()
 */
class Error
{
    /**
     * @var array
     */
    protected $attributes;
    /**
     * Class constructor sets the attributes.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $defaults = [
            'type'        => -1,
            'message'     => 'No error message',
            'file'        => '',
            'line'        => '',
            'exception'   => null,
            'isException' => false,
            'isError'     => false,
        ];
        $options = array_merge($defaults, $options);
        foreach ($options as $option => $value) {
            $this->attributes[$option] = $value;
        }
    }
    /**
     * Magic method to retrieve the attributes.
     *
     * @param  string $method
     * @param  array  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return isset($this->attributes[$method]) ? $this->attributes[$method] : null;
    }
}


class ErrorHandler
{
    /**
     * Registers itself as error and exception handler.
     *
     * @return void
     */
    public static function register()
    {
        switch (APPLICATION_ENV) {
            case Application::ENV_PRODUCTION:
            case Application::ENV_STAGING:
            default:
                ini_set('display_errors', 0);
                error_reporting(0);
                break;
            case Application::ENV_TEST:
            case Application::ENV_DEVELOPMENT:
                ini_set('display_errors', 1);
                error_reporting(-1);
                break;
        }

        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (!($errno & error_reporting())) {
                return;
            }

            $options = [
                'type'    => $errno,
                'message' => $errstr,
                'file'    => $errfile,
                'line'    => $errline,
                'isError' => true,
            ];

            static::handle(new Error($options));
        });

        set_exception_handler(function (\Exception $e) {
            $options = [
                'type'        => $e->getCode(),
                'message'     => $e->getMessage(),
                'file'        => $e->getFile(),
                'line'        => $e->getLine(),
                'isException' => true,
                'exception'   => $e,
            ];

            static::handle(new Error($options));
        });

        register_shutdown_function(function () {
            if (!is_null($options = error_get_last())) {
                static::handle(new Error($options));
            }
        });
    }

    /**
     * Logs the error and dispatches an error controller.
     *
     * @param  Error $error
     * @return mixed
     */
    public static function handle(Error $error)
    {
        $view_file = 'error_php';
        if($error->isException())
        {
            if($error->exception() instanceof \Phalcon\Mvc\View\Exception ||
                $error->exception() instanceof \Phalcon\Mvc\Dispatcher\Exception)
            {
                if(APPLICATION_ENV == Application::ENV_PRODUCTION ||
                    APPLICATION_ENV == Application::ENV_STAGING)
                    $view_file = 'error_404';
            }
        }


        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir(__APP_PATH);

        $view->start();
        //Shows recent posts view (app/errors/recent.phtml)
        $view->setVars(array('error' => $error));
        $view->render('errors', $view_file);
        $view->finish();

        //Printing views output
        echo $view->getContent();
        exit;
    }

    /**
     * Maps error code to a string.
     *
     * @param  integer $code
     * @return string
     */
    public static function getErrorType($code)
    {
        switch ($code) {
            case 0:
                return 'Uncaught exception';
            case E_ERROR:
                return 'E_ERROR';
            case E_WARNING:
                return 'E_WARNING';
            case E_PARSE:
                return 'E_PARSE';
            case E_NOTICE:
                return 'E_NOTICE';
            case E_CORE_ERROR:
                return 'E_CORE_ERROR';
            case E_CORE_WARNING:
                return 'E_CORE_WARNING';
            case E_COMPILE_ERROR:
                return 'E_COMPILE_ERROR';
            case E_COMPILE_WARNING:
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR:
                return 'E_USER_ERROR';
            case E_USER_WARNING:
                return 'E_USER_WARNING';
            case E_USER_NOTICE:
                return 'E_USER_NOTICE';
            case E_STRICT:
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR:
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED:
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED:
                return 'E_USER_DEPRECATED';
        }

        return $code;
    }

    /**
     * Maps error code to a log type.
     *
     * @param  integer $code
     * @return integer
     */
    public static function getLogType($code)
    {
        switch ($code) {
            case E_ERROR:
            case E_RECOVERABLE_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_PARSE:
                return Logger::ERROR;
            case E_WARNING:
            case E_USER_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
                return Logger::WARNING;
            case E_NOTICE:
            case E_USER_NOTICE:
                return Logger::NOTICE;
            case E_STRICT:
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                return Logger::INFO;
        }

        return Logger::ERROR;
    }
}