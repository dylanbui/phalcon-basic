<?php

namespace App\Controllers\MySite;

class HomeController extends BaseController
{

	var $_cfg_upload_file;
	var $_cfg_thumb_image;
	var $children;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_cfg_upload_file = array();
		$this->_cfg_upload_file['upload_path'] = __UPLOAD_DATA_PATH;
		$this->_cfg_upload_file['allowed_types'] = 'gif|jpg|png';
		$this->_cfg_upload_file['max_size']	= '500';
		$this->_cfg_upload_file['max_width']  = '2048';
		$this->_cfg_upload_file['max_height']  = '1536';

		$this->_cfg_thumb_image['create_thumb'] = TRUE;
		$this->_cfg_thumb_image['maintain_ratio'] = TRUE;
		$this->_cfg_thumb_image['width'] = 175;
		$this->_cfg_thumb_image['height'] = 0;
		
		$this->children = array();
	}

	public function indexAction() 
	{
		$this->oSession->userdata['test'] = 12;
	    $this->oView->title = 'Welcome to Bui Van Tien Duc MVC RENDER';
	    $this->renderView('MySite/home/index');
	}
	
	public function tinymceAction()
	{
		$this->oView->title = 'Welcome to Bui Van Tien Duc MVC RENDER';
		$this->renderView('MySite/home/tinymce');
	}

	public function ckeditorAction()
	{
		// Cho phep truy cap KCFINDER
		// Tranh truong hop truy cap thong wa duong link cua iframe
		$_SESSION['KCFINDER'] = array();
		$_SESSION['KCFINDER']['disabled'] = false; // Activate the uploader,
		
		if ($this->oInput->isPost()) 
		{
			$this->_cfg_upload_file['file_name']  = 'img_'.time();
			
			$uploadLib = new UploadLib($this->_cfg_upload_file);
			
			$returnValue = $uploadLib->do_multi_upload("content_file");
				
			if (empty($returnValue))
			{
				echo $uploadLib->display_errors();
				exit();
			}
			else
			{
				foreach ($returnValue as $fileData)
				{
					$this->_cfg_thumb_image['source_image']	= $fileData['full_path'];
					
					$imageLib = new ImageLib($this->_cfg_thumb_image);
					if ( ! $imageLib->resize())
					{
						echo $imageLib->display_errors();
						exit();
					}
				}
// 				echo "Upload thanh cong";
			}

// 			echo "<pre>";
// 			print_r($returnValue);
// 			echo "</pre>";
// 			exit();
		}
		
		
// 		$this->oView->title = 'Welcome to Bui Van Tien Duc MVC RENDER';
// 		$this->renderView('MySite/home/ckeditor');

		$this->_children[] = new Request('MySite/home/child-first');
		$this->_children[] = new Request('MySite/home/child-second',array('Title duoc truyen vao MySite/home/child-second'));
		
		
		$this->oView->title = 'Welcome to Bui Van Tien Duc MVC RENDER';
// 		$this->display('MySite/home/ckeditor');
		$this->renderView('MySite/home/ckeditor');
	}
	
	public function testResizeImageAction()
	{
		$this->_cfg_thumb_image['source_image']	= __UPLOAD_DATA_PATH."img_1387339644.jpg";//$fileData['full_path'];
		
		
		$imageLib = new ImageLib($this->_cfg_thumb_image);
		if ( ! $imageLib->resize())
		{
			echo $imageLib->display_errors();
			exit();
		}
		
		echo "<pre>";
		print_r($this->_cfg_thumb_image);
		echo "</pre>";
		exit();
		
		
		$this->renderView('MySite/home/test_resize_image');
	}
	
	public function partRenderAction($title)
	{
	    $this->oView->title = 'Day la phan noi dung duoc render vao';
	    $this->oView->render_title = $title;
	    return $this->oView->fetch('MySite/home/part_render');
	}
	
	public function renderAction()
	{
		$this->oSession->userdata['c'] = 2000;
		$this->oView->title_aaa = 'Day la trang dung chuc nang renderAction --- '.$this->oSession->userdata['test'];
		$this->oView->part_render = Module::run(new Request('MySite/home/part-render',array('Title duoc truyen vao '.$this->oSession->userdata['c'])));
//		$this->oView->part_render = Module::run('MySite/home/part-render/buivantienduc');
		$this->renderView('MySite/home/render');
	}

	public function checkLoginAction()
	{
// 		return new Request('MySite/home/deny',array('Title duoc truyen vao - DENY'));
	}	
	
	public function firstAction()
	{
		$this->oView->param_first = "Thong tin load tu firstAction";
	}
	
	public function secondAction()
	{
		$this->oView->param_second = "Thong tin load tu secondAction";	
	}
	
	public function denyAction($title_deny)
	{
		$this->oView->title_deny = $title_deny;
		$this->display('MySite/home/deny');
	}	

	private function display($path)
	{
		foreach ($this->children as $child) {
			$param_name = str_replace("-", "_", $child->getAction());
			$this->oView->{$param_name} = Module::run($child);
		}		
		
		$this->oView->main_content = $this->oView->fetch($path);
		$result = $this->oView->renderLayout($this->_layout_path);
		$this->oResponse->setOutput($result, $this->oConfig->config_values['application']['config_compression']);		
	}
	
	public function childFirstAction()
	{
		return "Thong tin load tu childFirstAction";
	}
	
	public function childSecondAction($title)
	{
		return "Thong tin load tu childSecondAction - title : " . $title;
	}

    public function siteRenderAction()
    {
        $this->oView->file_title = 'siteRenderAction';
        $this->oView->title = 'Title truyen vao cac trang con';
        $this->renderView('MySite/home/site_render');
    }



}
