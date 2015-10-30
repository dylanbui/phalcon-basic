<?php

namespace MyApp\Controllers\Admin;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
    	echo '[' . __METHOD__ . ']';
    }

    public function showAction()
    {
        echo '[' . __METHOD__ . ']';
        echo "<pre>";
        print_r($this->dispatcher->getNamespaceName());
        echo "</pre>";
        exit();
    }

    public function showAllItemAction()
    {
        echo '[' . __METHOD__ . ']';
        echo "<pre>";
        print_r($this->dispatcher->getNamespaceName());
        echo "</pre>";
    }
}
