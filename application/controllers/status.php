<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Status extends Controller {
    var $content = "";
    function Status() {
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
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/bootstrap-fileinput/fileinput.css">';
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
		$add_script .= '<script src="'.base_url().'assets/vendor/bootstrap-fileinput/fileinput.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/vendor/bootstrap-fileinput/locales/id.js"></script>';
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
	
	function listdata($act="",$id=""){	
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_status");
		if($act=="add"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PERMOHONAN CFS', site_url('status/listdata'));
			$this->newtable->breadcrumb('Entry', 'javascript:void(0)');
			$data['title'] = 'ENTRY DATA';
			$data['act'] = 'save';
			$data['ID_DATA'] = '';
			$data['CONT'] = $this->m_status->execute('get','reff_cont_ukuran',$id);
			$data['TGL_SEKARANG'] =  date('d-m-Y');
			echo $this->load->view('content/ubahstatus/add',$data,true);
		}else if($act=="update"){ 
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PERMOHONAN CFS', 'status/listdata');
			$this->newtable->breadcrumb('Update', 'javascript:void(0)');
			$data['title'] = 'UPDATE DATA';
			$data['ID_DATA'] = $id;
			$data['act'] = 'update';//print_r($act);die();
			$data['CONT'] = $this->m_status->execute('get','reff_cont_ukuran',$id);
			$data['arrhdr'] = $this->m_status->execute('get','t_permohonan_cfs',$id);
			$data['arrcont'] = $this->m_status->execute('get','t_no_kontainer',$data['arrhdr']['ID']);
			$data['num_rows'] = count($data['arrcont']);
			$data['arrfile'] = $this->m_status->execute('get','t_permohonan_cfsfile',$data['arrhdr']['ID']);
			$data['num_rows1'] = count($data['arrfile']);
			$data['TGL_SEKARANG'] =  date('d-m-Y');
			$this->content = $this->load->view('content/ubahstatus/add',$data,true);
			$this->index();
        }else if($act=="detail"){
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['arrhdr'] = $this->m_status->execute('get','t_permohonan_cfs',$id);
			$data['table_kontainer'] = $this->kontainer_ubahstatus($act,$id);
			$data['table_file'] = $this->file_ubahstatus($act,$id);
			echo $this->load->view('content/ubahstatus/detail',$data,true);
		}else{
			$arrdata = $this->m_status->listdata($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}	
		}
	}

function kontainer_ubahstatus($act,$id)
{
if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_status");
			$arrdata = $this->m_status->kontainer_ubahstatus($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				return $data;
			}	
}

function file_ubahstatus($act,$id)
{
if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_status");
			$arrdata = $this->m_status->file_ubahstatus($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				return $data;
			}	
}

	function execute($type="",$act="", $id="")
	{		
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				redirect(base_url());
				exit();
			}
			else{
				$this->load->model("m_status");
				$this->m_status->execute($type,$act,$id);
			}
		}
	}

	function proses_print($type="", $act="", $id="") {
		if (!$this->newsession->userdata('LOGGED')) {
		    $this->index();
		    return;
		}
		if ($act != '') { 
		    $this->load->library('mpdf');
		    $this->load->model("m_status");
		   $arrdata = $this->m_status->proses_print($type, $act, $id); 
		    $this->load->view('content/ubahstatus/cetakubahstatus', $arrdata);
		}
	}


	
	function stacking($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_status");
		$arrdata = $this->m_status->stacking($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			echo $data;
		}
	}
	
	function table_kemasan($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_status");
		$arrdata = $this->m_status->table_kemasan($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}
	
	function table_kemasan_plp($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_status");
		$arrdata = $this->m_status->table_kemasan_repo($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}
	
	function table_kemasan_repo($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_status");
		$arrdata = $this->m_status->table_kemasan_repo($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}


		function kirimxml($type="",$act="", $id=""){
				$this->load->model("m_execute");
				$this->m_execute->process($type,'xml_impor_ubahstatus',$id);
	}
	
	
	
	
}