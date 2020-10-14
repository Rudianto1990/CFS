<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order extends Controller {
	var $content = "";
	function Order(){
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

	public function ppbarang($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		if($act=="coba"){
			$this->m_order->coba_dulu();
		} else if($act=="add"){
			$data['title'] = 'ENTRY DATA';
			$data['act'] = 'save';
			echo $this->load->view('content/order/add',$data,true);
		} else if ($act == "edit") {
            $arrid = explode("~", $id);
			$data['title'] = 'UPDATE DATA';
            $data['act'] = 'update';
            $data['id'] = $id;
            $data['arrhdr'] = $this->m_order->execute('get','sppb', $arrid[1]);
            echo $this->load->view('content/order/add', $data, true);
        }else if($act=="detail" || $act=="kirim"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL DATA';
            $data['url'] = "order/ppbarang/kirim";
			$data['id'] = $id;
			if($arrid[2]!='600' && $arrid[2]!='700'){
				$data['act'] = 'proses';
			}
			if($arrid[2]=='100'){
				$data['label'] = 'PROCESS';
			}else{
				$data['label'] = 'RESEND';
			}
            $data['arrhdr'] = $this->m_order->execute('get','sppb', $arrid[1]);
			$data['arrdata'] = $this->m_execute->get_data('sppb',$arrid[1]);
			$data['gd'] = $data['arrhdr']['NM_GUDANG'];
			echo $this->load->view('content/order/add',$data,true);
		}else{
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

	public function restitusi($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		if($act=="add"){
			$data['title'] = 'ENTRY DATA';
			$data['act'] = 'save';
			echo $this->load->view('content/order/restitusi',$data,true);
		} else if ($act == "edit") {
            $arrid = explode("~", $id);
			$data['title'] = 'UPDATE DATA';
            $data['act'] = 'update';
            $data['id'] = $id;
            $data['arrhdr'] = $this->m_order->execute('get','sppb', $arrid[1]);
            echo $this->load->view('content/order/restitusi', $data, true);
        }else if($act=="detail" || $act=="kirim"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL DATA';
            $data['url'] = "order/restitusi/kirim";
			$data['id'] = $id;
			if($arrid[2]!='600' && $arrid[2]!='700'){
				$data['act'] = 'proses';
			}
			if($arrid[2]=='100'){
				$data['label'] = 'PROCESS';
			}else{
				$data['label'] = 'RESEND';
			}
            $data['arrhdr'] = $this->m_order->execute('get','sppb', $arrid[1]);
			$data['arrdata'] = $this->m_execute->get_data('sppb',$arrid[1]);
			$data['gd'] = $data['arrhdr']['NM_GUDANG'];
			echo $this->load->view('content/order/restitusi',$data,true);
		}else{
			$arrdata = $this->m_order->restitusi($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function approval($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		if($act=="detail"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL APPROVAL NILAI TAGIHAN';
			//$data['url'] = site_url() . "/order/proses_print/order/proforma_invoice";
			$data['url'] = site_url() . "/order/execute/proses/cancel_order";
			$data['id'] = $id;$data['PRO'] = 'PRO';
            $data['arrhdr'] = $this->m_order->execute('get','sppb', $arrid[1]);
			$data['billing'] = $this->m_order->execute('detail','t_billing_hdr',$arrid[0]);
			$data['table_billing'] = $this->approval_billing($act,$arrid[2]);
			//print_r($data['table_kontainer']);
			echo $this->load->view('content/order/detail',$data,true);
		}else{
			$arrdata = $this->m_order->approval($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	function approval_billing($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_order");
		$arrdata = $this->m_order->approval_billing($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}

	public function clearing($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		$this->load->model("m_status");
		if($act=="add"){
			$data['title'] = 'ENTRY DATA';
			$data['act'] = 'save';
			$data['CONT'] = $this->m_status->execute('get','reff_cont_ukuran',$id);
			echo $this->load->view('content/order/add_clearing',$data,true);
		} else if ($act == "edit") {
            $arrid = explode("~", $id);
			$data['title'] = 'UPDATE DATA';
            $data['act'] = 'update';
            $data['id'] = $id;
			$data['ID_DATA'] = $id;
			$data['CONT'] = $this->m_status->execute('get','reff_cont_ukuran',$id);
            $data['arrhdr'] = $this->m_order->execute('get','clearing', $arrid[1]);
			$data['arrcont'] = $this->m_order->execute('get','t_order_cont',$arrid[1]);
			foreach ($data['arrcont'] as $key) {
				$data['kontainer'] .=$key->TB_CHK.'*'; 
			}
			$data['num_rows'] = count($data['arrcont']);
            echo $this->load->view('content/order/add_clearing', $data, true);
        } else if ($act=="detail" || $act=="kirim") {
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL DATA';
            $data['act'] = 'proses';
            $data['id'] = $id;
			$data['ID_DATA'] = $id;
			$data['CONT'] = $this->m_status->execute('get','reff_cont_ukuran',$id);
            $data['arrhdr'] = $this->m_order->execute('get','clearing', $arrid[1]);
			$data['arrcont'] = $this->m_order->execute('get','t_order_cont',$arrid[1]);
			$data['url'] = "order/clearing/kirim";
			$data['gd'] = $data['arrhdr']['GUDANGTUJUAN'];
			foreach ($data['arrcont'] as $key) {
				$data['kontainer'] .=$key->TB_CHK.'*'; 
			}
			$data['num_rows'] = count($data['arrcont']);
			echo $this->load->view('content/order/add_clearing',$data,true);
		} else {
			$arrdata = $this->m_order->clearing($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function approval_clearing($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		if($act=="detail"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL APPROVAL NILAI CLEARING PLP';
			$data['url'] = site_url() . "/order/proses_print/order/proforma_invoice2";
			$data['id'] = $id;$data['PRO'] = 'PRO';
            $data['arrhdr'] = $this->m_order->execute('get','clearing', $arrid[1]);
			$data['billing'] = $this->m_order->execute('detail','t_billing_hdr',$arrid[0]);
			$check = $this->db->query("SELECT distinct B.NO_CONT from t_billing_cfshdr A join t_billing_cfsdtl B on B.ID=A.ID
				where A.NO_ORDER='".$arrid[0]."' order by 1 asc");
			$resulte = $check->result_array();
			$oke= array();
			foreach($resulte as $row){
				$oke[] = $this->approval_clearing_billing($act,$row['NO_CONT'].'~'.$arrid[0]);
			}
			$data['table_billing']= $oke;
			echo $this->load->view('content/order/detail_clearing',$data,true);
		}else{
			$arrdata = $this->m_order->approval_clearing($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	function approval_clearing_billing($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_order");
		$arrdata = $this->m_order->approval_clearing_billing($act, $id);
		$data = $this->load->view('content/newtable', $arrdata, true);
		if($this->input->post("ajax")||$act=="post"){
			return $arrdata;
		}else{
			return $data;
		}
	}

	public function invoice_kemasan($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		if($act=="detail"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL APPROVAL NILAI TAGIHAN';
			$data['url'] = site_url() . "/order/execute/proses/send_respon";
			$data['id'] = $arrid[2];$data['PRO'] = 'INV';
            $data['arrhdr'] = $this->m_order->execute('get','sppb', $arrid[1]);
			$data['billing'] = $this->m_order->execute('detail','t_billing_hdr',$arrid[0]);
			$data['table_billing'] = $this->approval_billing($act,$arrid[2]);
			echo $this->load->view('content/order/detail',$data,true);
		}else{
			$arrdata = $this->m_order->invoice_kemasan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function invoice_container($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		if($act=="detail"){
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL APPROVAL NILAI CLEARING PLP';
			$data['url'] = site_url() . "/order/proses_print/order/invoice2";
			$data['id'] = $id;$data['PRO'] = 'INV';
            $data['arrhdr'] = $this->m_order->execute('get','clearing', $arrid[1]);
			$data['billing'] = $this->m_order->execute('detail','t_billing_hdr',$arrid[0]);
			$check = $this->db->query("SELECT distinct B.NO_CONT from t_billing_cfshdr A join t_billing_cfsdtl B on B.ID=A.ID
				where A.NO_ORDER='".$arrid[0]."' order by 1 asc");
			$resulte = $check->result_array();
			$oke= array();
			foreach($resulte as $row){
				$oke[] = $this->approval_clearing_billing($act,$row['NO_CONT'].'~'.$arrid[0]);
			}
			$data['table_billing']= $oke;
			echo $this->load->view('content/order/detail_clearing',$data,true);
		}else{
			$arrdata = $this->m_order->invoice_container($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	function surat_jalan($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_order");
		if($act=="detail"){ 
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL SURAT JALAN';
			$data['url'] = site_url() . "/order/proses_print/order/cetaksuratjalan";
			$data['id'] = $id;
            $data['arrhdr'] = $this->m_order->execute('get','surat_jalan', $arrid[0]);
			$data['table_billing'] = $this->approval_billing('surat_jalan',$arrid[1]);
			echo $this->load->view('content/order/detail_surat_jalan',$data,true);
		}else{
			$arrdata = $this->m_order->surat_jalan($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	function sp2($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_order");
		if($act=="detail"){ 
			$arrid = explode('~',$id);
			$this->load->model('m_execute');
			$data['title'] = 'DETAIL SP2';
			$data['url'] = site_url() . "/order/proses_print/order/cetaksp2";
			$data['id'] = $id;
            $data['arrhdr'] = $this->m_order->execute('get','clearing', $arrid[1]);
			$data['table_billing']= $this->approval_clearing_billing('sp2',$arrid[0]);
			echo $this->load->view('content/order/detail_sp2',$data,true);
		}else{
			$arrdata = $this->m_order->sp2($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	function validasi_manual($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_order");
		if($act=="detail"){ 
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['url'] = site_url() . "/order/proses_print/order/cetakinvoice";
			$data['id'] = $id;
            $data['arrhdr'] = $this->m_order->execute('get','validasi_manual', $id);
			echo $this->load->view('content/order/validasi_manual',$data,true);
		}else{
			$arrdata = $this->m_order->validasi_manual($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function tarif_dasar($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		if($act=="add"){
			$data['title'] = 'ENTRY DATA';
			$data['act'] = 'save';
			echo $this->load->view('content/order/tarif_dasar',$data,true);
		} else if ($act == "edit") {
            $arrid = explode("~", $id);
			$data['title'] = 'UPDATE DATA';
            $data['act'] = 'update';
            $data['id'] = $id;
            $data['arrhdr'] = $this->m_order->execute('get','tarif_dasar', $id);
            echo $this->load->view('content/order/tarif_dasar', $data, true);
		}else{
			$arrdata = $this->m_order->tarif_dasar($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function pbm($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		if($act=="add"){
			$data['title'] = 'ENTRY DATA';
			$data['act'] = 'save';
			echo $this->load->view('content/order/pbm',$data,true);
		} else if ($act == "edit") {
            $arrid = explode("~", $id);
			$data['title'] = 'UPDATE DATA';
            $data['act'] = 'update';
            $data['ID'] = $id;
            $data['arrhdr'] = $this->m_order->execute('get','pbm', $id);
            echo $this->load->view('content/order/pbm', $data, true);
		}else{
			$arrdata = $this->m_order->pbm($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	function proses_print($type="", $act="", $id="") {//print_r($type);die();
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        if ($id != '') { //print_r($type);die();
            $this->load->library('mpdf');
            $this->load->model("m_order");
            $arrdata = $this->m_order->proses_print($type, $act, $id); //print_r($arrdata);die();
            $this->load->view('content/' . $type . '/' . $act, $arrdata);
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
				$this->load->model("m_order");
				$this->m_order->execute($type,$act,$id);
			}
		}
	}

	public function input_manual($act="",$id=""){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model('m_order');
		if($act=="detail"){ 
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['url'] = site_url() . "/order/proses_print/order/cetakinvoice";
			$data['id'] = $id;
            $data['arrhdr'] = $this->m_order->execute('get','input_manual', $id);
			echo $this->load->view('content/order/input_manual',$data,true);
		}elseif($act=="insert"){ 
			$data['title'] = 'ENTRY DATA';
			$data['act'] = 'save';
			$data['bank'] = $this->m_order->get_combobox('BANK');
			echo $this->load->view('content/order/add_edc',$data,true);
		}else{
			$arrdata = $this->m_order->input_manual($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}

	public function coba(){
		$this->benchmark->mark('code_start');
		echo CI_VERSION;
		//die();
$arr= array (
	'HKJKEA731687','HKJKE1731016','HKJKE1731017','HKJKE1731018','HKJKE1731019','FUJK8290727J',
	'FUKAAD03654','HAJKHOE26077','HKJKE3734138','JKT22627637','JKT22627645','DLCJKTH40088',
	'GBSHS1703011','COAU7010161890*BS05','COAU7010161890*BS06','JKT1704063','JKT1704064',
	'JKT1704065','JKT1704066','SE17040210/001','SE17040210/002','SE17040210/003','SE17040210/004',
	'SE17040210/005','SE17040210/006','SE17040210/007','SE17040210/008','SE17040210/009',
	'SE17040209/001','SE17040209/002','MI/17/103023','MI/17/103225','SSZJKT1703015','7002035070',
	'7002035071','7002035074','7002035076','7002035079','7002035081','CNTAO0000097882','QGLB17040154',
	'GMQD17042721/22','TCLT17008623','TCLT17010415','TYO8060007','YLKS7019171','YLKS7023237',
	'YLKS7023495','YLKS7024025','YLKS7022541','YLKS7023295','TNS170401264','TYJK2381416J',
	'TYJK2376187J','TYJK2383334J','TYJK2388956J','TYJK2389100J','TYJK2393673J','TYJK2392729J',
	'TYJK2390208J','TYJK2387238J','TYJK2384147J','TYJK2388032J','TYJK2395543J','TYJK2392385J',
	'TYJK2392307J','TYJK2384403J','PJKT17040012','PJKT17040014','PSRG17040021','PJKT17040032',
	'PJKT17040033','PJKT17040038','PJKT17040044','PJKT17040021','TYOAAD17686','TYJK2396748J',
	'TYJK2397099J','GNJK6030074J','TYOAAD58172','TYJK2380447J','TYJK2397962J','TYJK2397969J',
	'TYJK2398222J','TYOAAD67154','GNJK6030272J','GNJK6030273J','PLJKT17040103/001','PLJKT17040103/002',
	'PLJKT17040103/003','PLJKT17040103/004','PLJKT17040103/005','LEXBRE170308122369','LEXBRE170308122681',
	'LEXBRE170308122830','LEXBRE170308123217','LEXBRE170308123296','LEXBRE170308123382',
	'LEXBRE170308123396','LEXBRE170308123409','NECJP-17040215','TYJK2397450J','YOKAAD55352',
	'YOJK4931483J','TYJK2398006J','TYJK2398008J','YOKAAD76105','ADEJKT17040007','SILKJKTE016694',
	'JKT042017018','TST0317046301','TST0317046287','TST0317046290','JKTCS170402D','JKTCS170402C',
	'JKTCS170402G','KMGJKT1704115','ULSHAN01830','HAN0010950' , 'BKK178718945' , '17JKT04/0144-1RO'  , 'YGLTYO029215' , 'YGLTYO029048' ,
	'YGLTYO029417' , 'YGLTYO029418' , 'YGLTYO029421' , 'YGLTYO029444'  , 'OSJK8291086J' , 'NECJP-17040230' , 'YOKAAD33991' , 'OSAAAD41456' ,
	'UKBAAD90560'  , 'TY-SD01-1704120003' , 'AWSXMLCL17040351' , 'P592JKTL704180109' , 'TCLK17002583' , 'TCLT17009782' , 'YLKS7022067' ,
	'YLKS7024127' , 'YLKS7024639' , 'YLKS7024695' , 'YLKW7003619' , 'YLKW7005640' , 'YLKW7005641' , 'YLKW7005700' , 'YLKW7005702' , 'YLKW7005731' ,
	'YLKW7005861' , 'BNX01704129' , 'YLKS7024451' , 'YLKS7024453' , 'YLKS7024774' , 'YLKS7024781' , 'THJK6029760J' , 'NGOAAD38800' , 'NGOAAD73052' ,
	'OSJK8288689J' , 'OSJK8287198J' , 'OSJK8280816J' , 'OSJK8290472J' , 'OSJK8286982J' , 'OSAAAD63204' , 'UKBAAD81320' , 'OSJK8287808J' ,
	'TYJK2399039J' , 'NAID170405' , 'TCLN17001497' , 'NGO-00066493-0001' , 'HZOMJP4010409' , 'VHFLNGOTA1713009' , 'YLKS7023629' , 'YLKS7023724' ,
	'YLKS7023877' , 'YLKS7023932' , 'YLKS7023973' , '137040239-001' , 'XZLCL1704001' , 'AMIGL170113244A' , 'AMIGL170113776A' , 'AMIGL170114818A' ,
	'WUH014196' , 'HS17040123' , 'AMIGL170126975A' , '1SH952784' , 'TPSHAJKT17040216' , 'SNLA1704143' , 'AH17047165' , 'AH17047178' , 
	'TAOS17049433' , 'TAOJKT7265366V' , 'TAOJKT7265824V' , '881140020533' , 'QDJKT1740130' , 'AMIGL170129218A' , 'YLKS7020814' , 'YLKS7022315' ,
	'YLKS7022391' , 'YLKS7022445' , 'YLKS7022950' , 'YLKS7022961' , 'YLKS7022993' , 'YLKS7023276' , 'YLKS7023718' , 'YLKS7023735' , 'YLKS7024454' ,
	'YLKW7005334' , 'YLKW7005335' , 'AWS/PKGJKT21807' , 'AWS/PKGJKT22124' , 'AWS/PKGJKT22149' , 'PKGJKT0417-130' , 'AWS/PKGJKT22198' ,
	'AWS/PKGJKT22233' , 'BOM701733628' , '43439-3' , '120617001032' , '320617003585' , 'BOMS17032931' , 'AMIGL170127411A' , 'AMIGL170127882A' ,
	'AMIGL170131856A' , 'XMNJKT17040067' , 'AMIGL170139275A' , 'AMIGL170139939A' , 'AMIGL170141171A' , 'ELCKSZP17040101' , 'AMIGL170143826A' ,
	'HWXMS1704021' , 'LEXBRE170308151375A' , 'LEXBRE170308151375B' , 'LEXBRE170308151375C' , 'LEXBRE170308151375D' , 'SILKJKTE016695' ,
	'JKTSE17040029-01' , 'VFS/JKT/E1704-023' , 'SEA&T1704018801' , 'APC/JKT/0504/2017' , 'S00163869' , 'MWA/JKT/17041064' , 'SE/1704/046' ,
	'CEJKT0755/2017' , 'B17042095-1' , 'B17040751-1' , 'B17042559-1' , 'B17042649-1' , 'B17043260-1' , 'B17043686-1' , 'JKT 17040493' ,
	'GCNLBJKT1704569' , 'MSITH8244' , 'RWTJKT170423' , 'TLCBJKTH04006' , 'LCBJKT1704002PT.' , 'JKTSE489SP17' , 'MLGDBKK21701478' , 'MLGDBKK21701481'
	, 'GCNLBJKT1704571' , 'UIFJKT17-0271' , 'UIFJKT17-0272' , 'UIFJKT17-0273' , 'JKTGPPKG17040234-01' , 'OL/PEN/JKT/L0001007' , 'LPKGJKT09432-05' ,
	'PKL/JKT/4002/2017' , 'SE17040044-00' , 'LPKGJKT09432-07' , 'YS101805' , 'LGJKASZX1704126' , 'FFSJKT17040044' , 'TUSLCSX-S-1704014' ,
	'KUL17040114' , 'PKGJKT-7574' , 'PKGJKT-7573' , 'PKG0000624' , 'PKGJKT7131991V' , 'PKG0000687' , 'PKG0000726' , 'KUL178727120' , 'PEPKLOEX201992'
	, 'PEPKLOEX201993' , 'HLKSHEH170400318' , 'BT1704KOBJAK7185' , 'BT1704KOBJAK7186' , 'HLKSHEH170400317' , 'HLKSHEH170400319' , 'BAL170063' ,
	'HFIOSO740230' , 'TEH1704076' , 'CMB003737' , 'CMB003738' , 'CMB003739' , 'CMB003740' , 'CMB003741' , 'CMB003742' , 'CMB003743' , 'CMB003744' ,
	'CMB003745' , 'CMB003746' , 'CMB003747' , 'CMB003748' , 'CMB003749' , 'CMB003750' , 'CMB003751' , 'CMB003752' , 'CMB003753' , 'CMB003754' ,
	'CMB003755' , 'CMB003756' , 'CMB003757' , 'CMB003758' , 'CMB003759' , 'CMB003760' , 'CMB003761' , 'CMB003762' , 'BLR782093' , 'BLR782027' ,
	'BLR782028' , 'FSJKT1742007' , 'FSJKT1742008' , 'FXJKT17040006' , 'LHJKT1704052' , 'LHJKT1704053' , 'LHJKT1704054' , 'LHJKT1704055' ,
	'LHJKT1704056' , 'LHJKT1704057' , 'LHJKT1704058' , 'LHJKT1704059' , 'LHJKT1704060' , 'LHJKT1704061' , 'LHJKT1704062' , 'HKGJKT17040009' ,
	'TEJKT-2017042401' , 'LPJKT1704201' , 'XHKG17040015' , 'XJKT17040007' , 'COAU7054768300C' , 'SONB17040623' , 'NLNGB0063716' , '17NGB0008331' ,
	'GSE174175JKT' , 'CAJKZXE29705' , 'GSE174306JKT' , 'GSE174335JKT' , 'GSE174378JKT' , 'GSE174432JKT' , 'SHAOAJAK7041917' , 'SCSZ17040863SHXG' ,
	'RG1704HC0063' , 'ASHOE1700384' , 'SHEXL1704421' , 'GXPEW17046654' , 'SNLNY1704078' , 'BKK602245' , 'BKK222003' , 'KUL147444' , 'BLR782073' ,
	'DLC577242' , 'HAN637458' , 'XMN810986' , 'PUS468783' , 'SEL120629' , 'CEB557600' , 'CEB557601' , 'HF16SG1704503' , 'SHAJKT1704093B' ,
	'TAJKT1704571B' , 'TYJK2377923J' , '430511' , 'ELCKTPE17040031' , '4740-0633-703.014' , 'KUL147297' , 'ATLJKT168126854' , 'ATLJKT168126858' ,
	'ATLJKT168126853' , 'ATLJKT168126855' , 'ATLJKT168126856' , 'ATLJKT168126851' , 'ATLJKT168126862' , 'ATLJKT168126860' , 'ATLJKT168126861' ,
	'ATLJKT168126857' , 'DFS067093009' , 'DFS067093105' , 'PHL/JKT/D81377' , 'ATLJKT168126863' , 'S00306185' , 'GLFZL1703426' , 'TYJK2380537J' ,
	'TYJK2374183J' , 'TYJK2375713J' , 'NGJK6026353J' , 'NGJK6027243J' , 'TYJK2367788H' , 'SE170300322' , '4841-0633-704.030' , 'PLJKT17040103/005' ,
	'PLJKT17040103/001' , 'GXSAG17023750' , 'TAIJKTH04005T' , 'I232078539E' , 'DFS067093077' , 'JK1704004' , 'OXM257202' , 'JKT2017-45820' ,
	'SHH1704001' , 'GXSAG17044506' , 'SE17040210/006' , 'AGSA17L/JKT00253' , '881140020533' , 'YLKS7023385' , 'SE1704-008-01' , 'SHJKT1703068103' ,
	'DFS023014421' , 'COAU7054768300C' , 'EJKT17041110' , 'JOG-17040012' , 'RTAJKT1704573B' , 'TYO-45219' , 'DMCQSIN0146979' , 'TSNS17032517' ,
	'DMCQSIN0146980' , 'YLKS7020939' , 'MI/17/103225' , 'EURFL17323423JKTA' , 'MJKT17041102' , 'TXGJKT70414EA001' , 'TSSZ1703016' , 'HKJKE1731018' ,
	'HKJKE1731019' , 'ASSH17040435' , 'JKT22627645' , 'TYOAAC97526' , 'KAOJKT17040249' , 'LIOJKT7234221V' , 'CTGJ17040031' , 'I232080548F' ,
	'BLS1701244' , 'SHA730793' , 'MQ17040566' , 'TYJK2396053J' , 'KUL17040017' , 'LAX00073955' , '100117002141' , 'YLKS7022445' , 'YLKS7023237' ,
	'LOJKLOE17407' , 'GPKGJKTD1701045' , 'USLAX545634' , 'SH33067JKT' , 'JKRT1704002' , 'TPE-JKT109113' , '19545110FR0317' , 'PJKT17030089' ,
	'2830-0317-0146' , 'SHAJKT1704093C' , 'TGL-1704146' , 'TCLT17007599' , 'HAMS17217895' , 'LHJKT20170121C' , '1SH950569' , 'AA7040041701' ,
	'4841-0633-704.044' , 'SC17TJ5A129' , '4740-0633-703.013' , 'CNSZX348812' , 'SHPX17040266' , 'PKG9018661' , 'SHA8740043' , 'KAJKT1704115' ,
	'SE170091013' , 'MSP057164' , 'SHPX17040215' , 'SEL120569' , 'PLITJ4704532' , 'RKEJKT1704565B' , 'YTC-TPE1704080' , 'HZOMJP1041786' ,
	'JGLBSGJKT1704256' , 'HZOMJP1041784' , 'SHPX17040285' , 'SHPX17040324' , 'SNSU17040115' , 'I232080514A' , 'KJKT17043027' , 'SEA&T1704017401' ,
	'SHJKCHE54767' , 'SMK17004501' , 'D17L200151' , 'S00575492' , 'YLKW7004728' , 'SYTS-JKTLC170145-01' , 'VTSZ17040538' , 'LEXBRE170308121898' ,
	'KAJKT1704112' , 'PJKT17040042' , 'ENHAJKT17040043' , 'YLKS7023168' , 'AHL/787GOA/JKT720/17' , 'GAMDJKTD700004' , 'CGP/17/PA204847' ,
	'HSF-22724253' , 'CGP/17/PA205013' , 'HOU445048' , 'JKT83685-01' , 'SHA744793' , 'HSF-03097860' , 'JKTSE17040020-01' , 'VKJKT17020119A'
	, 'AWS/PKGJKT22053' , 'PJKT17030104' , 'GCOKJKTC700203' , 'SZV715469' , 'QGLB17040119' , '226749691CHI' , 'QGLB17040056' , 'HSF-32834945' ,
	'SHA731957' , 'SHA745558' , 'SIN086870' , 'COAU7054647540A' , 'SHA746254' , 'SHA791607' , 'SHA746253' , 'BKK407909' , 'DFS053038874' ,
	'DGPE17040103' , 'JK1704650' , 'SIN17040025' , 'PJKT17040023' , 'GXPEW17046506' , 'NS17D9514' , 'PKGJKT7131635V' , 'NLCAN0018190' ,
	'USCXBUSJKR3368' , 'I2017-00864' , 'JK1704636' , 'GXPEW17046801' , 'SHA790539' , 'DLC31100832' , 'CH17040061' , 'GTOSEA-106307' , 'MNL0325163' ,
	'COAU7054647540G' , 'REX663170092' , 'JK1704025' , '02PKG0058563' , 'SZJKT17041566' , 'ESGN17-0104012B' , 'COAU7054647110B' , 'MALY00498851' ,
	'PIKJKT1704152' , 'GSE173624JKT' , 'BOSJKT17030018' , 'HCH681925' , 'AUSYDAS2076281' , 'GNSATPPC704111' , '132042702556' , 'SYNSCM17SE040574' ,
	'AW170430808' , 'SIN/JKT/0417/0020' , 'LEXBRE170308150728A' , 'SZ3EL17040593' , 'BMJIJKT1704030' , 'AWSJKT51635' , 'ENCJKT3353301' , '7792322043'
	, 'JK1704610' , 'TYOAAC90773' , 'XHKG17040003' , 'YBJKT-34219' , 'YLKS7021093' , 'GLWL17030103' , 'WGSIN/JKT-5701/17' , 'SE1704-008-03' ,
	'NUE143132' , 'SHA742380' , 'SZX686808' , 'ASHJKA704000160'
);
		$this->load->model('m_order');
		$data['title'] = 'ENTRY DATA';
		$data['act'] = 'save';
		$this->db->select("A.*,B.KD_GUDANG");
		$this->db->from('t_cocostskms A');
		$this->db->join('t_cocostshdr B', 'A.ID = B.ID');
		$this->db->where_in('A.NO_BL_AWB', $arr);
		//$this->db->where('A.WK_OUT IS NOT NULL');
		$query = $this->db->get();
		$data['ttt'] = $_SERVER['DOCUMENT_ROOT'];
		$data['kms'] = $query->result_array();
		$this->benchmark->mark('code_end');
		echo '<br>'.$this->benchmark->elapsed_time('code_start', 'code_end');
		$this->content = $this->load->view('content/order/tes',$data,true);
		$this->index();
	}	
}
