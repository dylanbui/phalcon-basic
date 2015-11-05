<?php

namespace App\Controllers\Index;

use App\Base\Controller;

class ControllerBase extends Controller
{

	public function afterExecuteRoute()
	{
//		$this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
	}
}
