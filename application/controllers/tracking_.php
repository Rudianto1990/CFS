<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tracking extends Controller {
    var $content = "";
    function Tracking() {
       parent::Controller();
      
    }
	
	function index(){
		$add_header  = '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/dist/sweetalert.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/app.min.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/newtable.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter/twitter.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/jquery-ui.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/alerts.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">';
		$add_header .= '<script src="'.base_url().'assets/js/jquery.min.js"></script>';
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
	

/*
	public function cek($id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
$id = ($id!="")?$id:$this->input->post('NO_BL_AWB');
$this->newtable->breadcrumb('Dashboard', site_url());
$this->newtable->breadcrumb('Tracking', 'javascript:void(0)');
$data['page_title'] = 'Tracking';
if(!$id)
{
$this->load->model("m_tracking");
$arrhdr = $this->m_tracking->execute('get','t_cocostscont',$id);
if(!$arrhdr)
{
	$this->session->set_flashdata('error', 'NO BL/AWB Yang Anda Masukan Tidak Terdaftar');
	$this->content = $this->load->view('content/tracking/index',$data,true);
}
else
{
$this->content = $this->load->view('content/tracking/detail',$data,true);
}
}
else
{
$this->content = $this->load->view('content/tracking/index',$data,true);
}
					$this->index();
			
	}

*/	


	public function cek($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('NO_BL_AWB');
		$this->load->model("m_tracking");
		if($act=='detail')
		{
			$this->newtable->breadcrumb('Dashboard', site_url());
			$this->newtable->breadcrumb('Tracking',  site_url('tracking/cek'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['page_title'] = 'Tracking';
			$data['arrhdr'] = $this->m_tracking->execute('get','t_cocostskms',$id);
			//$data['contennya'] = $this->load->view('content/tracking/detail');
			echo $this->load->view('content/tracking/detail',$data,true);
			//$this->index();
			//print_r($data['arrhdr']);
		}
		else
		{
			$this->newtable->breadcrumb('Dashboard', site_url());
			$this->newtable->breadcrumb('Tracking', 'javascript:void(0)');
			$data['page_title'] = 'Tracking';
			$this->content = $this->load->view('content/tracking/index',$data,true);
			$this->index();
		}		
	}

}