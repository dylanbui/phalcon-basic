<?php

namespace App\Controllers\IndexShowNamespace;

class ControllerBase extends \App\Base\Controller
{

	public function afterExecuteRoute()
	{
//		$this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
	}
}
