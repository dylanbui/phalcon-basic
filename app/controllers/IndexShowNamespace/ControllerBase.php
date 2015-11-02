<?php

namespace App\Controllers\IndexShowNamespace;

use App\BaseController;

class ControllerBase extends BaseController
{

	public function afterExecuteRoute()
	{
//		$this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
	}
}
