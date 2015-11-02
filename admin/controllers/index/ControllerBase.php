<?php

namespace Admin\Controllers\Index;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

	public function afterExecuteRoute()
	{
//		$this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
	}
}
