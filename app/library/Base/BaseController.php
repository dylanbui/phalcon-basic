<?php

namespace App\Base;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    public function afterExecuteRoute()
    {
//		$this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
    }
}