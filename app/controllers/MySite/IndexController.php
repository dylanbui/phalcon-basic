<?php

namespace App\Controllers\MySite;


use Helper\Common;

class IndexController extends ControllerBase
{


	public function indexAction() 
	{
////		$_SESSION['test'] = 12;
//		$this->oSession->userdata['test'] = 12;
////	    $this->oView->title = 'Welcome to Bui Van Tien Duc MVC';
//	    $this->renderView('MySite/home/index');
	}
	
	public function captchaAction()
	{
//		// Load helper
//		helperLoader("captcha");
//
//		$vals = array(
//    		'img_path'	 => __DATA_PATH,
//    		'img_url'	 => __DATA_URL,
//			'font_path'	 =>	__DATA_PATH.'font/monofont.ttf',
//			'length'	 => 6,
//    		'img_width'	 => 150,
//    		'img_height' => 40,
//    		'expiration' => 3600
//    	);
//
//		$this->oView->cap = create_captcha($vals);
//		$this->renderView('MySite/index/captcha');
	}


	public function changeAction()
	{
        Common::redirect('http://google.com');
	}

    public function siteRenderHeaderAction($my_title)
    {
//        $this->oView->my_title = $my_title;
//        return $this->oView->fetch('MySite/index/site_render_header');
    }

    public function siteRenderFooterAction()
    {
//        return $this->oView->fetch('MySite/index/site_render_footer');
    }


	
	
}
