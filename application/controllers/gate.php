<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gate extends Controller {
    var $content = "";
    function Gate() {
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

	public function in_container($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$data['title'] = 'ENTRY GATE IN';
			$data['id'] = '';
			$data['action'] = 'save';
			echo $this->load->view('content/gate/getin/gatein',$data,true);
		}else if($act=="update"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('Kontainer', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate In', site_url('gate/in_container'));
			$this->newtable->breadcrumb('Update Get In Kontainer', 'javascript:void(0)');
			$data['title'] = 'UPDATE GATE IN';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			$this->content = $this->load->view('content/gate/getin/gatein',$data,true);
			$this->index();
			//print_r($data);
		}else if($act=="detail"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('Kontainer', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate In', site_url('gate/in_container'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['title'] = 'DETAIL GATE IN';
			$data['id'] = $id;
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			$data['table_kontainer'] = $this->kontainer_masuk($act,$id);
			$this->content = $this->load->view('content/gate/getin/kontainer-getein-detail',$data,true);
			$this->index();
			//print_r($id.'<br><br><br><br>'.$data);
			
		}else if($act=="upload"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('Kontainer', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate In', site_url('gate/in_container'));
			$this->newtable->breadcrumb('Upload', 'javascript:void(0)');
			$data['title'] = 'UPLOAD GATE IN';
			$data['id'] = '';
			$data['action'] = 'save';
			$this->content = $this->load->view('content/gate/getin/gatein-upload',$data,true);
			$this->index();
		}else{
			$this->load->model("m_gate");
			$arrdata = $this->m_gate->in_container($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function out_container($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="detail"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('Kontainer', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate Out', site_url('gate/out_container'));
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');
			$data['title'] = 'DETAIL GATE OUT';
			$data['id'] = $id;
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			$data['table_kontainer'] = $this->kontainer_detail($act,$id);
			#$data['table_kemasan'] = $this->out_kemasan($act,$id);
			$this->content = $this->load->view('content/gate/getout/kontainer-gateout-detail',$data,true);
			$this->index();
		}else if($act=="upload"){
			$this->newtable->breadcrumb('Home', site_url());
			$this->newtable->breadcrumb('Kontainer', 'javascript:void(0)');
			$this->newtable->breadcrumb('Gate Out', site_url('gate/out_container'));
			$this->newtable->breadcrumb('Upload', 'javascript:void(0)');
			$data['title'] = 'UPLOAD GATE OUT';
			$data['id'] = '';
			$data['action'] = 'save';
			$this->content = $this->load->view('content/gate/getout/gateout-upload',$data,true);
			$this->index();

		}else{
			$this->load->model("m_gate");
			$arrdata = $this->m_gate->gateout($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	public function kontainer_detail($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="detail-kontainer"){	
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL GATE OUT - KONTAINER';
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/gate/getout/gateout-kontainer-detail',$data,true);
		}else{
			$this->load->model("m_gate");
			$arrdata = $this->m_gate->kontainer_detail($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}	
		}
	}
		
	public function gateout_kontainer($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="update"){
			$arrid = explode('~',$id); 
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'GATE OUT - KONTAINER';
			$data['id'] = $id;
			$data['post'] = $arrid[0];
			$data['action'] = 'update';
			$data['arr_ukuran'] = $this->m_popup->get_combobox('cont_ukuran');
			$data['arr_jenis'] = $this->m_popup->get_combobox('cont_jenis');
			$data['arr_status'] = $this->m_popup->get_combobox('cont_status');
			$data['arr_tipe'] = $this->m_popup->get_combobox('cont_tipe');
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/gate/getout/gateout-kontainer',$data,true);
		}else if($act=="detail-kontainer"){	
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL GATE OUT - KONTAINER';
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/gate/getout/gateout-kontainer-detail',$data,true);
		}else{
			$this->load->model("m_gate");
			$arrdata = $this->m_gate->gateout_kontainer($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}	
		}
	}
	
	public function out_kemasan($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="update"){
			$arrid = explode('~',$id); 
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'GATE OUT - KEMASAN';
			$data['id'] = $id;
			$data['post'] = $arrid[0];
			$data['action'] = 'update';
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kemasan', $id);
			echo $this->load->view('content/gate/getout/gateout-kemasan',$data,true);
		}else if($act=="detail-kemasan"){	
			$arrid = explode('~',$id); 
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL DISCHARGE - KEMASAN';
			$data['arrdata'] = $this->m_execute->get_data('kemasan', $id);
			echo $this->load->view('content/gate/getout/gateout-kemasan-detail',$data,true);
		}else{
			$this->load->model("m_gate");
			$arrdata = $this->m_gate->gateout_kemasan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	
	public function gatein_kontainer($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'ENTRY GATE IN - KONTAINER';
			$data['id'] = $id;
			$data['post'] = $id;
			$data['action'] = 'save';
			$data['arr_ukuran'] = $this->m_popup->get_combobox('cont_ukuran');
			$data['arr_jenis'] = $this->m_popup->get_combobox('cont_jenis');
			$data['arr_status'] = $this->m_popup->get_combobox('cont_status');
			$data['arr_tipe'] = $this->m_popup->get_combobox('cont_tipe');
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			echo $this->load->view('content/gate/getin/gatein-kontainer',$data,true);
		}else if($act=="update"){
			$arrid = explode('~',$id); 
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'UPDATE GATE IN - KONTAINER';
			$data['id'] = $id;
			$data['post'] = $arrid[0];
			$data['action'] = 'update';
			$data['arr_ukuran'] = $this->m_popup->get_combobox('cont_ukuran');
			$data['arr_jenis'] = $this->m_popup->get_combobox('cont_jenis');
			$data['arr_status'] = $this->m_popup->get_combobox('cont_status');
			$data['arr_tipe'] = $this->m_popup->get_combobox('cont_tipe');
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/gate/getin/gatein-kontainer',$data,true);
		}else if($act=="detail-kontainer"){	
			$arrid = explode('~',$id); 
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL GATE IN - KONTAINER';
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/gate/getin/gatein-kontainer-detail',$data,true);
		}
		else{
			$this->load->model("m_gate");
			$arrdata = $this->m_gate->gatein_kontainer($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			//print_r($data);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
			
		}
	}
	
	public function kontainer_masuk($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="detail-kontainer"){	
			$arrid = explode('~',$id); 
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL GATE IN - KONTAINER';
			$data['arrdata'] = $this->m_execute->get_data('kontainer', $id);
			echo $this->load->view('content/gate/getin/gatein-kontainer-detail',$data,true);
		}
		else{
			$this->load->model("m_gate");
			$arrdata = $this->m_gate->kontainer_masuk($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			//print_r($data);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
			
		}
	}
	
	public function in_kemasan($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'ENTRY GATE IN - KEMASAN';
			$data['id'] = $id;
			$data['post'] = $id;
			$data['action'] = 'save';
			$data['arr_ukuran'] = $this->m_popup->get_combobox('cont_ukuran');
			$data['arr_jenis'] = $this->m_popup->get_combobox('cont_jenis');
			$data['arr_status'] = $this->m_popup->get_combobox('cont_status');
			$data['arr_tipe'] = $this->m_popup->get_combobox('cont_tipe');
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kapal', $id);
			echo $this->load->view('content/gate/getin/gatein-kemasan',$data,true);
		}else if($act=="update"){
			$arrid = explode('~',$id); 
			$this->load->model('m_popup');
			$this->load->model('m_execute');
			$data['title'] = 'UPDATE GATE IN - KEMASAN';
			$data['id'] = $id;
			$data['post'] = $arrid[0];
			$data['action'] = 'update';
			$data['arr_angkut'] = $this->m_popup->get_combobox('sarana_angkut');
			$data['arrdata'] = $this->m_execute->get_data('kemasan', $id);
			echo $this->load->view('content/gate/getin/gatein-kemasan',$data,true);
		}else if($act=="detail-kemasan"){	
			$arrid = explode('~',$id); 
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL GATE IN - KEMASAN';
			$data['arrdata'] = $this->m_execute->get_data('kemasan', $id);
			echo $this->load->view('content/gate/getin/gatein-kemasan-detail',$data,true);
		}else{
			$this->load->model("m_gate");
			$arrdata = $this->m_gate->gatein_kemasan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
}