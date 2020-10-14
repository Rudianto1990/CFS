<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends Controller {
	var $content = "";
	function Home(){
		parent::Controller();
		$this->load->helper(array('form', 'url', 'captcha', 'security'));
		$this->load->helper('captcha');
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
		$add_header .= '<script src="'.base_url().'assets/js/jquery.validate.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/jquery.maskedinput.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/messages_id.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/vendor/sweetalert/dist/sweetalert.min.js"></script>';
		if($this->newsession->userdata('LOGGED')){
			redirect(base_url().'index.php/dashboard','refresh');
		}else{
			if($this->content==""){
/* $vals = array(
        'img_path'      => './assets/images/',
        'img_url'       => base_url().'assets/images/',
        'font_path'     => './sys/fonts/texb.ttf',
        'img_width'     => '200',
        'img_height'    => 40,
        'expiration'    => 90,
        'word_length'   => 4,
        'font_size'     => 16,
        'img_id'        => 'Imageid',
        'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',

        // White background and border, black text and red grid
        'colors'        => array(
                'background' => array(255, 255, 255),
                'text' => array(0, 0, 0)
        )
);

$cap = create_captcha($vals);
$data = array(
        'captcha_time'  => $cap['time'],
        'ip_address'    => $this->input->ip_address(),
        'word'          => $cap['word']
);
$expiration = time()-900;
$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
$query = $this->db->insert_string('captcha', $data);
$this->db->query($query);
//echo $cap['image'];
$this->session->set_userdata('captchaword', $cap['word']);
				$data['chaptca'] = $cap['image'];//$this->get_chaptca(4); */
				$data['chaptca'] = $this->get_chaptca(4);
				$this->content = $this->load->view('content/home/index',$data,true);
			}
			$data = array('_add_header_' => $add_header,
						  '_appname_' => 'CFS CENTER',
						  '_content_' => $this->content);
			$this->parser->parse('parse_login', $data);
		}
	}

	private function get_chaptca($param){ // method pembuat chapta
		$alphabet   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$num        = range(0, 35);
		$result     = '';
		shuffle($num);
		for ($x = 0; $x < $param; $x++){
			$result .= substr($alphabet, $num[$x], 1);
		}
			return $result;
    }

	function forgot_password(){
		if($this->content==""){
			$this->content = $this->load->view('content/home/forgot_password','',true);
		}
		$this->index();
	}

	function lupa(){
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if($this->form_validation->run() == FALSE) {
			$this->forgot_password();
		}else{
			$user_email=$this->input->post('email');
			$this->load->model('m_home');
			$result=$this->m_home->reset_password($user_email);
			if($result == '0'){
				$this->session->set_flashdata('result_error', "Email address doesn't exist!");
				redirect('home/forgot_password');
			}else{
				$this->session->set_flashdata('result', $result);
				redirect('home/forgot_password');
			}
		}
	}

	/* function create_captcha(){
		$options = array(
			'img_path' => './captcha/',
			'img_url' => base_url().'captcha/',
			'font_path' => './system/fonts/impact.ttf',
			'img_width' => '150',
			'img_heigt' => '30',
			'expiration' => 7200
		);

		$cap = create_captcha($options);
		$image = $cap['image'];
		$this->session->set_userdata('captchaword', $cap['word']);

		return $image;
	} */

	function check_captcha(){
		if($this->input->post('captcha') == $this->session->userdata('captchaword')){
			return true;
		}else{
			$this->form_validation->set_message('check_captcha', 'Captcha Is Wrong');
			return false;
		}
	}

	function autocomplete($act,$get){
		$this->load->model("m_home");
		$this->m_home->autocomplete($act,$get);
	}

	/* function sign_up(){
		if($this->content==""){
			#$q = $this->db->query("select ID from app_user order by ID desc limit 1");
			#$data['idm'] = $q->row();			
			$this->content = $this->load->view('content/home/sign_up','',true);
		}
		$this->index();
	} */

	public function uname(){
		$uname=array('USERLOGIN' => $this->input->post('username'),'KD_STATUS !=' => 'BLOCKED');
		$queryr = $this->db->get_where('app_user', $uname);
		if($queryr->num_rows() > 0){
			echo 'false';
		}else {
			echo 'true';
		}
	}

	public function umail(){
		$umail=array('EMAIL' => $this->input->post('email'),'KD_STATUS !=' => 'BLOCKED');
		$queryr = $this->db->get_where('app_user', $umail);
		if($queryr->num_rows() > 0){
			echo 'false';
		}else {
			echo 'true';
		}
	}

	/* function sign_up_cek(){
		if ($this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				redirect(base_url());
				exit();
			}else{
					$this->load->model("m_home");
					$rr = $this->m_home->signup();
					if($rr==0){
						$this->session->set_flashdata('result_error', "Data gagal diproses. ");
					}elseif($rr==3){
						$this->session->set_flashdata('result_error', "Data gagal diproses. Perusahaan Anda sudah terdaftar.");
					}elseif($rr==2){
						$this->session->set_flashdata('result', "Data berhasil diproses. Silahkan cek email Anda. Mailer Error.");
					}else{
						$this->session->set_flashdata('result', "Data berhasil diproses. Silahkan cek email Anda.");
					}
					redirect('home/sign_up');
			}
		}
	} */

	function reset_password(){
		//echo $this->newsession->userdata('USERLOGIN');die();
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
		if($this->newsession->userdata('USERLOGIN')!=""){
			if($this->content==""){
				$this->load->library('newtable');
				$this->newtable->breadcrumb('Reset Password', site_url());
				$this->content = $this->load->view('content/home/password','',true);
			}
			$data = array('_add_header_'   => $add_header,
						  '_add_script_'   => $add_script,
						  '_tittle_'  	   => 'CFS CENTER',
						  '_header_'  	   => $this->load->view('content/header','',true),
						  '_breadcrumbs_'  => $this->load->view('content/breadcrumbs','',true),
						  '_menus_'   	   => $this->load->view('content/menus','',true),
						  '_content_' 	   => $this->content,
						  '_footer_'  	   => $this->load->view('content/footer','',true));
			$this->parser->parse('verify', $data);
		}else{
			redirect(base_url('index.php'),'refresh');
		}
	}

	function execute($type="",$act=""){
		if ($this->newsession->userdata('USERLOGIN')==""){
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				redirect(base_url());
				exit();
			}else{
				$this->load->model("m_home");
				$this->m_home->execute($type,$act);
			}
		}
	}

	function ceklogin($sessid=""){
		$arrayReturn = array();
		$returnData = "";

		if(strtolower($_SERVER['REQUEST_METHOD'])!="post" || $this->session->userdata('session_id')!=$sessid){
			$returnData = "0|Login failed, please refresh page";
		}else{
			$uid = $this->input->post('username');
			$pwd = $this->input->post('password');
			$code = $this->input->post('code');
			//if(strtolower($code)===$_SESSION['captkodex'])
			#$this->form_validation->set_rules('captcha', 'Captcha', 'trim|callback_check_captcha|required');
			if(strcasecmp($this->input->post('txt_chaptca_real'), $this->input->post('txt_chaptca')) == 0){
			#if ($this->form_validation->run() == true) {
				$this->load->model('m_home');
				$hasil = $this->m_home->login($uid, md5($pwd));
				if($hasil > 0){
					if($hasil==2){
						$returnData = "1|Login success, Please change your password|".$this->get_next_link($hasil);
					}else{
						$returnData = "1|Login success|".$this->get_next_link($hasil);
					}
				}else{
					$returnData = "0|Wrong username or password";
				}
			}
			else
			{
				$returnData = "0|Wrong capctha code";
			}

		}

		$arrayReturn['returnData'] = $returnData;
		echo json_encode($arrayReturn);


	}

	function get_next_link($result){
		if($result==1){
			$returnLink = base_url()."index.php/dashboard";
		}else if($result==2){
			$returnLink = site_url()."/home/reset_password";
		}
		return $returnLink;
	}

	function signout(){
		$this->newsession->sess_destroy();
			redirect(base_url(),'refresh');
	}
}
