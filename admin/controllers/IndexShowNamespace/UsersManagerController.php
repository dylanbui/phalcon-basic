<?php

namespace Admin\Controllers\IndexShowNamespace;

class UsersManagerController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
        echo "[' . __METHOD__ . ']'";


//        exit();
    }

    public function indexMainAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
//        exit();
    }

    public function acceptForwardAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
        echo '[' . __METHOD__ . ']';
//        exit();
    }
}
