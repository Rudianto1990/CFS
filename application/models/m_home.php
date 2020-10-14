<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_home extends Model{

	function login($uid_, $pwd_, $adm=FALSE){
		$query = "SELECT A.ID AS USERID, A.USERLOGIN, A.PASSWORD, A.NM_LENGKAP, A.HANDPHONE, A.KD_ORGANISASI, A.KD_GROUP, B.KD_TPS, B.KD_GUDANG,
				  A.KD_STATUS, B.NPWP, B.NAMA AS NM_PERSH, B.ALAMAT AS ALAMAT_PERSH, B.NOTELP, B.NOFAX, B.EMAIL,
				  B.KD_TIPE_ORGANISASI,A.EMAIL AS EMAIL_USER,
				  C.NAMA AS NM_GROUP,F.NAMA AS NM_TIPE_GROUP, D.NAMA_GUDANG AS NM_GUDANG, E.NAMA_TPS, E.KD_KPBC, A.LAST_LOGIN, A.WK_REKAM,
				  ADDDATE(A.WK_REKAM, INTERVAL 3 MONTH) AS NEXT_3_MONTH, NOW() AS WK_NOW
				  FROM app_user A
				  INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
				  INNER JOIN reff_tipe_organisasi F ON B.KD_TIPE_ORGANISASI = F.ID
				  INNER JOIN app_group C ON A.KD_GROUP = C.ID
				  LEFT JOIN reff_gudang D ON A.KD_GUDANG = D.KD_GUDANG
				  LEFT JOIN reff_tps E ON E.KD_TPS=A.KD_TPS
				  WHERE (A.USERLOGIN = ".$this->db->escape($uid_)." OR A.EMAIL = ".$this->db->escape($uid_).") AND A.PASSWORD = ".$this->db->escape($pwd_)." ORDER BY A.ID DESC LIMIT 1";
				 // var_dump($SQL);die();
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$rs = $data->row();
			if($rs->KD_STATUS != 'ACTIVE'){
				return 0;
			}else{
				$sql = "SELECT A.WK_REKAM, ADDDATE(A.WK_REKAM, INTERVAL 3 MONTH) AS NEXT_3_MONTH, NOW() AS WK_NOW
						FROM app_user A
						WHERE DATE(NOW()) <= ADDDATE(DATE(A.WK_REKAM), INTERVAL 3 MONTH)
						AND (A.USERLOGIN = ".$this->db->escape($uid_)." OR A.EMAIL = ".$this->db->escape($uid_).") AND A.PASSWORD = ".$this->db->escape($pwd_);
						//var_dump($SQL);die();
				$result = $this->db->query($sql);
				if($result->num_rows() > 0){
					foreach($data->result_array() as $row){
						$datses['LOGGED'] = true;
						$datses['IP'] = $_SERVER['REMOTE_ADDR'];
						$datses['USERLOGIN'] = $row['USERLOGIN'];
						$datses['PASSWORD'] = $pwd_;
						$datses['ID'] = $row['USERID'];
						$datses['NM_LENGKAP'] = $row['NM_LENGKAP'];
						$datses['HANDPHONE'] = $row['HANDPHONE'];
						$datses['KD_ORGANISASI'] = $row['KD_ORGANISASI'];
						$datses['KD_GROUP'] = $row['KD_GROUP'];
						$datses['KD_GUDANG'] = $row['KD_GUDANG'];
						$datses['KD_TPS'] = $row['KD_TPS'];
						$datses['STATUS'] = $row['KD_STATUS'];
						$datses['NPWP'] = $row['NPWP'];
						$datses['NM_PERSH'] = $row['NM_PERSH'];
						$datses['ALAMAT_PERSH'] = $row['ALAMAT_PERSH'];
						$datses['NOTELP'] = $row['NOTELP'];
						$datses['NOFAX'] = $row['NOFAX'];
						$datses['EMAIL'] = $row['EMAIL'];
						$datses['EMAIL_USER'] = $row['EMAIL_USER'];
						$datses['TIPE_ORGANISASI'] = $row['KD_TIPE_ORGANISASI'];
						$datses['NM_TIPE_GROUP'] = $row['NM_TIPE_GROUP'];
						$datses['NM_GROUP'] = $row['NM_GROUP'];
						$datses['NM_GUDANG'] = $row['NM_GUDANG'];
						$datses['NM_TPS'] = $row['NAMA_TPS'];
						$datses['KD_KPBC'] = $row['KD_KPBC'];
						$datses['LAST_LOGIN'] = $row['LAST_LOGIN'];
					}
					$this->last_login($rs->USERID);
					$this->newsession->set_userdata($datses);
					return 1;
				}
				else{
					foreach($data->result_array() as $row){
						$datses['LOGGED'] = true;
						$datses['IP'] = $_SERVER['REMOTE_ADDR'];
						$datses['USERLOGIN'] = $row['USERLOGIN'];
						$datses['PASSWORD'] = $pwd_;
						$datses['ID'] = $row['USERID'];
						$datses['NM_LENGKAP'] = $row['NM_LENGKAP'];
						$datses['HANDPHONE'] = $row['HANDPHONE'];
						$datses['KD_ORGANISASI'] = $row['KD_ORGANISASI'];
						$datses['KD_GROUP'] = $row['KD_GROUP'];
						$datses['KD_GUDANG'] = $row['KD_GUDANG'];
						$datses['KD_TPS'] = $row['KD_TPS'];
						$datses['STATUS'] = $row['KD_STATUS'];
						$datses['NPWP'] = $row['NPWP'];
						$datses['NM_PERSH'] = $row['NM_PERSH'];
						$datses['ALAMAT_PERSH'] = $row['ALAMAT_PERSH'];
						$datses['NOTELP'] = $row['NOTELP'];
						$datses['NOFAX'] = $row['NOFAX'];
						$datses['EMAIL'] = $row['EMAIL'];
						$datses['EMAIL_USER'] = $row['EMAIL_USER'];
						$datses['TIPE_ORGANISASI'] = $row['KD_TIPE_ORGANISASI'];
						$datses['NM_TIPE_GROUP'] = $row['NM_TIPE_GROUP'];
						$datses['NM_GROUP'] = $row['NM_GROUP'];
						$datses['NM_GUDANG'] = $row['NM_GUDANG'];
						$datses['NM_TPS'] = $row['NAMA_TPS'];
						$datses['KD_KPBC'] = $row['KD_KPBC'];
						$datses['LAST_LOGIN'] = $row['LAST_LOGIN'];
					}
					$this->newsession->set_userdata($datses);
					return 2;
				}
			}
		}

		else
		{
			return 0;
		}

	}

	function last_login($ID){
		$data = array('LAST_LOGIN' => date('Y-m-d H:i:s'));
		$this->db->where('ID', $ID);
		$this->db->update('app_user', $data);
	}

	public function insertToken($user_id){
		$token = substr(sha1(rand()), 0, 30);
		$date = date('Y-m-d');
		$string = array(
			'KETERANGAN'=> $token,
			'LAST_LOGIN'=>$date
		);
		$this->db->where(array('ID' => $user_id));
		$this->db->update('app_user',$string);
		$data = $token . $user_id;
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	public function getUserInfo($id){
		$q = $this->db->get_where('app_user', array('ID' => $id), 1);
		if($this->db->affected_rows() > 0){
			$row = $q->row();
			return $row;
		}else{
			error_log('no user found getUserInfo('.$id.')');
			return false;
		}
	}

	public function isTokenValid($data)  {
		$token = base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
		$tkn = substr($token,0,30);
		$uid = substr($token,30);
		$q = $this->db->get_where('app_user', array(
			'KETERANGAN' => $tkn,
			'ID' => $uid), 1);
		if($this->db->affected_rows() > 0){
			$row = $q->row();
			$created = $row->LAST_LOGIN;
			$createdTS = strtotime($created);
			$today = date('Y-m-d');
			$todayTS = strtotime($today);
			if($createdTS != $todayTS){
				return false;
			}
			$user_info = $this->getUserInfo($row->ID);
			return $user_info;
		}else{
			return false;
		}
	}

	function reset_password($toemail){
		$array = array('email' => $toemail, 'KD_STATUS' => 'ACTIVE');
		$this->db->where($array);
		$queryr=$this->db->get('app_user');
		$userInfo = $queryr->row();
		if($queryr->num_rows() != "1"){
			return "0";
		}
		//build token
		$token = $this->insertToken($userInfo->ID);
		$url = site_url() . '/reset_password/token/' . $token;
		$link = '<a href="' . $url . '">' . $url . '</a>';
		$message = '';
		$message .= '<strong>Hai, anda menerima email ini karena ada permintaan untuk memperbaharui
		password anda.</strong><br>';
		$message .= '<strong>Silakan klik link ini:</strong> ' . $link;

		$fromemail="cfs@edi-indonesia.co.id";
		$fromname="Admin CFS Center";
		$subject="Password Changed";
		$this->load->helper('email');
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'mail2.edi-indonesia.co.id',
			'smtp_port' => 25,
			'smtp_user' => '',
			'smtp_pass' => '',
			'mailtype'  => 'html',
			'charset'   => 'iso-8859-1',
			'wrapchars' => 100,
			'crlf'         => "\r\n",
			'newline'     => "\r\n",
			'start_tls' => TRUE
		);
		$this->load->library('email', $config);
		#$this->email->set_newline("\r\n");
		$this->email->from($fromemail, $fromname);
		#$email = str_replace(';', ',', $email);
		$this->email->to($toemail);
		//$array_bcc = array('ric.corporation@gmail.com','rizki@edi-indonesia.co.id','salman.abdulaziz@edi-indonesia.co.id');
		//$this->email->bcc($array_bcc);
		$this->email->subject($subject);
		$this->email->message($message);
		if(!$this->email->send()){
			return "Mailer Error ";
		}else{
			return "Password reset and an email sent with new password!";
		}
	}

	public function updatePassword($post){
		$this->db->where('ID', $post);
		$this->db->update('app_user', array('PASSWORD' => md5($this->input->post('password')),'KETERANGAN' => NULL));
		return true;
	}

	function signup(){
		$DATA['NM_LENGKAP'] = $this->input->post('fullname');
		$DATA['USERLOGIN'] = $this->input->post('username');
		$DATA['EMAIL'] = $this->input->post('email');
		$DATA['HANDPHONE'] = $this->input->post('telpon');
		$DATA['PASSWORD'] = md5($this->input->post('password'));
		$DATA['KD_GROUP'] = 'ADM';
		$DATA['KD_STATUS'] = 'INACTIVE';
		//$DATA['WK_REKAM'] = date('Y-m-d H:i:s');
		$npwp1=str_replace("-","",$this->input->post('npwpcompany'));$npwp=str_replace(".","",$npwp1);
		//$DATA_ORG['NPWP'] = $this->input->post('npwpcompany');
		$queryOR = "SELECT * FROM app_user A INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID WHERE A.KD_STATUS='ACTIVE' AND B.NPWP=".$this->db->escape($npwp);
		$cekOR = $this->db->query($queryOR);
		if($cekOR->num_rows() > 0){
			return 3;
		}else{
		if($this->input->post('kd_company')==''){
			$DATA_ORG['ID_ORGANISASI']=$this->input->post('cust_no');
			$DATA_ORG['NAMA']=$this->input->post('company');
			$DATA_ORG['NPWP'] = $npwp;
			$DATA_ORG['ALAMAT'] = $this->input->post('alamatcompany');
			$DATA_ORG['EMAIL'] = $this->input->post('emailcompany');
			$DATA_ORG['NOTELP'] = $this->input->post('telponcompany');
			$DATA_ORG['NOFAX'] = $this->input->post('faxcompany');
			$DATA_ORG['KD_TIPE_ORGANISASI'] = $this->input->post('role');
			$DATA_ORG['JENIS_ORGANISASI'] = $this->input->post('jns_badan');
			$this->db->insert('t_organisasi', $DATA_ORG);
			$DATA['KD_ORGANISASI']=$this->db->insert_id();
		}else{
			$DATA['KD_ORGANISASI']=$this->input->post('kd_company');
		}
		/*$query = "SELECT * FROM app_user A INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID WHERE A.KD_STATUS='ACTIVE' AND A.KD_ORGANISASI='".$DATA['KD_ORGANISASI']."'";
		$cek = $this->db->query($query);
		if($cek->num_rows() > 0){
			return 3;
		}else{*/
			$exec = $this->db->insert('APP_USER', $DATA);
			if(!$exec){
				return 0;
				#echo "MSG#OK#Data berhasil diproses#".base_url()."application.php/dashboard";
			}else{
				$message = '';
				$message .= '<strong>Terimakasih telah melakukan pendaftaran CFS Center.</strong><br>';
				$message .= '<strong>Silakan menunggu email permberitahuan approve dari Admin.</strong>';
				$toemail = $this->input->post('email');
				$fromemail="cfs@edi-indonesia.co.id";
				$fromname="Admin CFS Center";
				$subject="User CFS Center";
				$this->load->helper('email');
				$config = array(
					'protocol'  => 'smtp',
					'smtp_host' => 'mail2.edi-indonesia.co.id',
					'smtp_port' => 25,
					'smtp_user' => '',
					'smtp_pass' => '',
					'mailtype'  => 'html',
					'charset'   => 'iso-8859-1',
					'wrapchars' => 100,
					'crlf'      => "\r\n",
					'newline'   => "\r\n",
					'start_tls' => TRUE
				);
				$this->load->library('email', $config);
				$this->email->from($fromemail, $fromname);
				$this->email->to($toemail);
				//$this->email->bcc('bobi@edi-indonesia.co.id');
				$this->email->subject($subject);
				$this->email->message($message);
				if(!$this->email->send()){
					return 2;
				}else{
					return 1;
				}
			}
		}
	}

	function execute($type, $act){
		//$func = get_instance();
        //$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$message = "";
		$USERLOGIN = $this->newsession->userdata('USERLOGIN');
		if($type=="update"){
			if($act=="reset_password"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = $b;
				}
				$query = "SELECT A.ID AS USERID
						  FROM app_user A
						  INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
						  INNER JOIN app_group C ON A.KD_GROUP = C.ID
						  LEFT JOIN reff_gudang D ON A.KD_GUDANG = D.KD_GUDANG
						  LEFT JOIN reff_tps E ON E.KD_TPS=A.KD_TPS
						  WHERE A.USERLOGIN = ".$this->db->escape($USERLOGIN)." AND A.PASSWORD = ".$this->db->escape(md5($DATA['PASS_OLD']));
				$data = $this->db->query($query);
				if($data->num_rows() > 0){
					$rs = $data->row();
					if($DATA['PASS_NEW']==$DATA['PASS_CONFIRM']){
						$ARRDATA['PASSWORD'] = md5($DATA['PASS_NEW']);
						$ARRDATA['WK_REKAM'] = date('Y-m-d H:i:s');
						$ARRDATA['KETERANGAN'] = NULL;
						$this->db->where(array('ID' => $rs->USERID));
						$exec = $this->db->update('app_user', $ARRDATA);
						if($exec){
							$this->last_login($rs->USERID);
							$datses['LOGGED'] = true;
							$this->newsession->set_userdata($datses);
						}
					}else{
						$error += 1;
						$message .= "Data gagal diproses, Konfirmasi password tidak sesuai";
					}
				}else{
					$error += 1;
					$message .= "Data gagal diproses, Password lama tidak sesuai";
				}
				if($error == 0){
					//$func->main->get_log("update","app_user");
					echo "MSG#OK#Data berhasil diproses#".base_url()."index.php/dashboard";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		}
	}

	function autocomplete($act,$get){
		$post = $this->input->post('term');
		if($act=="organisasi"){
				if (!$post) return;
				$SQL = "SELECT ID, NAMA AS GET_NAME, EMAIL, ALAMAT, NPWP, NOTELP, NOFAX FROM t_organisasi
				WHERE NAMA LIKE '%".$post."%' OR EMAIL LIKE '%".$post."%' OR ALAMAT LIKE '%".$post."%' OR
				NPWP LIKE '%".$post."%' OR NOTELP LIKE '%".$post."%' OR NOFAX LIKE '%".$post."%' LIMIT 5";
				$result = $this->db->query($SQL);
				$banyakData = $result->num_rows();
				$arrayDataTemp = array();
				if($banyakData > 0){
					foreach($result->result() as $row){
						$KODE = strtoupper($row->ID);
						$NAMA = strtoupper($row->GET_NAME);
						$ALAMAT = strtoupper($row->ALAMAT);
						$EMAIL = strtoupper($row->EMAIL);
						$NPWP = strtoupper($row->NPWP);
						$NOTELP = strtoupper($row->NOTELP);
						$NOFAX = strtoupper($row->NOFAX);
						if($get=="kode"){
							$arrayDataTemp[] = array("value"=>$KODE,"NAMA"=>$NAMA,"ALAMAT"=>$ALAMAT,"EMAIL"=>$EMAIL,
							"NPWP"=>$NPWP,"NOTELP"=>$NOTELP,"NOFAX"=>$NOFAX);
						}elseif($get=="nama"){
							$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE,"ALAMAT"=>$ALAMAT,"EMAIL"=>$EMAIL,
							"NPWP"=>$NPWP,"NOTELP"=>$NOTELP,"NOFAX"=>$NOFAX);
						}
					}
				}
			echo json_encode($arrayDataTemp);
		}
	}
}
?>
