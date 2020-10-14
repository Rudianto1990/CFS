<?php
	class Setting extends Controller {
	public $content;
	
	public function __construct() {
        parent::__construct();
    }
	
	public function index(){
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
	
	public function denah_lapangan(){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		/**/$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){

			$data['id'] = $id;
			$data['title'] = 'Billing Delivery';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('sppb', $id);
			//print_r($data);die();
			//print_r($data);die();
			$data['detail_cont'] = $this->m_execute->get_data_dokumen('detail_sppb', $id);
			//var_dump($data);die();
			$this->load->view('content/billing/simulasi/form', $data);
		}else{
			$page_title = "Denah Lapangan";
			$title = "Denah Lapangan";
			$this->newtable->breadcrumb('Home', site_url(),'icon-home');
			$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Denah Lapangan', 'javascript:void(0)','');
			$data['title'] = 'ENTRY DENAH';
			$data['id'] = '';
			$data['action'] = 'save';
			$this->load->model("m_setting");
			$data['arrdata_ya'] = $this->m_setting->get_data('detail_denah_YA', $id);
			$data['arrdata_yb'] = $this->m_setting->get_data('detail_denah_YB', $id);
			$data['arrdata_cic'] = $this->m_setting->get_data('detail_denah_cic', $id);
			$data['arrdata_lap_ya'] = $this->m_setting->get_data('detail_denah_lapangan_ya', $id);
			$data['arrdata_lap_yb'] = $this->m_setting->get_data('detail_denah_lapangan_yb', $id);
			$data['arrdata_lap_cic'] = $this->m_setting->get_data('detail_denah_lapangan_cic', $id);
			/*print_r($data);
			die();*/
			$data = $this->load->view('content/layout/form_denah',$data,true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
		//$this->denah();//
	}
	
	public function gudang_detail($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		/**/if($act=="add"){
			$data['id'] = $id;
			$data['title'] = 'Billing Delivery';
			$data['action'] = "save";
			$this->load->model("m_execute");
			$data['arrdata'] = $this->m_execute->get_data_dokumen('sppb', $id);
			//print_r($data);die();
			//print_r($data);die();
			$data['detail_cont'] = $this->m_execute->get_data_dokumen('detail_sppb', $id);
			//var_dump($data);die();
			$this->load->view('content/billing/simulasi/form', $data);
		}else{
			$this->load->model("m_setting");
			$arrdata = $this->m_setting->denah($type, $act);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if ($this->input->post("ajax") || $act == "post") {
				echo $arrdata;
			} else {
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	public function form_denah_act($act,$id){
		if (!$this->newsession->userdata('LOGGED')){
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		if($act=="add"){
			$this->newtable->breadcrumb('Lapangan & Gudang', site_url()."/setting/gudang_detail");
			$this->newtable->breadcrumb('Entry', 'javascript:void(0)');
			$this->newtable->breadcrumb('Detail', 'javascript:void(0)');

			$data['title'] = 'ENTRY DENAH';
			$data['id'] = '';
			$data['action'] = 'save';
			$this->load->model("m_setting");
			$data['arrdata'] = $this->m_setting->get_data('detail_denah', $id);
			//print_r($data[0]['ID']);die();
			//echo $this->load->view('content/kapal/form_add',$data,true);
			echo $this->load->view('content/layout/add',$data,true);
			
		}else if($act=="update"){
			$data['title'] = 'UPDATE DENAH';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_setting");
			$data['arrdata'] = $this->m_setting->get_data_denah('denah1', $id);
			echo $this->load->view('content/layout/add',$data,true);
		}else if($act=="detail"){
			//print_r($id);die();
			$data['title'] = 'DETAIL DENAH';
			$data['id'] = $id;
			$data['action'] = 'update';
			$this->load->model("m_setting");
			$data['arrdata'] = $this->m_setting->get_data('detail_denah', $id);
			$data['iddata'] = $this->m_setting->get_data('detail_denah_iddata', $id);
			//print_r($data);die();
			$data = $this->load->view('content/layout/detail_denah',$data,true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}else{
			$this->load->model("m_planning");
			$arrdata = $this->m_planning->shipment($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				echo $arrdata;
			}else{
				$this->content = $data;
				$this->index();
			}
		}
	}
	
	function form_denah($type="", $id="") {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $this->load->library('newtable');
        $add_header = '<link rel="stylesheet" href="' . base_url() . 'assets/layout/css/stylesheets.css">';
        $add_header .= '<link rel="stylesheet" href="' . base_url() . 'css/newtable.css">';
        $add_header .= '<link rel="stylesheet" href="' . base_url() . 'assets/layout/css/alerts.css">';
        $add_header .= '<link rel="stylesheet" href="' . base_url() . 'assets/layout/css/stepy/smart_wizard.css">';
        //$add_header .= '<script src="' . base_url() . 'js/plugins/jquery/jquery.min.js"></script>';
        //$add_header .= '<script src="' . base_url() . 'js/plugins/jquery/jquery-ui.min.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/jquery/jquery-migrate.min.js"></script>';
        //$add_header .= '<script src="' . base_url() . 'js/plugins/bootstrap/bootstrap.min.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/uniform/jquery.uniform.min.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/jquery/plugins.js"></script>';
        $add_header .= '<script src="' . base_url() . 'js/newtable.js"></script>';
        //$add_header .= '<script src="' . base_url() . 'js/alerts.js"></script>';
        //$add_header .= '<script src="' . base_url() . 'js/main.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/stepy/jquery.smartWizard-2.0.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/jquery.noty.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/layouts/topCenter.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/layouts/topLeft.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/layouts/topRight.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/noty/themes/default.js"></script>';
        $add_header .= '<script src="' . base_url() . 'assets/layout/jquery/referensi.js"></script>';
        if ($type == "tambah") {
            $this->newtable->breadcrumb('Home', site_url());
            $this->newtable->breadcrumb('Setting', "javascript:void(0)");
            $this->newtable->breadcrumb('Denah', site_url('setting/denah'));
            $this->newtable->breadcrumb('Input Denah', "javascript:void(0)");
            if ($this->newsession->userdata('LOGGED')) {
                if ($this->content == "") {
                    $this->content = $this->load->view('content/layout/add', '', true);
                }
                $data = array('_add_header_' => $add_header,
                    '_tittle_' => 'WMS',
                    '_header_' => $this->load->view('content/header', '', true),
                    '_content_' => $this->content,
                    '_footer_' => $this->load->view('content/footer', '', true));
                $this->parser->parse('index', $data);
            } else {
                redirect(base_url('index.php'), 'refresh');
            }
        } else if ($type == "edit") {
            $this->newtable->breadcrumb('Home', site_url());
            $this->newtable->breadcrumb('Reference', "javascript:void(0)");
            $this->newtable->breadcrumb('Denah', site_url('layout/denah'));
            $this->newtable->breadcrumb('Edit Denah', "javascript:void(0)");
            if ($this->newsession->userdata('LOGGED')) {
                if ($this->content == "") {
                    $this->load->model('m_setting');
                    $arrdata = $this->m_setting->get_data("denah", $id);
                    $this->content = $this->load->view('content/layout/edit', $arrdata, true);
                }
                $data = array('_add_header_' => $add_header,
                    '_tittle_' => 'WMS',
                    '_header_' => $this->load->view('content/header', '', true),
                    '_content_' => $this->content,
                    '_footer_' => $this->load->view('content/footer', '', true));
                $this->parser->parse('index', $data);
            } else {
                redirect(base_url('index.php'), 'refresh');
            }
        } else if ($type == "detail") {
			echo "detail";die();
            $this->newtable->breadcrumb('Home', site_url());
            $this->newtable->breadcrumb('Setting', "javascript:void(0)");
            $this->newtable->breadcrumb('Denah', site_url('setting/denah'));
            $this->newtable->breadcrumb('Detail Denah', "javascript:void(0)");
            if ($this->newsession->userdata('LOGGED')) {
                if ($this->content == "") {
                    $this->load->model('m_setting');
                    $arrdata = $this->m_setting->get_data("denah", $id);
                    $this->content = $this->load->view('content/layout/detail', $arrdata, true);
                }
                $data = array('_add_header_' => $add_header,
                    '_tittle_' => 'WMS',
                    '_header_' => $this->load->view('content/header', '', true),
                    '_content_' => $this->content,
                    '_footer_' => $this->load->view('content/footer', '', true));
                $this->parser->parse('index', $data);
            } else {
                redirect(base_url('index.php'), 'refresh');
            }
        }
    }
	
	public function insertDenah(){
		//print_r($_POST);die();
		$this->load->model('m_setting');
		$x = $this->input->post('x');
		$y = $this->input->post('y');
		$val = $x."-".$y;
		$data = array(
			'LEVEL_2' => $x,
			'LEVEL_3' => $y,
			'IDDATA' => $val,
			'KD_STATUS' => '000',
			'TGL_STATUS' => date('Y-m-d H:i:s')
		);
		$this->m_setting->inDen($data);
		echo "Berhasil";
	}
	
	public function insertToDenah(){
		//print_r($_POST);
		/*die();*/
		$this->load->model('m_setting');
		$kd = $this->input->post('kode');
		$blok = $this->input->post('blok');
		$nm_blok = $this->input->post('nm_blok');
		$penumpukan = $this->input->post('penumpukan');
		$xx = $this->input->post('xx');
		$yy = $this->input->post('yy');
		$val = $xx."-".$yy;
		$data = array(
			'KD_GUDANG_DTL' => $kd,
			'NM_BLOK' => $nm_blok,
			'LEVEL_1' => $blok,
			'LEVEL_2' => $xx,
			'LEVEL_3' => $yy,
			'LEVEL_4' => $penumpukan,
			'KD_STATUS' => '001',
			'IDDATA' => $val,
			'TGL_STATUS' => date('Y-m-d H:i:s')
			);
		//print_r($data);die();
		$cek = $this->m_setting->cekBlok($nm_blok);
		if (!$cek) {
			for($a = 1; $a <= $penumpukan; $a++){
				$this->db->insert('t_denah_lapangan',array('KD_GUDANG_DTL' => $kd,'NM_BLOK' => $nm_blok,'LEVEL_1' => $blok,
				'LEVEL_2' => $xx,'LEVEL_3' => $yy,'LEVEL_4' => $a,'IDDATA' => $val,'KD_STATUS' => '','TGL_STATUS' => date('Y-m-d H:i:s')));
			}
			echo json_encode(array("Info" => "Berhasil UPDATE","result" => "SUKSES"));
		} else {
			$alertTxt = "<div class=\"alert alert-danger\">
						    <strong>Warning!</strong> BLOK SUDAH ADA!
						  </div>";
			echo json_encode(array("Info" => "BLOK SUDAH ADA!","alert" => $alertTxt));
		}
	}
	
	public function getDenah(){
		$this->load->model('m_setting');
		$id = $this->input->post('id');
		echo json_encode($this->m_setting->get_data('detail_blok', $id));
		//echo json_encode($this->m_setting->get_data('totalCont', $id));
		//print_r($data);
		
	}	
	
	public function countData($aa = ''){
		//print_r($_POST);die();
		$this->load->model('m_setting');
		$id = $this->input->post('id');
		echo json_encode($this->m_setting->get_data('totalCont', $id));
		//echo $this->m_setting->get_data('totalCont', $id);
	}
	
	public function insertToDenah1(){
		$kd = $this->input->post('kode');
		$blok = $this->input->post('blok');
		$penumpukan = $this->input->post('penumpukan');
		$data = array(
			'KD_GUDANG_DTL' => $kd,
			'LEVEL_1' => $blok,
			'LEVEL_4' => $penumpukan,
			'KD_STATUS' => '001',
			);
			
		$SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM t_denah_lapangan")->result_array();
		$ID = $SQL_MAX[0]['ID'];
		$this->db->where(array('ID' => $ID));
		$this->db->update('t_denah_lapangan', $data);
		echo json_encode(array("Info" => "Berhasil UPDATE","result" => $ID));
	}

	public function getKd($act,$id){
		$this->load->model("m_setting");
		$data['arrdata'] = $this->m_setting->get_kd();
		//var_dump($data);die();
		$this->load->view('content/layout/form_denah',$data);
	}
		
	function process($type="",$act="", $id=""){
		//echo "sini"; die();
		$id = ($id!="")?$id:$this->input->post('id');
		//print_r("sini ex id:".$id);die();
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				echo 'access is forbidden'; exit();
			}else{
				$this->load->model("m_setting");
				$this->m_setting->process($type,$act,$id);
			}
		}
	}
	
	public function getTier(){
		$BLOK = $this->input->post('blok');
		$this->load->model('m_setting');
		echo $this->m_setting->getTier($BLOK);
	}
	
	public function updateDenah(){
		//print_r($_POST);die();
		$id = $this->input->post('id');
		$this->load->model('m_setting');
		echo json_encode($this->m_setting->get_data_denah('get_kd_lapangan', $id));
	}
	
	public function deleteToDenah(){
		$blok = $this->input->post('blok');
		//print($blok); die();
		$this->db->where('LEVEL_1', $blok);
   		$this->db->delete('t_denah_lapangan');
		//print($blok); 
	}
	
	public function updateToDenah(){
		$kd = $this->input->post('kode');
		$blok = $this->input->post('blok');
		$nm_blok = $this->input->post('nm_blok');
		$penumpukan = $this->input->post('penumpukan');
		$xx = $this->input->post('xx');
		$yy = $this->input->post('yy');
		$val = $xx."-".$yy;
		
		$this->db->where('LEVEL_1', $blok);
   		$this->db->delete('t_denah_lapangan');

   		$data = array(
			'KD_GUDANG_DTL' => $kd,
			'NM_BLOK' => $nm_blok,
			'LEVEL_1' => $blok,
			'LEVEL_2' => $xx,
			'LEVEL_3' => $yy,
			'LEVEL_4' => $penumpukan,
			'KD_STATUS' => '001',
			'IDDATA' => $val,
			'TGL_STATUS' => date('Y-m-d H:i:s')
			);
		$this->load->model('m_setting');
   		$cek = $this->m_setting->cekBlok($nm_blok);
		if (!$cek) {
			for($a = 1; $a <= $penumpukan; $a++){
				$this->db->insert('t_denah_lapangan',array('KD_GUDANG_DTL' => $kd,'NM_BLOK' => $nm_blok,'LEVEL_1' => $blok,
				'LEVEL_2' => $xx,'LEVEL_3' => $yy,'LEVEL_4' => $a,'IDDATA' => $val,'KD_STATUS' => '','TGL_STATUS' => date('Y-m-d H:i:s')));
			}
			echo json_encode(array("Info" => "Berhasil UPDATE","result" => "SUKSES"));
		} else {
			$alertTxt = "<div class=\"alert alert-danger\">
						    <strong>Warning!</strong> BLOK SUDAH ADA!
						  </div>";
			echo json_encode(array("Info" => "BLOK SUDAH ADA!","alert" => $alertTxt));
		}
		/*for($a = 1; $a <= $penumpukan; $a++){
			$this->db->insert('t_denah_lapangan',array('KD_GUDANG_DTL' => $kd,'NM_BLOK' => $nm_blok,'LEVEL_1' => $blok,
			'LEVEL_2' => $xx,'LEVEL_3' => $yy,'LEVEL_4' => $a,'IDDATA' => $val,'KD_STATUS' => '001','TGL_STATUS' => date('Y-m-d H:i:s')));
		}
		echo json_encode(array("Info" => "Berhasil UPDATE","result" => "SUKSES"));*/
	}
	
	public function insertGudang(){
		//print_r($_POST);die();
		$NO_SPK = $this->input->post('NO_SPK');
		$GUDANG = $this->input->post('KODE_GDG');
		$BLOK = $this->input->post('BLOK');
		$LOK_AKHIR = $this->input->post('LOK_AKHIR');
		$NO_CONT = $this->input->post('NO_CONT');
		$PENUMPUKAN = $this->input->post('PENUMPUKAN');
		$X = $this->input->post('X');
		$Y = $this->input->post('Y');
		$VAL = $X."-".$Y;
		/*$dataGudang = array(
			'KD_GUDANG_DTL' => $GUDANG,
			'LEVEL_1' => $BLOK,
			'LEVEL_2' => $X,
			'LEVEL_3' => $Y,
			'LEVEL_4' => $PENUMPUKAN,
			'KD_STATUS' => '001',
			'IDDATA' => $VAL,
			'TGL_STATUS' => date('Y-m-d H:i:s')
			);
		$this->db->where(array('LEVEL_1' => $BLOK));
		$this->db->update('t_denah_lapangan', $data);*/
		//$this->db->insert('t_denah_lapangan', $dataGudang);
		$dataPlan = array(
			'LOKASI_AKHIR' => $LOK_AKHIR,
			'TIER_AKHIR' => $PENUMPUKAN
			);
		$this->db->where(array('NO_SPK' => $NO_SPK, 'NO_CONT' => $NO_CONT));
		$this->db->update('t_job_slip', $dataPlan);
		//print_r($this->db->last_query());die();
		/**/$SQL_LOK = $this->db->query("SELECT IFNULL(B.LOKASI, '-') AS LOKASI
							FROM t_spk A INNER JOIN t_spk_cont B 
							ON A.ID = B.ID
							WHERE B.NO_CONT = '$NO_CONT'")->row();
		//print_r(SQL_LOK);die();
		if ($SQL_LOK->LOKASI == "-" || $SQL_LOK->LOKASI == "" || $SQL_LOK->LOKASI == NULL) {
			echo "LOKASI NULL!";
			$this->db->query("UPDATE t_spk_cont a 
   						JOIN t_spk b ON a.ID = b.ID  
                        SET a.LOKASI = '$LOK_AKHIR', a.TIER = '$PENUMPUKAN'
   	                    WHERE a.NO_CONT ='$NO_CONT'");
			
		/**/}else{
			echo $SQL_LOK;//"LOKASI SUDAH ADA!";
			//die();
		}
		
		$this->db->where(array('LEVEL_1' => $BLOK, 'LEVEL_4' =>$PENUMPUKAN));
		$this->db->update('t_denah_lapangan', array('USE' => '1'));
		//print_r($this->db->last_query());die();
	}
	
	public function getGudang(){
		$this->load->model('m_setting');
		echo $this->m_setting->getAreaGudang();
	}
	
	public function getNmBlok(){
		//print_r($_POST);die();
		$blok = $this->input->post('id');
		$this->load->model('m_setting');
		echo json_encode($this->m_setting->getNmBlok($blok));
	}
}
?>