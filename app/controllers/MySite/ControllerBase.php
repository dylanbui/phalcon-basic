<?php

namespace App\Controllers\MySite;

use App\Base\BaseController;

class ControllerBase extends BaseController
{

	public function afterExecuteRoute()
	{
//		$this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
	}
}
