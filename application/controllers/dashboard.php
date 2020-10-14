<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends Controller {
	var $content = "";
	function Dashboard(){
		parent::Controller();
	}
	
	function index(){
		
		$add_header  = '<link rel="stylesheet" href="'.base_url().'assets/css/app.min.css">';
		$add_header .= '<script src="'.base_url().'assets/js/jquery.min.js"></script>';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css">';
		$add_header .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$add_script  = '<script src="'.base_url().'assets/js/app.min.js"></script>';
		if($this->newsession->userdata('LOGGED')){
			if($this->content==""){
				$this->load->library('newtable');
				$this->newtable->breadcrumb('Home', site_url());
				$this->content = $this->load->view('content/dashboard/index','',true);	
			}

			$data = array('_add_header_'   => $add_header,
						  '_add_script_'   => $add_script,
						  '_header_'  	   => $this->load->view('content/header','',true),
						  '_breadcrumbs_'   => $this->load->view('content/breadcrumbs','',true),
						  '_menus_'   	   => $this->load->view('content/menus','',true),
						  '_content_' 	   => $this->content,
						  '_footer_'  	   => $this->load->view('content/footer','',true));
			$this->parser->parse('index', $data);
		}
		else
		{
			redirect(base_url('index.php'),'refresh');
		}
	}
	
	function signout(){
		$this->newsession->sess_destroy();
		redirect(base_url());
	}
	function test(){
		phpinfo();
	}
		
}