<?php

namespace App\Controllers\Index;

class UsersManagerController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
    }

    public function saveSessionAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';

        // Set a session variable
        $this->session->set("User-name", "Michael Coporation");
        $this->session->session_data = $this->session->get("User-name");
    }

    public function getSessionAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
        $this->session->session_data = $this->session->get("User-name");
    }

}
