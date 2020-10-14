<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_popup extends Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	function popup_search($act,$id,$popup,$ajax){	
#		ECHO $act.' - '.$id.' - '.$popup.' - '.$ajax;
		$func = get_instance();
		$this->load->library('newtable');
		$KD_USER = $this->newsession->userdata('ID');
		$KD_ORG = $this->newsession->userdata('KD_ORGANISASI');
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$arract = explode("|",$act);
		$showchk = true;
		if($id!="")	$id = "/".$id;
		if($ajax!="") $ajax = "/".$ajax;
		if($arract[0]=="discharge_kontainer"){
			$judul = "DISCHARGE - KONTAINER";
			$SQL = "SELECT A.NO_CONT AS 'NOMOR KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN,
					func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS') AS JENIS,
					func_name(IFNULL(A.KD_CONT_TIPE,'-'),'CONT_TIPE') AS TIPE, A.ID
					FROM t_cocostscont A 
					INNER JOIN t_cocostshdr B ON B.ID=A.ID
					WHERE B.KD_ASAL_BRG = '1'
					AND A.ID = ".$this->db->escape($arract[1]);
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','icon md-check',$popup));
			$this->newtable->search(array(array('NO_CONT', 'NOMOR KONTAINER')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."|".$arract[1].$id."/".$popup);
			$this->newtable->hiddens(array('ID'));			
			$this->newtable->keys(array("ID","NOMOR KONTAINER"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}else if($arract[0]=="gatein_kontainer"){
			$judul = "DISCHARGE - KONTAINER";
			$SQL = "SELECT A.NO_CONT AS 'NOMOR KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN,
					func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS') AS JENIS,
					func_name(IFNULL(A.KD_CONT_TIPE,'-'),'CONT_TIPE') AS TIPE, A.ID
					FROM t_cocostscont A 
					INNER JOIN t_cocostshdr B ON B.ID=A.ID
					WHERE B.KD_ASAL_BRG = '3'
					AND A.ID = ".$this->db->escape($arract[1]);
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','icon md-check',$popup));
			$this->newtable->search(array(array('NO_CONT', 'NOMOR KONTAINER')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."|".$arract[1].$id."/".$popup);
			$this->newtable->hiddens(array('ID'));			
			$this->newtable->keys(array("ID","NOMOR KONTAINER"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}else if($arract[0]=="organisasi"){
			$judul = "ORGANISASI";
			if($KD_GROUP != "SPA"){
				$addsql .= " AND ID = ".$this->db->escape($KD_ORG);
			}
			if($arract[1]!=""){
				$addsql .= " AND KD_TIPE_ORGANISASI = ".$this->db->escape($arract[1]);
			}
			$SQL = "SELECT ID, NPWP, NAMA, ALAMAT, KD_TIPE_ORGANISASI AS 'GROUP'
					FROM t_organisasi WHERE 1=1".$addsql;
					
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','icon md-check','',$popup));
			$this->newtable->search(array(array('NPWP', 'NPWP'),array('NAMA', 'NAMA'),array('ALAMAT', 'ALAMAT')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."|".$arract[1]."/".$id."/".$popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("ID","NAMA"));
			$this->newtable->orderby(3);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}else if($arract[0]=="terminal"){
			$judul = "TERMINAL";
			$SQL = "SELECT A.KD_TPS AS 'KODE TPS', B.NAMA_TPS AS 'NAMA TPS', A.KD_GUDANG AS 'KODE GUDANG', A.NAMA_GUDANG AS 'NAMA GUDANG',
					CONCAT(NAMA_GUDANG, ' - ', NAMA_TPS) AS 'NAMA'
					FROM reff_gudang A
					INNER JOIN reff_tps B ON B.KD_TPS=A.KD_TPS WHERE A.TIPE = 1 AND A.KD_GUDANG <> 'CART'";
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','icon md-check','',$popup));
			$this->newtable->search(array(array('A.KD_TPS', 'KODE TPS'),array('B.NAMA_TPS', 'NAMA TPS'),array('A.KD_GUDANG', 'KODE GUDANG'),array('A.NAMA_GUDANG', 'NAMA GUDANG')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array('NAMA'));
			$this->newtable->keys(array("KODE TPS","KODE GUDANG","NAMA"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}else if($arract[0]=="warehouse"){
			$judul = "WAREHOUSE";
			$SQL = "SELECT A.KD_TPS AS 'KODE TPS', B.NAMA_TPS AS 'NAMA TPS', A.KD_GUDANG AS 'KODE GUDANG', A.NAMA_GUDANG AS 'NAMA GUDANG',
					CONCAT(NAMA_GUDANG, ' - ', NAMA_TPS) AS 'NAMA'
					FROM reff_gudang A
					INNER JOIN reff_tps B ON B.KD_TPS=A.KD_TPS WHERE A.TIPE = 2 AND A.KD_GUDANG IN ('BAND','RAYA')";
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','icon md-check','',$popup));
			$this->newtable->search(array(array('A.KD_TPS', 'KODE TPS'),array('B.NAMA_TPS', 'NAMA TPS'),array('A.KD_GUDANG', 'KODE GUDANG'),array('A.NAMA_GUDANG', 'NAMA GUDANG')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array('NAMA'));
			$this->newtable->keys(array("KODE TPS","KODE GUDANG","NAMA"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}else if($arract[0]=="mst_gudang"){
			$judul = "GUDANG";
			$SQL = "SELECT A.KD_TPS AS 'KODE TPS', B.NAMA_TPS AS 'NAMA TPS', A.KD_GUDANG AS 'KODE GUDANG', A.NAMA_GUDANG AS 'NAMA GUDANG'
					FROM reff_gudang A
					INNER JOIN reff_tps B ON B.KD_TPS=A.KD_TPS";
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','icon md-check',$popup));
			$this->newtable->search(array(array('A.KD_TPS', 'KODE TPS'),array('B.NAMA_TPS', 'NAMA TPS'),array('A.KD_GUDANG', 'KODE GUDANG'),array('A.NAMA_GUDANG', 'NAMA GUDANG')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array(''));
			$this->newtable->keys(array("KODE TPS","KODE GUDANG","NAMA GUDANG"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}else if($arract[0]=="app_user"){
			$judul = "USER";
			if($KD_GROUP != "SPA"){
				$addsql .= " AND KD_GROUP = 'USR' AND KD_ORGANISASI = ".$this->db->escape($KD_ORG);
			}
			$SQL = "SELECT USERLOGIN, NM_LENGKAP AS NAMA, HANDPHONE, EMAIL, KD_GROUP AS 'GROUP', ID
					FROM app_user WHERE KD_STATUS != 'BLOCKED'".$addsql;
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih/".$id, '1','','icon-check','',$popup));
			$this->newtable->search(array(array('USERLOGIN', 'USERLOGIN'),array('NAMA_LENGKAP', 'NAMA LENGKAP')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array());			
			$this->newtable->keys(array("ID","USERLOGIN","NM_LENGKAP"));
			$showchk = true;
		}else if($arract[0]=="mst_alasan_plp"){
			$judul = "ALASAN PLP";
			$SQL = "SELECT ID, NAMA FROM reff_alasan_plp";
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','icon md-check',$popup));
			$this->newtable->search(array(array('NAMA', 'ALASAN PLP')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array('ID'));
			$this->newtable->keys(array("ID","NAMA"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}else if($arract[0]=="iso_code"){
			$judul = "ISO CODE";
			$SQL = "SELECT ID AS KODE, NAMA FROM reff_cont_isocode";
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','icon md-check',$popup));
			$this->newtable->search(array(array('NAMA', 'ISO CODE')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."/".$id."/".$popup);
			$this->newtable->hiddens(array(''));
			$this->newtable->keys(array("KODE","NAMA"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}else if($arract[0]=="mst_dokbc"){
			$judul = "ISO CODE";
			$SQL = "SELECT ID AS KODE, NAMA FROM reff_kode_dok_bc WHERE KD_PERMIT = ".$this->db->escape($arract[1]);
			$proses = array('SELECT' => array('OPTION', site_url()."/popup/pilih".$id, '1','','icon md-check',$popup));
			$this->newtable->search(array(array('NAMA', 'NAMA DOKUMEN')));
			$this->newtable->action(site_url()."/popup/popup_search/".$arract[0]."|".$arract[1]."/".$id."/".$popup);
			$this->newtable->hiddens(array(''));
			$this->newtable->keys(array("KODE","NAMA"));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$showchk = true;
		}
		$this->newtable->multiple_search(false);
		$this->newtable->tipe_proses('button');
		$this->newtable->show_chk($showchk);
		$this->newtable->show_search(true);
		$this->newtable->cidb($this->db);
		$this->newtable->set_formid("tblsearch");
		$this->newtable->set_divid("divtblsearch");
		$this->newtable->rowcount(10);
		$this->newtable->clear(); 
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);			
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post") return $tabel;				 
		else return $arrdata;
	}
	
	function pilih($id,$ajax){
		$arrayReturn = array();
		$arrfield = explode('|',$id);
		if(count($arrfield>0)){
			foreach($this->input->post('tb_chktblsearch') as $chkitem){
				$arrdata[]  = $chkitem;
			}
			$value = implode($arrdata,",");
			$arrvalue = explode("~",$value);
		}
		$arrayReturn = array('arrvalue' => $arrvalue, 'arrfield' => $arrfield);
		echo json_encode($arrayReturn);
	}
	
	public function execute($type,$act){
		$post = $this->input->post('term');
		if($type=="mst_kapal"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA, CALL_SIGN 
					FROM reff_kapal 
					WHERE ID LIKE '%".$post."%' OR NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					if($act=="kode"){
						$arrayDataTemp[] = array("value"=>$KODE,"label"=>$NAMA,'NAMA'=>$NAMA);
					}else if($act=="nama"){
						$arrayDataTemp[] = array("value"=>$NAMA,"KD_KAPAL"=>$KODE,'NAMA'=>$NAMA);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_port"){
			if (!$post) return;
			$SQL = "SELECT ID, CONCAT(NAMA,'[',ID,']') AS NAMA, NAMA AS GET_NAME
					FROM reff_pelabuhan WHERE ID LIKE '%".$post."%' OR NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$GET = strtoupper($row->GET_NAME);
					if($act=="kode"){
						$arrayDataTemp[] = array("value"=>$KODE,"label"=>$NAMA,"NAMA"=>$GET);	
					}else if($act=="nama"){
						$arrayDataTemp[] = array("value"=>$GET,"label"=>$NAMA,"KODE"=>$KODE);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_kemasan"){
			if (!$post) return;
			$SQL = "SELECT ID, CONCAT(NAMA,' [',ID,']') AS NAMA, NAMA AS GET_NAME
					FROM reff_kemasan WHERE ID LIKE '%".$post."%' OR NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$GET = strtoupper($row->GET_NAME);
					if($act=="kode"){
						$arrayDataTemp[] = array("value"=>$KODE,"label"=>$NAMA,'NAMA'=>$GET);
					}else if($act=="nama"){
						$arrayDataTemp[] = array("value"=>$GET,"label"=>$NAMA,'KODE'=>$KODE);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_dok_bc"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM reff_kode_dok_bc 
					WHERE KD_PERMIT = ".$this->db->escape(strtoupper($act))."
					AND NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_isocode"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM reff_cont_isocode
					WHERE ID LIKE '%".$post."%' OR NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_organisasi"){
			if (!$post) return;
			if($act!=""){
				$add_sql = " AND KD_TIPE_ORGANISASI = ".$this->db->escape($act);
			}
			$SQL = "SELECT ID, NAMA FROM t_organisasi 
					WHERE NAMA LIKE '%".$post."%'".$add_sql."
					LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="mst_gudang"){
			if (!$post) return;
			$SQL = "SELECT KD_TPS, KD_GUDANG, NAMA_GUDANG FROM reff_gudang 
					WHERE KD_GUDANG LIKE '%".$post."%' OR NAMA_GUDANG LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KD_TPS = strtoupper($row->KD_TPS);
					$KD_GUDANG = strtoupper($row->KD_GUDANG);
					$NM_GUDANG = strtoupper($row->NAMA_GUDANG);
					if($act=="kode"){
						$arrayDataTemp[] = array("value"=>$KD_GUDANG,"KD_TPS"=>$KD_TPS,"NM_GUDANG"=>$NM_GUDANG);
					}else if($act=="nama"){
						$arrayDataTemp[] = array("value"=>$NM_GUDANG,"KD_TPS"=>$KD_TPS,"NM_GUDANG"=>$NM_GUDANG);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($type=="res_plp"){
			if (!$post) return;
			$SQL = "SELECT A.ID, A.KD_KPBC, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN, A.NO_PLP, A.NO_SURAT, A.TGL_SURAT, A.NM_ANGKUT, 
					DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') AS TGL_PLP, A.NO_VOY_FLIGHT, A.CALL_SIGN, A.TGL_TIBA, A.NO_BC11, A.TGL_BC11
					FROM t_respon_plp_tujuan_v2_hdr A
					WHERE A.NO_PLP LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$PLP = strtoupper($row->NO_PLP);
					$TGL_PLP = $row->TGL_PLP;
					$arrayDataTemp[] = array("value"=>$PLP,"TGL_PLP"=>$TGL_PLP);
				}
			}
			echo json_encode($arrayDataTemp);	
		}
	}
	
	public function get_combobox($act,$id){
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		if($act=='cont_ukuran'){
			$sql = "SELECT ID, NAMA FROM reff_cont_ukuran ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}else if($act=='cont_jenis'){
			$sql = "SELECT ID, NAMA FROM reff_cont_jenis ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}else if($act=='cont_tipe'){
			$sql = "SELECT ID, NAMA FROM reff_cont_tipe ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}else if($act=='cont_isocode'){
			$sql = "SELECT ID, NAMA FROM reff_cont_isocode ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}else if($act=='cont_status'){
			$sql = "SELECT ID, NAMA FROM reff_cont_status ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}else if($act=='sarana_angkut'){
			$sql = "SELECT ID, NAMA FROM reff_sarana_angkut ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}else if($act=='dok_bc'){
			$sql = "SELECT ID, NAMA FROM reff_kode_dok_bc WHERE KD_PERMIT = ".$this->db->escape($id)." ORDER BY ID ASC";
			$arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}
		return $arrdata;
	}
}
?>