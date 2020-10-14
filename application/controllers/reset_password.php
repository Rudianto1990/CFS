<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reset_password extends Controller {
	var $content = "";
	function Reset_password(){
		parent::Controller();
		$this->load->helper(array('form', 'url', 'captcha', 'security'));
		$this->load->library('form_validation');
	}
	function index(){
		$add_header  = '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/dist/sweetalert.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/app.min.css">';
$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/jquery-ui.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter/twitter.css">';
		$add_header .= '<script src="'.base_url().'assets/js/jquery.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/jquery-ui.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/app.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/jquery-ui.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/ui/notifications.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/vendor/sweetalert/dist/sweetalert.min.js"></script>';
		if($this->newsession->userdata('LOGGED')){
			redirect(base_url().'index.php/dashboard','refresh');
		}else{
			if($this->content==""){
				$this->content = $this->load->view('content/home/index','',true);
			}
			$data = array('_add_header_' => $add_header,
						  '_appname_' => 'CFS CENTER',
						  '_content_' => $this->content);
			$this->parser->parse('index', $data);
		}
	}

	function lupa_password(){
		if($this->content==""){
			$this->content = $this->load->view('content/home/reset_password','',true);
		}
		$this->index();
	}

	function token($token){
		$this->load->model('m_home');
		//$token = $this->uri->segment(3);
		$user_info = $this->m_home->isTokenValid($token); //either false or array();
		if(!$user_info){
			$this->session->set_flashdata('result_error', 'Link URL tidak valid atau kadaluarsa');
			redirect(site_url('home/forgot_password'),'refresh');
		}
		$data['token'] = $token;
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[2]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			$this->content = $this->load->view('content/home/reset_password', $data);
			$this->index();
		}else{
			$cleanPost = $user_info->ID;
			if(!$this->m_home->updatePassword($cleanPost)){
				$this->session->set_flashdata('result_error', 'Update password gagal.');
			}else{
				$this->session->set_flashdata('result', 'Password anda sudah diperbaharui. Silakan login.');
			}
			redirect(site_url(),'refresh');
		}
	}
}
