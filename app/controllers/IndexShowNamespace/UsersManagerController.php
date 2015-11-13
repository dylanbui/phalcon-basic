<?php

namespace App\Controllers\IndexShowNamespace;

class UsersManagerController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
        echo '[' . __METHOD__ . ']';
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

    public function saveSessionAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';

        // Set a session variable
        $this->session->set("User-name", "Michael Coporation");
        $this->session->set("last-name", "Co Michael");
        $this->view->session_data = $this->session->get("User-name");
    }

    public function getSessionAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
        // Remove a session variable
        $this->session->remove("User-name");
        // Destroy the whole session
        $this->session->destroy();
        $this->view->session_data = $this->session->get("User-name");
    }


}
