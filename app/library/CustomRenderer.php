<?php
/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 10/27/15
 * Time: 6:16 PM
 */

namespace App;

class CustomRenderer extends \Phalcon\Mvc\User\Plugin
{
    public function viewRender($event, $application, $view)
    {
        echo "<pre>";
        print_r('fs fas da d as da s');
        echo "</pre>";
        exit();

        $dispatcher = $this->dispatcher;

        $controllerName = str_replace('\\', DIRECTORY_SEPARATOR, $dispatcher->getNamespaceName()) .
            DIRECTORY_SEPARATOR .
            $dispatcher->getControllerName();

        $view->render($controllerName, $dispatcher->getActionName(), $dispatcher->getParams());
        return false;
    }
}