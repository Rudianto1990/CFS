<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plp extends Controller {
    var $content = "";
    function Plp() {
       parent::Controller();
    }
	
	function index(){
		$add_header  = '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/dist/sweetalert.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/app.min.css">';
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
						  '_tittle_'  	   => 'TPS ONLINE',
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
	
	function execute($type="",$act="", $id=""){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				redirect(base_url());
				exit();
			}else{
				$this->load->model("m_plp");
				$this->m_plp->execute($type,$act,$id);
			}
		}
	}
	
	function autocomplete($act,$get){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$this->m_plp->autocomplete($act,$get);
	}
	
	function pengajuan($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		if($act=="stacking"){
			$data['title'] = 'DATA BONGKARAN';
			$data['ID'] = $id;
			$data['act'] = 'save';
			$data['table_stacking'] = $this->table_stacking($act,$id);
			echo $this->load->view('content/plp/pengajuan/discharge_kemasan',$data,true);
		}else if($act=="add"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PLP', site_url());
			$this->newtable->breadcrumb('Pengajuan PLP', site_url('plp/pengajuan'));
			$this->newtable->breadcrumb('Entry', 'javascript:void(0)');
			$data['title'] = 'ENTRY DATA';
			$data['ID'] = $id;
			$data['act'] = 'save';
			$data['arrhdr'] = $this->m_plp->execute('get','cocostshdr',$id);
			$data['table_kemasan'] = $this->table_kemasan($act,$id);
			$this->content = $this->load->view('content/plp/pengajuan/pengajuan',$data,true);
			$this->index();
		}else if($act=="detail"){
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['arrhdr'] = $this->m_plp->execute('get','cocostshdr',$arrid[1]);
			$data['arrplp'] = $this->m_plp->execute('get','plp_hdr',$id);
			$data['table_kemasan'] = $this->table_kemasan_plp($act,$id);
			echo $this->load->view('content/plp/pengajuan/detail',$data,true);
		}else if($act=="update"){
			$arrid = explode("~",$id);
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
			$this->newtable->breadcrumb('Pengajuan PLP', site_url('plp/pengajuan'));
			$this->newtable->breadcrumb('Update', 'javascript:void(0)');
			$data['title'] = 'UPDATE DATA';
			$data['ID'] = $id;
			$data['act'] = 'update';
			$data['arrhdr'] = $this->m_plp->execute('get','cocostshdr',$arrid[1]);
			$data['arrplp'] = $this->m_plp->execute('get','plp_hdr',$id);
			$data['table_kemasan'] = $this->table_kemasan($act,$arrid[1]);
			$this->content = $this->load->view('content/plp/pengajuan/pengajuan',$data,true);
			$this->index();
		}else{
			$arrdata = $this->m_plp->pengajuan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}	
		}
	}
	
	function stacking($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->stacking($act, $id);
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
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->table_kemasan($act, $id);
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
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->table_kemasan_plp($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}
	
	function pembatalan($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		if($act=="stacking"){
			$data['title'] = 'DATA BONGKARAN';
			$data['ID'] = $id;
			$data['act'] = 'save';
			$data['table_stacking'] = $this->table_stacking($act,$id);
			echo $this->load->view('content/plp/pengajuan/discharge_kemasan',$data,true);
		}else if($act=="add"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PLP', site_url());
			$this->newtable->breadcrumb('Pembatalan PLP', site_url('plp/pembatalan'));
			$this->newtable->breadcrumb('Entry', 'javascript:void(0)');
			$data['title'] = 'ENTRY DATA';
			$data['ID'] = $id;
			$data['act'] = 'save';
			$data['arrhdr'] = $this->m_plp->execute('get','respon_plp_asal_hdr',$id);
			$data['table_kemasan'] = $this->table_res_plp_asalkms($act,$id);
			$this->content = $this->load->view('content/plp/pembatalan/pembatalan',$data,true);
			$this->index();
		}else if($act=="detail"){
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['arrhdr'] = $this->m_plp->execute('get','request_batal_plp_hdr',$id);
			$data['table_kemasan'] = $this->table_reqbtl_plp_kms($act,$id);
			echo $this->load->view('content/plp/pembatalan/detail',$data,true);
		}else if($act=="update"){
			$arrid = explode("~",$id);
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
			$this->newtable->breadcrumb('Pembatalan PLP', site_url('plp/pembatalan'));
			$this->newtable->breadcrumb('Update', 'javascript:void(0)');
			$data['title'] = 'UPDATE DATA';
			$data['ID'] = $id;
			$data['act'] = 'update';
			$data['arrhdr'] = $this->m_plp->execute('get','request_batal_plp_hdr',$id);
			$data['table_kemasan'] = $this->table_res_plp_asalkms($act,$arrid[1]);
			$this->content = $this->load->view('content/plp/pembatalan/pembatalan',$data,true);
			$this->index();
		}else{
			$arrdata = $this->m_plp->pembatalan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}	
		}
	}
	
	function respon_plp_asal($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->respon_plp_asal($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			echo $data;
		}
	}
	
	function table_res_plp_asalkms($act="", $id=""){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->table_res_plp_asalkms($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}
	
	function table_reqbtl_plp_kms($act="", $id=""){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->table_reqbtl_plp_kms($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}
	
	function res_plp_asal($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		if($act=="detail"){
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['arrhdr'] = $this->m_plp->execute('get','respon_plp_asal_hdr',$id);
			$data['table_kemasan'] = $this->v_res_plp_asal_kms($act,$id);
			echo $this->load->view('content/plp/respon/detail_plp_asal',$data,true);
		}else{
			$arrdata = $this->m_plp->res_plp_asal($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}	
		}
	}
	
	function v_res_plp_asal_kms($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->v_res_plp_asal_kms($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}
	
	function res_plp_tujuan($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		if($act=="detail"){
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['arrhdr'] = $this->m_plp->execute('get','respon_plp_tujuan_hdr',$id);
			$data['table_kemasan'] = $this->v_res_plp_tujuan_kms($act,$id);
			echo $this->load->view('content/plp/respon/detail_plp_tujuan',$data,true);
		}else{
			$arrdata = $this->m_plp->res_plp_tujuan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}	
		}
	}
	
	function v_res_plp_tujuan_kms($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->v_res_plp_tujuan_kms($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}
	
	function res_batal_plp_asal($act,$id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		if($act=="detail"){
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['arrhdr'] = $this->m_plp->execute('get','respon_batal_plp_asal_hdr',$id);
			$data['table_kemasan'] = $this->v_res_batal_plp_asal_kms($act,$id);
			echo $this->load->view('content/plp/respon/detail_batal_plp_asal',$data,true);
		}else{
			$arrdata = $this->m_plp->res_batal_plp_asal($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	function v_res_batal_plp_asal_kms($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->v_res_batal_plp_asal_kms($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}
	
	function res_batal_plp_tujuan($act,$id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		if($act=="detail"){
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['arrhdr'] = $this->m_plp->execute('get','respon_batal_plp_tujuan_hdr',$id);
			$data['table_kemasan'] = $this->v_res_batal_plp_tujuan_kms($act,$id);
			echo $this->load->view('content/plp/respon/detail_batal_plp_tujuan',$data,true);
		}else{
			$arrdata = $this->m_plp->res_batal_plp_tujuan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}	
		}
	}
	
	function v_res_batal_plp_tujuan_kms($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->v_res_batal_plp_tujuan_kms($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}
}