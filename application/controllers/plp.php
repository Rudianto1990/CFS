<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plp extends Controller {
    var $content = "";
    function Plp() {
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
	
	public function pengajuan_plp($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		/* if($act=="add"){
			$this->load->model('m_execute');
			$this->newtable->breadcrumb('HOME', site_url());
			$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
			$this->newtable->breadcrumb('Pengajuan PLP', site_url('plp/pengajuan'));
			$this->newtable->breadcrumb('Entry', 'javascript:void(0)');
			$data['page_title'] = 'ENTRY PENGAJUAN PLP';
			$data['action'] = 'save';
			$data['arrdata'] = $this->m_execute->get_data('kapal',$id);
			$data['table_kontainer'] = $this->pengajuan_discharge_kontainer($act,$id);
			$this->content = $this->load->view('content/plp/pengajuan',$data,true);
			$this->index();
		}if($act=="update"){
			$this->load->model('m_execute');
			$this->newtable->breadcrumb('HOME', site_url());
			$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
			$this->newtable->breadcrumb('Pengajuan PLP', site_url('plp/pengajuan'));
			$this->newtable->breadcrumb('Update', 'javascript:void(0)');
			$arrid = explode("~",$id);
			$data['id'] = $arrid[1];
			$data['page_title'] = 'UPDATE PENGAJUAN PLP';
			$data['action'] = 'update';
			$data['arrdata'] = $this->m_execute->get_data('request_plp',$arrid[1]);
			$data['table_kontainer'] = $this->pengajuan_discharge_kontainer($act,$id);
			$this->content = $this->load->view('content/plp/pengajuan',$data,true);
			$this->index();
		}else if($act=="print"){
			$arrid = explode('~',$id);
			$this->load->library('mpdf');
			$this->load->model('m_execute');
			$data['data'] = $this->m_execute->get_data('respon_plp_cont_print',$id);
			$this->load->view('content/plp/pengajuan_print',$data);
		}else  */
		if($act=="detail"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL PENGAJUAN PLP';
			$data['arrdata'] = $this->m_execute->get_data('request_plp',$arrid[1]);
			$data['table_kontainer'] = $this->pengajuan_plp_kontainer($act,$arrid[1]);
			echo $this->load->view('content/plp/pengajuan_detail',$data,true);
		}else{
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
			$this->newtable->breadcrumb('Pengajuan PLP', site_url('plp/pengajuan'));
			$this->load->model("m_plp");
			$arrdata = $this->m_plp->pengajuan_plp($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();

			}	
		}
	}
	
	function pengajuan_plp_kontainer($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->pengajuan_plp_kontainer($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}
	
	public function pembatalan_plp ($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		/* if($act=="add"){
			$this->load->model('m_execute');
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
			$this->newtable->breadcrumb('PENGAJUAN BATAL PLP', site_url('plp/pembatalan'));
			$this->newtable->breadcrumb('Entry', 'javascript:void(0)');
			$data['page_title'] = 'ENTRY PENGAJUAN BATAL PLP';
			$data['action'] = 'save';
			$data['arrdata'] = $this->m_execute->get_data('respon_plp',$id);
			$data['table_pembatalan_kontainer'] = $this->pembatalan_respon_plp_kontainer($act,$id);
			$this->content = $this->load->view('content/plp/pembatalan',$data,true);
			$this->index();
		}if($act=="update"){
			$this->load->model('m_execute');
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
			$this->newtable->breadcrumb('PENGAJUAN BATAL PLP', site_url('plp/pembatalan'));
			$this->newtable->breadcrumb('Update', 'javascript:void(0)');
			$arrid = explode("~",$id);
			$data['id'] = $arrid[1];
			$data['page_title'] = 'UPDATE PENGAJUAN BATAL PLP';
			$data['action'] = 'update';
			$data['arrdata'] = $this->m_execute->get_data('request_batal_plp',$arrid[1]);
			$data['table_pembatalan_kontainer'] = $this->pembatalan_respon_plp_kontainer($act,$id);
			$this->content = $this->load->view('content/plp/pembatalan',$data,true);
			$this->index();
		}else  */
		if($act=="detail"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL PENGAJUAN BATAL PLP';
			$data['arrdata'] = $this->m_execute->get_data('request_batal_plp',$arrid[1]);
			$data['table_pembatalan_kontainer'] = $this->pembatalan_plp_kontainer($act,$id);
			echo $this->load->view('content/plp/pembatalan_detail',$data,true);
		}else{
			$this->load->model("m_plp");
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
			$this->newtable->breadcrumb('PENGAJUAN BATAL PLP', site_url('plp/pembatalan'));
			$arrdata = $this->m_plp->pembatalan_plp($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}	
		}
	}
	
	function pembatalan_plp_kontainer($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->pembatalan_plp_kontainer($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
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
			$data['id'] = $id;
			$data['table_kemasan'] = $this->v_res_plp_asal_cont($act,$id);
			echo $this->load->view('content/plp/detail_plp_asal',$data,true);
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

	function v_res_plp_asal_cont($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->v_res_plp_asal_cont($act, $id);
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
			$data['id'] = $id;
			$data['table_kemasan'] = $this->v_res_batal_plp_asal_cont($act,$id);
			echo $this->load->view('content/plp/detail_batal_plp_asal',$data,true);
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

	function v_res_batal_plp_asal_cont($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->v_res_batal_plp_asal_cont($act, $id);
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
			$data['table_kemasan'] = $this->v_res_plp_tujuan_cont($act,$id);
			echo $this->load->view('content/plp/detail_plp_tujuan',$data,true);
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
	
	function v_res_plp_tujuan_cont($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->v_res_plp_tujuan_cont($act, $id);
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
			$data['table_kemasan'] = $this->v_res_batal_plp_tujuan_cont($act,$id);
			echo $this->load->view('content/plp/detail_batal_plp_tujuan',$data,true);
//print_r($data['table_kemasan']);
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

	function v_res_batal_plp_tujuan_cont($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->v_res_batal_plp_tujuan_cont($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			return $data;
		}
	}
}

/* 	function pengajuan_discharge($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->pengajuan_discharge($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			echo $data;
		}
	}
	
	function pengajuan_discharge_kontainer($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->pengajuan_discharge_kontainer($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}
		
	function pengajuan_respon($act,$id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="detail"){
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL RESPONS PLP';
			$data['arrdata'] = $this->m_execute->get_data('respon_plp',$id);
			$data['table_kontainer'] = $this->pengajuan_respon_plp_kontainer($act,$id);
			echo $this->load->view('content/plp/respon_detail',$data,true);
		}else{
			$this->load->model("m_plp");
			$arrdata = $this->m_plp->pengajuan_respon($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
		}
	}
	
	function pengajuan_respon_plp_kontainer($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->pengajuan_respon_plp_kontainer($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}

	//pembatalan
	public function pembatalan($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->newtable->breadcrumb('Dashboard', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Pembatalan', 'javascript:void(0)');
		$data['page_title'] = 'PEMBATALAN';
		$data['table_request'] = $this->pembatalan_plp($act,$id);
		$data['table_respon'] = $this->pembatalan_respon($act,$id);
		$this->content = $this->load->view('content/plp/index',$data,true);
		$this->index();
	}
	function pembatalan_respon_plp($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->pembatalan_respon_plp($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			echo $arrdata;
		}else{
			echo $data;
		}
	}
	
	function pembatalan_respon_plp_kontainer($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->pembatalan_respon_plp_kontainer($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}
		
	function pembatalan_respon($act,$id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="detail"){
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL RESPONS BATAL PLP';
			$data['arrdata'] = $this->m_execute->get_data('respon_plp',$id);
			$data['table_kontainer'] = $this->pembatalan_respon_kontainer($act,$id);
			echo $this->load->view('content/plp/respon_detail',$data,true);
		}else{
			$this->load->model("m_plp");
			$arrdata = $this->m_plp->pembatalan_respon($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
		}
	}
	
	function pembatalan_respon_kontainer($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->pembatalan_respon_kontainer($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}
	
	public function monitoring($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->newtable->breadcrumb('Dashboard', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)');
		$data['page_title'] = 'MONITORING';
		$data['monitoring_pengajuan'] = $this->monitoring_pengajuan($act,$id);
		$data['monitoring_pembatalan'] = $this->monitoring_pembatalan($act,$id);
		$this->content = $this->load->view('content/plp/monitoring',$data,true);
		$this->index();
	}
	
	function monitoring_pengajuan($act,$id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->monitoring_pengajuan($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}
	
	function monitoring_pembatalan($act,$id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_plp");
		$arrdata = $this->m_plp->monitoring_pembatalan($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}
*/	
