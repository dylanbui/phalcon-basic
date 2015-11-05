<?php

namespace App\Base;

class Controller extends \Phalcon\Mvc\Controller
{
    public function afterExecuteRoute()
    {
//		$this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
    }
}