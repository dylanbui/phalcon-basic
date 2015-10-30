<?php

namespace MyApp\Controllers\Site;

class UsersController extends ControllerBase
{

    public function indexAction()
    {
    	echo '[' . __METHOD__ . ']';
        $this->view->my_file = '[' . __METHOD__ . ']';
    }
}
