<?php

namespace App\Base;

class AdminController extends \Phalcon\Mvc\Controller
{
    public function afterExecuteRoute()
    {
//		$this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
    }
}