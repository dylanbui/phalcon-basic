<?php

namespace App\Controllers;

use Phalcon\Mvc\User\Component;

/*
 * Dung de tao nhung phan code co load action luon, hay tao code thu vien HTML (footer, header)
 * */

class LayoutComponent extends Component
{
    public function getMenu()
    {
        // ...
        $this->view->valGlobal = $this->view->valGlobal." => CommonComponent";
        $this->view->currentUser = "Bui Van Tien Duceee";
        $this->view->contentRender = "getMenu : CommonComponent ==";
        return $this->view->partial('layout-component/header');
    }

    public function getTabs()
    {
        echo "LayoutComponent : getTabs()";
        // ...
//        $this->view->contentRender = "getTabs : CommonComponent ==";
//        echo $this->view->partial('Common/tabs');
    }
}