<?php

namespace App\Controllers\Index;

class UsersManagerController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
    }
}
