<?php

namespace App\Controllers\Index;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
//        $this->view->pick('index/index/pick_index');
        $this->view->render_title = 'Title : renderAction';
        $this->view->tip = 'Tip : renderAction';

        $this->view->render('index','indexaaaa', array('tip'=>'tien tip'));
        exit();
    }

    public function listItemAction($str = null)
    {
        $this->view->fileAction = '[' . __METHOD__ . ']';
        $this->view->render_title = 'Title : renderAction';
        $this->view->tip = 'Tip : renderAction';
        exit;
    }

    public function testRenderAction($str = null)
    {
        echo "testRenderAction<br>";
        echo '[' . __METHOD__ . ']';
        exit();
    }


    public function showItemAction($str = null)
    {

        $this->dispatcher->forward(array(
            'namespace' => 'App\Controllers\IndexShowNamespace',
            'controller' => 'UsersManager',
            'action' => 'acceptForward'
        ));


//        $this->dispatcher->forward(array(
//            'namespace' => 'MyApp\Controllers\Admin',
//            'controller' => 'Index',
//            'action' => 'showAllItem'
//        ));

//        echo "<pre>";
//        print_r('deo biet');
//        echo "</pre>";
//        exit();
//        $this->view->fileAction = '[' . __METHOD__ . ']';
//        $this->view->render_title = 'Title : renderAction';
//        $this->view->tip = 'Tip : renderAction';
    }
}
