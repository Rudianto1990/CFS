<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monitoring extends Controller {
	var $content = "";
	function Monitoring(){
		parent::Controller();
       $this->load->library('newtable_edit');
	}

	function index(){
		$add_header  = '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/dist/sweetalert.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/app.min.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/newtable.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter/twitter.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/jquery-ui.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/alerts.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/uploadfile.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/bootstrap-fileinput/fileinput.css">';
		//$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/bootstrap-fileinput/themes/explorer/theme.css">';
		$add_header .= '<script src="'.base_url().'assets/js/jquery.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/vendor/bootstrap-fileinput/fileinput.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/vendor/bootstrap-fileinput/locales/id.js"></script>';
		//$add_header .= '<script src="'.base_url().'assets/vendor/bootstrap-fileinput/themes/explorer/theme.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/jquery-ui.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/newtable.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/vendor/sweetalert/dist/sweetalert.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/vendor/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/helpers/noty-defaults.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/alerts.js"></script>';
		$add_script  = '<script src="'.base_url().'assets/js/app.min.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/js/jquery-ui.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/js/ui/notifications.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/js/jquery.validate.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/js/jquery.maskedinput.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/js/jquery.uploadfile.min.js"></script>';
		if($this->newsession->userdata('LOGGED')){
			if($this->content==""){
				$this->content = $this->load->view('content/dashboard/index','',true);
			}
			$data = array('_add_header_'   => $add_header,
					'_add_script_'   => $add_script,
					'_tittle_'  	   => 'CFS CENTER',
					'_header_'  	   => $this->load->view('content/header','',true),
					'_breadcrumbs_'  => $this->load->view('content/breadcrumbs','',true),
					'_menus_'   	   => $this->load->view('content/menus','',true),
					'_content_' 	   => (grant()=="")?$this->load->view('content/error','',true):$this->content,
					'_footer_'  	   => $this->load->view('content/footer','',true),
					'_features_'     => $this->load->view('content/features','',true));
			$this->parser->parse('index', $data);
		}else{
			redirect(base_url('index.php'),'refresh');
		}
	}

	public function simkeu($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		//echo 'oke';die();
		$this->load->model('m_monitoring');
			$arrdata = $this->m_order->ppbarang($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
	}
}
