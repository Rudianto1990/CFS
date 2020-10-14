<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_dokumen extends Model {

	public function __construct(){
		parent::__construct();
	}

	function get_combobox($act,$id){
        $func = get_instance();
        $func->load->model("m_main", "main", true);
		if($act == "dok_bc"){
            $sql = "SELECT ID, NAMA FROM reff_kode_dok_bc WHERE KD_PERMIT = '".$id."' ORDER BY ID ASC";
            $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}
		return $arrdata;
	}

	function get_comboboxnamagudang($find){
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        if($find=="GUDANG"){
          $sql = "SELECT KD_GUDANG,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '2' and KD_GUDANG in ('BAND','RAYA','PSKA') ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "NAMA_GUDANG", TRUE);
        }else if($find == "TPS"){
          $sql = "SELECT KD_GUDANG,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '1' and KD_GUDANG <> 'CART' ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "NAMA_GUDANG", TRUE);
        }
        
		return $arrdata;
	}

	function autocomplete($type,$act,$get){
		$post = $this->input->post('term');
		if($type=="manual"){
			if($act=="ppjk"){
			  if (!$post) return;
			  $SQL = "SELECT A.NAMA_PPJK,func_npwp(A.NPWP_PPJK) as NPWP_PPJK,A.ALAMAT_PPJK FROM t_permit_hdr A WHERE A.NAMA_PPJK IS NOT NULL AND A.ID_LOG <> 'DEMO' AND A.NAMA_PPJK LIKE '".$post."%' GROUP BY A.NPWP_PPJK LIMIT 5"; 
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $NAMA_PPJK = strtoupper($row->NAMA_PPJK);
				  $NPWP_PPJK = strtoupper($row->NPWP_PPJK);
				  $ALAMAT_PPJK = strtoupper($row->ALAMAT_PPJK);
				  $arrayDataTemp[] = array(
					"value"=>$NAMA_PPJK,"NPWP_PPJK"=>$NPWP_PPJK,"ALAMAT_PPJK"=>$ALAMAT_PPJK
				  );
				}
			  } 
			}elseif($act=="consignee"){
			  if (!$post) return;
			  $SQL = "SELECT A.CONSIGNEE,func_npwp(A.ID_CONSIGNEE) as ID_CONSIGNEE,A.ALAMAT_CONSIGNEE FROM t_permit_hdr A WHERE A.CONSIGNEE IS NOT NULL AND A.ID_LOG <> 'DEMO' AND A.CONSIGNEE LIKE '".$post."%' GROUP BY A.NPWP_PPJK LIMIT 5"; 
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $CONSIGNEE = strtoupper($row->CONSIGNEE);
				  $ID_CONSIGNEE = strtoupper($row->ID_CONSIGNEE);
				  $ALAMAT_CONSIGNEE = strtoupper($row->ALAMAT_CONSIGNEE);
				  $arrayDataTemp[] = array(
					"value"=>$CONSIGNEE,"ID_CONSIGNEE"=>$ID_CONSIGNEE,"ALAMAT_CONSIGNEE"=>$ALAMAT_CONSIGNEE
				  );
				}
			  } 
			}
			echo json_encode($arrayDataTemp);
		}
	}

	public function impor_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "RESPONS";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if($TIPE_ORGANISASI!="SPA" && $TIPE_ORGANISASI!="PCFS"){
			$addsql .= " AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}

		$SQL = "SELECT B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO. : ',IFNULL(A.NO_DOK_INOUT,'-'),
				'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y'),'-')) AS DOKUMEN,
				CONCAT('NO. : ',IFNULL(A.NO_DAFTAR_PABEAN,'-'),
				'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y'),'-')) AS 'DAFTAR PABEAN',
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE', A.NM_ANGKUT AS 'NAMA ANGKUT',
				CONCAT('KONTAINER : ',(select count(C.ID) from t_permit_cont C where C.ID=A.ID),'<br/>KEMASAN : ',(select count(C.ID) from t_permit_kms C where C.ID=A.ID)) AS 'JUMLAH', A.TGL_STATUS, A.ID
				FROM t_permit_hdr A 
				INNER JOIN reff_kode_dok_bc B ON B.ID=A.KD_DOK_INOUT AND B.KD_PERMIT='IMP' WHERE A.ID_LOG <> 'MANUAL'".$addsql;
		#echo $SQL;die();
		$proses = array(
					'DETAIL' => array('MODAL',"dokumen/impor/detail", '1','','icon-magnifier-add'),
					'UPDATE' => array('MODAL',"dokumen/impor/update", '1','','icon-pencil')
				);
		#'GENERATE' => array('POST',"execute/process/update/create_xml_impor", 'ALL','','md-code-setting'));
		$this->newtable_edit->multiple_search(true);
		$this->newtable_edit->show_chk(true);
		$this->newtable_edit->show_menu($check);
		$this->newtable_edit->show_search(true);
		$arr_dok = $this->get_combobox('dok_bc','IMP');
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS");
    	if($TIPE_ORGANISASI=="SPA" || $TIPE_ORGANISASI=="PCFS"){
			$this->newtable_edit->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NOMOR DOKUMEN'),array('A.TGL_DOK_INOUT','TANGGAL DOKUMEN','DATERANGE'),array('A.NM_ANGKUT','NAMA ANGKUT'),array('A.NO_BL_AWB','NOMOR B/L'),array('A.KD_GUDANG', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_GUDANG', 'KD TERMINAL', 'OPTION', $arrnamaTPS)));
		}else{
			$this->newtable_edit->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NOMOR DOKUMEN'),array('A.TGL_DOK_INOUT','TANGGAL DOKUMEN','DATERANGE'),array('A.NM_ANGKUT','NAMA ANGKUT')));
		}
		$this->newtable_edit->action(site_url() . "/dokumen/impor");
		#if($check) $this->newtable_edit->detail(array('POPUP',"dokumen/impor_kontainer/detail"));
		$this->newtable_edit->detail(array('POPUP',"dokumen/impor/detail"));
		$this->newtable_edit->tipe_proses('button');
		$this->newtable_edit->hiddens(array("ID","TGL_STATUS"));
		$this->newtable_edit->keys(array("ID"));
		$this->newtable_edit->cidb($this->db);
		$this->newtable_edit->orderby(8);
		$this->newtable_edit->sortby("DESC");
		$this->newtable_edit->set_formid("tblimpor");
		$this->newtable_edit->set_divid("divtblimpor");
		$this->newtable_edit->rowcount(10);
		$this->newtable_edit->clear();
		$this->newtable_edit->menu($proses);
		$tabel .= $this->newtable_edit->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post"){			
			echo $tabel;
		}			
		else{			
			return $arrdata;

		}
	}

	public function entry_impor($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "RESPONS";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if($TIPE_ORGANISASI!="SPA" && $TIPE_ORGANISASI!="PCFS"){
			$addsql .= " AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}

		$SQL = "SELECT B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO. : ',IFNULL(A.NO_DOK_INOUT,'-'),
				'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y'),'-')) AS DOKUMEN,
				CONCAT('NO. : ',IFNULL(A.NO_DAFTAR_PABEAN,'-'),
				'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y'),'-')) AS 'DAFTAR PABEAN',
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE', A.NM_ANGKUT AS 'NAMA ANGKUT',
				CONCAT('KONTAINER : ',(select count(C.ID) from t_permit_cont C where C.ID=A.ID),'<br/>KEMASAN : ',(select count(C.ID) from t_permit_kms C where C.ID=A.ID)) AS 'JUMLAH', A.TGL_STATUS, A.ID
				FROM t_permit_hdr A 
				INNER JOIN reff_kode_dok_bc B ON B.ID=A.KD_DOK_INOUT AND B.KD_PERMIT='IMP'
				WHERE A.ID_LOG='MANUAL'".$addsql;
		#echo $SQL;die();
		$proses = array('ENTRY' => array('ADD_MODAL',"dokumen/entry_impor/add", '0','','icon-plus'),
						'UPDATE' => array('GET',site_url()."/dokumen/entry_impor/update", '1','','icon-pencil'),
						'DELETE' => array('DELETE', site_url() . "/dokumen/execute/delete/entry_impor", 'ALL', '', 'icon-trash'),
						'DETAIL' => array('MODAL',"dokumen/entry_impor_kontainer/detail", '1','','icon-magnifier-add'));
						#'GENERATE' => array('POST',"execute/process/update/create_xml_impor", 'ALL','','md-code-setting'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$arr_dok = $this->get_combobox('dok_bc','IMP');
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS");
    	if($TIPE_ORGANISASI=="SPA" || $TIPE_ORGANISASI=="PCFS"){
			$this->newtable->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NOMOR DOKUMEN'),array('A.TGL_DOK_INOUT','TANGGAL DOKUMEN','DATERANGE'),array('A.NM_ANGKUT','NAMA ANGKUT'),array('A.KD_GUDANG', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_GUDANG', 'KD TERMINAL', 'OPTION', $arrnamaTPS)));
		}else{
			$this->newtable->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NOMOR DOKUMEN'),array('A.TGL_DOK_INOUT','TANGGAL DOKUMEN','DATERANGE'),array('A.NM_ANGKUT','NAMA ANGKUT')));
		}
		$this->newtable->action(site_url() . "/dokumen/entry_impor");
		$this->newtable->detail(array('POPUP',"dokumen/entry_impor/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","TGL_STATUS"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(8);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblimpor");
		$this->newtable->set_divid("divtblimpor");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post"){			
			echo $tabel;
		}			
		else{			
			return $arrdata;

		}
	}
	public function ekspor_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "RESPONS";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if($TIPE_ORGANISASI!="SPA" && $TIPE_ORGANISASI!="PCFS"){
			$addsql .= " AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT B.NAMA AS 'JENIS DOKUMEN', CONCAT('NO. : ',IFNULL(A.NO_DOK_INOUT,'-'),
				'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y'),'-')) AS DOKUMEN,
				CONCAT('NO. : ',IFNULL(A.NO_DAFTAR_PABEAN,'-'),
				'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y'),'-')) AS 'DAFTAR PABEAN',
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE', A.NM_ANGKUT AS 'NAMA ANGKUT',
				CONCAT('<center>',A.JML_CONT,'</center>') AS 'JUMLAH', A.TGL_STATUS, A.ID
				FROM t_permit_hdr A
				INNER JOIN reff_kode_dok_bc B ON B.ID=A.KD_DOK_INOUT AND B.KD_PERMIT='EXP'".$addsql;
		$proses = array('DETAIL' => array('POPUP',"dokumen/ekspor_kontainer/detail", '1','','icon-pencil'));
		$this->newtable_edit->multiple_search(true);
		$this->newtable_edit->show_chk($check);
		$this->newtable_edit->show_menu($check);
		$this->newtable_edit->show_search(true);
		$arr_dok = $this->get_combobox('dok_bc','EXP');
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS");
    	if($TIPE_ORGANISASI=="SPA" || $TIPE_ORGANISASI=="PCFS" || $TIPE_ORGANISASI=="PCFS"){
			$this->newtable_edit->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NO. DOKUMEN'),array('A.NM_ANGKUT','NAMA ANGKUT'),array('B.NO_CONT','NOMOR KONTAINER'),array('A.KD_GUDANG', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_GUDANG', 'KD TERMINAL', 'OPTION', $arrnamaTPS)));
		}else{
			$this->newtable_edit->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NO. DOKUMEN'),array('A.NM_ANGKUT','NAMA ANGKUT'),array('B.NO_CONT','NOMOR KONTAINER')));
		}
		$this->newtable_edit->action(site_url() . "/dokumen/ekspor_kontainer");
		if($check) $this->newtable_edit->detail(array('POPUP',"dokumen/ekspor_kontainer/detail"));
		$this->newtable_edit->detail(array('POPUP',"dokumen/ekspor_kontainer/detail"));
		$this->newtable_edit->tipe_proses('button');
		$this->newtable_edit->hiddens(array("ID"));
		$this->newtable_edit->keys(array("ID"));
		$this->newtable_edit->cidb($this->db);
		$this->newtable_edit->orderby(1);
		$this->newtable_edit->sortby("DESC");
		$this->newtable_edit->set_formid("tblekspor");
		$this->newtable_edit->set_divid("divtblekspor");
		$this->newtable_edit->rowcount(10);
		$this->newtable_edit->clear();
		$this->newtable_edit->menu($proses);
		$tabel .= $this->newtable_edit->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function kontainer_detail($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "DETAIL KONTAINER";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = false;
		
		$SQL = "SELECT A.NO_CONT AS 'NO. KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN,
				func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS') AS JENIS
				FROM t_permit_cont A
				WHERE A.ID = ".$this->db->escape($id);

		#$SQL = "SELECT A.NO_CONT AS 'NO. KONTAINER' FROM t_permit_cont A WHERE A.ID = ".$this->db->escape($id);



		#$proses = array('DETAIL' => array('MODAL',"dokumen/impor_kontainer_detail/detail", '1','','md-zoom-in'));
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','KONTAINER')));
		$this->newtable->action(site_url() . "/dokumen/kontainer_detail/".$act."/".$id);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/impor_kontainer_detail/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array("NO. KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldetail");
		$this->newtable->set_divid("divtbldetail");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function kemasan_detail($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "DETAIL KEMASAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = false;
		
		$SQL = "SELECT A.ID , func_name(IFNULL(A.JNS_KMS,'-'),'KEMASAN') AS 'JENIS KEMASAN',
				A.MERK_KMS AS 'MERK KEMASAN',A.JML_KMS AS JUMLAH
				FROM t_permit_kms A JOIN t_permit_hdr B ON B.ID=A.ID
				WHERE A.ID = ".$this->db->escape($id);

		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('JNS_KMS','KEMASAN')));
		$this->newtable->action(site_url() . "/dokumen/kemasan_detail/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkmsdetail");
		$this->newtable->set_divid("divtblkmsdetail");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}
	
	function execute($type, $act, $id) {  
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_KPBC = $this->newsession->userdata('KD_KPBC');
    
		if ($type == "save") {
			if($this->input->post('KD_KMS')[0]=='' && $this->input->post('NO_CONT')[0]==''){
				$error += 1;
				$message .= "Could not be processed data";
			}else{
				$NO_CONT = $this->input->post('NO_CONT');
				$UKURAN_CONT = $this->input->post('UKURAN_CONT');
				$JENIS_CONT = $this->input->post('JENIS_CONT');
				$KD_KMS = $this->input->post('KD_KMS');
				$JNS_KMS = $this->input->post('JNS_KMS');
				$JML_KMS = $this->input->post('JML_KMS');
				$MERK_KMS = $this->input->post('MERK_KMS');
				$TOTAL_CONT = count($NO_CONT);
				$TOTAL_KMS = count($KD_KMS);
				if($this->input->post('KD_DOK_INOUT')!="13"){
					$npwp1=str_replace("-","",strtoupper(trim(validate($this->input->post('ID_CONSIGNEE')))));$npwp=str_replace(".","",$npwp1);
				}else{
					$npwp=strtoupper(trim(validate($this->input->post('ID_CONSIGNEE'))));
				}
				$npwppj1=str_replace("-","",strtoupper(trim(validate($this->input->post('NPWP_PPJK')))));$npwppj=str_replace(".","",$npwppj1);
				$ubah= array(
				  'CAR'  				=> strtoupper(validate($this->input->post('CAR'))),
				  'KD_KANTOR' 			=> strtoupper(validate($this->input->post('KD_KANTOR'))),
				  'KD_KANTOR_PENGAWAS' 	=> strtoupper(validate($this->input->post('KD_KANTOR_PENGAWAS'))),
				  'KD_KANTOR_BONGKAR' 	=> strtoupper(validate($this->input->post('KD_KANTOR_BONGKAR'))),
				  'KD_DOK_INOUT'  		=> strtoupper(validate($this->input->post('KD_DOK_INOUT'))),
				  'NO_DOK_INOUT'		=> strtoupper(trim(validate($this->input->post('NO_DOK_INOUT')))),
				  'TGL_DOK_INOUT'  		=> strtoupper(validate(date_input($this->input->post('TGL_DOK_INOUT')))),
				  'NO_DAFTAR_PABEAN'	=> strtoupper(trim(validate($this->input->post('NO_DAFTAR_PABEAN')))),
				  'TGL_DAFTAR_PABEAN'	=> strtoupper(validate(date_input($this->input->post('TGL_DAFTAR_PABEAN')))),
				  'ID_CONSIGNEE'       	=> $npwp,
				  'CONSIGNEE'     		=> strtoupper(trim(validate($this->input->post('CONSIGNEE')))),
				  'ALAMAT_CONSIGNEE'    => strtoupper(trim(validate($this->input->post('ALAMAT_CONSIGNEE')))),
				  'NPWP_PPJK'   		=> ($this->input->post('NPWP_PPJK')=='')?NULL:$npwppj,
				  'NAMA_PPJK'        	=> ($this->input->post('NAMA_PPJK')=='')?NULL:strtoupper(trim(validate($this->input->post('NAMA_PPJK')))),
				  'ALAMAT_PPJK'         => ($this->input->post('ALAMAT_PPJK')=='')?NULL:strtoupper(trim(validate($this->input->post('ALAMAT_PPJK')))),
				  'NM_ANGKUT'        	=> ($this->input->post('NM_ANGKUT')=='')?NULL:strtoupper(trim(validate($this->input->post('NM_ANGKUT')))),
				  'NO_VOY_FLIGHT'       => ($this->input->post('NO_VOY_FLIGHT')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_VOY_FLIGHT')))),
				  'KD_GUDANG'			=> ($this->input->post('KD_GUDANG')=='')?NULL:strtoupper(validate($this->input->post('KD_GUDANG'))),
				  'JML_CONT'  			=> $TOTAL_CONT,
				  'BRUTO'				=> ($this->input->post('BRUTO')=='')?NULL:strtoupper(trim(validate($this->input->post('BRUTO')))),
				  'NETTO'        		=> ($this->input->post('NETTO')=='')?NULL:strtoupper(trim(validate($this->input->post('NETTO')))),
				  'NO_BC11'       		=> ($this->input->post('NO_BC11')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_BC11')))),
				  'TGL_BC11'      		=> ($this->input->post('TGL_BC11')=='')?NULL:strtoupper(validate(date_input($this->input->post('TGL_BC11')))),
				  'NO_POS_BC11'       	=> ($this->input->post('NO_POS_BC11')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_POS_BC11')))),
				  'NO_BL_AWB'   		=> ($this->input->post('NO_BL_AWB')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_BL_AWB')))),
				  'TGL_BL_AWB'        	=> ($this->input->post('TGL_BL_AWB')=='')?NULL:strtoupper(validate(date_input($this->input->post('TGL_BL_AWB')))),
				  'NO_MASTER_BL_AWB'    => ($this->input->post('NO_MASTER_BL_AWB')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_MASTER_BL_AWB')))),
				  'TGL_MASTER_BL_AWB'   => ($this->input->post('TGL_MASTER_BL_AWB')=='')?NULL:strtoupper(validate(date_input($this->input->post('TGL_MASTER_BL_AWB')))),
				  'KD_STATUS'    => '100',
				  'TGL_STATUS'    => date('Y-m-d H:i:s'),
				  'ID_LOG'    => 'MANUAL'
				);
				//print_r($_POST);print_r($ubah);die();
				$check = $this->db->query("select A.ID from t_permit_hdr A WHERE A.CAR='".$DATA['CAR']."'");
				$resulte = $check->num_rows();
				if($resulte > 0){
					$error += 1;
					$message .= "Dokumen sudah ada.";
				}else{
					$run = $this->db->insert('t_permit_hdr',$ubah);
					$id_permit = $this->db->insert_id();
					if($this->input->post('NO_CONT')[0]!=''){
						for($x=0;$x<$TOTAL_CONT;$x++){
							$this->db->set('ID', $id_permit); 
							$this->db->set('NO_CONT', strtoupper($NO_CONT[$x])); 
							$this->db->set('KD_CONT_UKURAN', $UKURAN_CONT[$x]); 
							$this->db->set('KD_CONT_JENIS', $JENIS_CONT[$x]); 
							$run2 = $this->db->insert('t_permit_cont'); 
						}
					}else{
						$run2 = true;
					}
					if($this->input->post('KD_KMS')[0]!=''){
						for($x=0;$x<$TOTAL_KMS;$x++){
							$check = $this->db->query("SELECT * FROM reff_kemasan WHERE ID ='".$KD_KMS[$x]."'");
							$result = $check->num_rows();
							if($result <= 0){
							  $insert = $this->db->query("INSERT INTO reff_kemasan (ID,NAMA) VALUES ('".strtoupper($KD_KMS[$x])."','".strtoupper($JNS_KMS[$x])."')");
							}
							$this->db->set('ID', $id_permit); 
							$this->db->set('JNS_KMS', strtoupper($KD_KMS[$x])); 
							$this->db->set('MERK_KMS', strtoupper($MERK_KMS[$x])); 
							$this->db->set('JML_KMS', $JML_KMS[$x]); 
							$run3 = $this->db->insert('t_permit_kms'); 
						}
					}else{
						$run3 = true;
					}
					if (!$run OR !$run2 OR !$run3) {
						$error += 1;
						$message .= "Could not be processed data";
					}
				}
			}
			if($error == 0){
				$func->main->get_log("add","t_permit_hdr");
				echo "MSG#OK#Successfully to be processed#". site_url() . "/dokumen/entry_impor";
			}else{
				echo "MSG#ERR#".$message."#";
			}
		} 
		else if ($type == "update") { 
			$id = $this->input->post('ID_DATA');      
			if($act=="impor"){
				if($this->input->post('KD_KMS')[0]=='' && $this->input->post('NO_CONT')[0]==''){
					$error += 1;
					$message .= "Could not be processed data";
				}else{
					$NO_CONT = $this->input->post('NO_CONT');
					$UKURAN_CONT = $this->input->post('UKURAN_CONT');
					$JENIS_CONT = $this->input->post('JENIS_CONT');
					$KD_KMS = $this->input->post('KD_KMS');
					$JNS_KMS = $this->input->post('JNS_KMS');
					$JML_KMS = $this->input->post('JML_KMS');
					$MERK_KMS = $this->input->post('MERK_KMS');
					$TOTAL_CONT = count($NO_CONT);
					$TOTAL_KMS = count($KD_KMS);
					if($this->input->post('KD_DOK_INOUT')!="13"){
						$npwp1=str_replace("-","",strtoupper(trim(validate($this->input->post('ID_CONSIGNEE')))));$npwp=str_replace(".","",$npwp1);
					}else{
						$npwp=strtoupper(trim(validate($this->input->post('ID_CONSIGNEE'))));
					}
					$npwppj1=str_replace("-","",strtoupper(trim(validate($this->input->post('NPWP_PPJK')))));$npwppj=str_replace(".","",$npwppj1);
					$ubah= array(
					  'CAR'  				=> strtoupper(validate($this->input->post('CAR'))),
					  'KD_KANTOR' 			=> strtoupper(validate($this->input->post('KD_KANTOR'))),
					  'KD_KANTOR_PENGAWAS' 	=> strtoupper(validate($this->input->post('KD_KANTOR_PENGAWAS'))),
					  'KD_KANTOR_BONGKAR' 	=> strtoupper(validate($this->input->post('KD_KANTOR_BONGKAR'))),
					  'KD_DOK_INOUT'  		=> strtoupper(validate($this->input->post('KD_DOK_INOUT'))),
					  'NO_DOK_INOUT'		=> strtoupper(trim(validate($this->input->post('NO_DOK_INOUT')))),
					  'TGL_DOK_INOUT'  		=> strtoupper(validate(date_input($this->input->post('TGL_DOK_INOUT')))),
					  'NO_DAFTAR_PABEAN'	=> strtoupper(trim(validate($this->input->post('NO_DAFTAR_PABEAN')))),
					  'TGL_DAFTAR_PABEAN'	=> strtoupper(validate(date_input($this->input->post('TGL_DAFTAR_PABEAN')))),
					  'ID_CONSIGNEE'       	=> $npwp,
					  'CONSIGNEE'     		=> strtoupper(trim(validate($this->input->post('CONSIGNEE')))),
					  'ALAMAT_CONSIGNEE'    => strtoupper(trim(validate($this->input->post('ALAMAT_CONSIGNEE')))),
					  'NPWP_PPJK'   		=> ($this->input->post('NPWP_PPJK')=='')?NULL:$npwppj,
					  'NAMA_PPJK'        	=> ($this->input->post('NAMA_PPJK')=='')?NULL:strtoupper(trim(validate($this->input->post('NAMA_PPJK')))),
					  'ALAMAT_PPJK'         => ($this->input->post('ALAMAT_PPJK')=='')?NULL:strtoupper(trim(validate($this->input->post('ALAMAT_PPJK')))),
					  'NM_ANGKUT'        	=> ($this->input->post('NM_ANGKUT')=='')?NULL:strtoupper(trim(validate($this->input->post('NM_ANGKUT')))),
					  'NO_VOY_FLIGHT'       => ($this->input->post('NO_VOY_FLIGHT')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_VOY_FLIGHT')))),
					  'KD_GUDANG'			=> ($this->input->post('KD_GUDANG')=='')?NULL:strtoupper(validate($this->input->post('KD_GUDANG'))),
					  'JML_CONT'  			=> $TOTAL_CONT,
					  'BRUTO'				=> ($this->input->post('BRUTO')=='')?NULL:strtoupper(trim(validate($this->input->post('BRUTO')))),
					  'NETTO'        		=> ($this->input->post('NETTO')=='')?NULL:strtoupper(trim(validate($this->input->post('NETTO')))),
					  'NO_BC11'       		=> ($this->input->post('NO_BC11')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_BC11')))),
					  'TGL_BC11'      		=> ($this->input->post('TGL_BC11')=='')?NULL:strtoupper(validate(date_input($this->input->post('TGL_BC11')))),
					  'NO_POS_BC11'       	=> ($this->input->post('NO_POS_BC11')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_POS_BC11')))),
					  'NO_BL_AWB'   		=> ($this->input->post('NO_BL_AWB')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_BL_AWB')))),
					  'TGL_BL_AWB'        	=> ($this->input->post('TGL_BL_AWB')=='')?NULL:strtoupper(validate(date_input($this->input->post('TGL_BL_AWB')))),
					  'NO_MASTER_BL_AWB'    => ($this->input->post('NO_MASTER_BL_AWB')=='')?NULL:strtoupper(trim(validate($this->input->post('NO_MASTER_BL_AWB')))),
					  'TGL_MASTER_BL_AWB'   => ($this->input->post('TGL_MASTER_BL_AWB')=='')?NULL:strtoupper(validate(date_input($this->input->post('TGL_MASTER_BL_AWB')))),
					  'KD_STATUS'    => '100',
					  'TGL_STATUS'    => date('Y-m-d H:i:s'),
					  'ID_LOG'    => 'MANUAL'
					);
					#print_r($_POST);print_r($ubah);die();
					$check = $this->db->query("select A.ID from t_permit_hdr A WHERE A.CAR='".$DATA['CAR']."' and A.ID_LOG <> 'MANUAL'");
					$resulte = $check->num_rows();
					if($resulte > 0){
						$error += 1;
						$message .= "Dokumen sudah ada.";
					}else{
						$this->db->where(array('ID' => $id));
						$run = $this->db->update('t_permit_hdr', $ubah);
					}
					if($this->input->post('NO_CONT')[0]!=''){
						$HAPUS = $this->db->delete('t_permit_cont', array('ID' => $id));
						if ($HAPUS == false) {
							$error += 1;
							$message .= "Could not be processed data";
						} else {
							for($x=0;$x<$TOTAL_CONT;$x++){
								$this->db->set('ID', $id); 
								$this->db->set('NO_CONT', strtoupper($NO_CONT[$x])); 
								$this->db->set('KD_CONT_UKURAN', $UKURAN_CONT[$x]); 
								$this->db->set('KD_CONT_JENIS', $JENIS_CONT[$x]); 
								$run2 = $this->db->insert('t_permit_cont'); 
							}
						}
					}else{
						$run2 = true;
					}
					if($this->input->post('KD_KMS')[0]!=''){
						$HAPUS = $this->db->delete('t_permit_kms', array('ID' => $id));
						if ($HAPUS == false) {
							$error += 1;
							$message .= "Could not be processed data";
						} else {
							for($x=0;$x<$TOTAL_KMS;$x++){
								$check = $this->db->query("SELECT * FROM reff_kemasan WHERE ID ='".$KD_KMS[$x]."'");
								$result = $check->num_rows();
								if($result <= 0){
								  $insert = $this->db->query("INSERT INTO reff_kemasan (ID,NAMA) VALUES ('".strtoupper($KD_KMS[$x])."','".strtoupper($JNS_KMS[$x])."')");
								}
								$this->db->set('ID', $id); 
								$this->db->set('JNS_KMS', strtoupper($KD_KMS[$x])); 
								$this->db->set('MERK_KMS', strtoupper($MERK_KMS[$x])); 
								$this->db->set('JML_KMS', $JML_KMS[$x]); 
								$run3 = $this->db->insert('t_permit_kms'); 
							}							
						}
					}else{
						$run3 = true;
					}
					if (!$run OR !$run2 OR !$run3) {
						$error += 1;
						$message .= "Could not be processed data";
					}
				}
				if($error == 0){
					$func->main->get_log("update","t_permit_hdr");
					echo "MSG#OK#Successfully to be processed#". site_url() . "/dokumen/entry_impor";
				}else{
					echo "MSG#ERR#".$message."#";
				}				
			}elseif($act=="blgudang"){
				$ubah= array(
				  'NO_VOY_FLIGHT'	=> strtoupper(validate($this->input->post('NO_VOY_FLIGHT'))),
				  'KD_GUDANG'	=> strtoupper(validate($this->input->post('KD_GUDANG'))),
				  'NO_BL_AWB'   => strtoupper(trim(validate($this->input->post('NO_BL_AWB')))),
				  'TGL_BL_AWB'  => strtoupper(validate(date_input($this->input->post('TGL_BL_AWB'))))
				);
				//print_r($ubah);die();
				$this->db->where(array('ID' => $id,'CAR' => $this->input->post('CAR')));
				$run = $this->db->update('t_permit_hdr', $ubah);
				if (!$run) {
					$error += 1;
					$message .= "Could not be processed data";
				}
				if($error == 0){
					$func->main->get_log("update","t_permit_hdr");
					echo "MSG#OK#Successfully to be processed#". site_url() . "/dokumen/impor";
				}else{
					echo "MSG#ERR#".$message."#";
				}				
			}
		} else if ($type == "delete") {
			foreach ($this->input->post('tb_chktblimpor') as $chkitem) {
			$arrchk = explode("~", $chkitem);
			$ID = $arrchk[0];
			$result2 = $this->db->delete('t_permit_cont', array('ID' => $ID));
			$result3 = $this->db->delete('t_permit_kms', array('ID' => $ID));
			$result = $this->db->delete('t_permit_hdr', array('ID' => $ID));
			  if ($result == false OR $result2 == false OR $result2 == false) {
				$error += 1;
				$message .= "Could not be processed data";
			  }
			}
			if ($error == 0) {
			  $func->main->get_log("delete", "t_permit_hdr");
			  echo "MSG#OK#Successfully to be processed#". site_url() . "/dokumen/entry_impor/post";
			} else {
			  echo "MSG#ERR#" . $message . "#";
			}
		}
		 else if ($type == "get") {
		  if ($act == "t_permit_hdr") {
			$SQL = "SELECT *,func_name(IFNULL(A.KD_GUDANG,'-'),'GUDANG') as NM_GUDANG, 
			func_name(IFNULL(A.KD_KANTOR,'-'),'KPBC') as NM_KPBC, func_name(IFNULL(A.KD_KANTOR_PENGAWAS,'-'),'KPBC') as NM_KP_PENG,
			func_name(IFNULL(A.KD_KANTOR_BONGKAR,'-'),'KPBC') as NM_KP_BONG, func_name(IFNULL(A.KD_DOK_INOUT,'-'),'DOK_BC') as KD_DOK
			FROM t_permit_hdr A 
				WHERE A.ID = " . $this->db->escape($id);
			  $result = $func->main->get_result($SQL);
			  if ($result) { 
				foreach ($SQL->result_array() as $row => $value) {
				  $arrdata = $value;
				}
				return $arrdata;
			  } else {
				redirect(site_url(), 'refresh');
			  }
		  } else if ($act == "t_permit_cont") {
			$SQL = "SELECT *
				FROM t_permit_cont A
				WHERE A.ID = " . $this->db->escape($id);
			$query = $this->db->query($SQL);
			if ($query->num_rows() > 0){
				return $query->result();
			}
		  } else if ($act == "t_permit_kms") {
			$SQL = "SELECT *,func_name(IFNULL(JNS_KMS,'-'),'KEMASAN') as NM_KMS
				FROM t_permit_kms
				WHERE ID = " . $this->db->escape($id);
			$query = $this->db->query($SQL);
			if ($query->num_rows() > 0){
				return $query->result();
			}
		  } else if ($act == "reff_cont_ukuran") {
			  $SQL = "SELECT ID,NAMA FROM reff_cont_ukuran";
			  $query = $this->db->query($SQL);
			   $result = $func->main->get_result($SQL);
			  if ($result) { 
			   return $query->result();
			  } 
			  else {
				redirect(site_url(), 'refresh');
			  }
		  } elseif ($act == "reff_cont_jenis") {
			  $SQL = "SELECT ID,NAMA FROM reff_cont_jenis";
			  $query = $this->db->query($SQL);
			   $result = $func->main->get_result($SQL);
			  if ($result) { 
			   return $query->result();
			  } 
			  else {
				redirect(site_url(), 'refresh');
			  }
		  }
		}else if($type == "send_ubah_stat"){
		  $sendData = true;        
			if($sendData){
			  foreach($this->input->post('tb_chktblubahstatus') as $chkitem){            
				$arrchk = explode("~", $chkitem);
				$id_stat = $arrchk[0];
				$this->db->where(array('ID'=>$id_stat));
				$this->db->update('t_permohonan_cfs',array('KD_STATUS'=>'200','TGL_PERMOHONAN_CFS'=>date('Y-m-d H:i:s')));
			  } 
			}else{
			  $error += 1;
			  $message = "Data gagal diproses";
			}
			if($error == 0){
			  $func->main->get_log("kirim", "t_permohonan_cfs");
			  echo "MSG#OK#Data berhasil diproses#".site_url()."/status/listdata";
			}else{
			  echo "MSG#ERR#".$message."#";
			}
		}
	} 
}
/* 	
	public function ekspor_request_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REQUEST";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT B.NAMA AS 'JENIS DOKUMEN', A.NO_DOK_INOUT AS 'NO. DOKUMEN', DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y') AS 'TGL. DOKUMEN',
				A.NPWP_CONSIGNEE AS 'NPWP CONSIGNEE', C.NAMA AS STATUS, A.TGL_STATUS AS 'WAKTU REKAM', A.KD_STATUS,
				'dokumen/EKSPOR_REQUEST_KONTAINER' AS POST, A.ID
				FROM t_request_custimp_hdr A
				INNER JOIN reff_kode_dok_bc B ON B.ID=A.KD_DOK_INOUT
				LEFT JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='REQCUSTIMP'
				WHERE B.KD_PERMIT = 'EXP'".$addsql;
		$proses = array('REQUEST' => array('ADD_MODAL',"dokumen/ekspor_request_kontainer/add", '','','md-plus-circle'),
						'UPDATE'  => array('POPUP',"dokumen/ekspor_request_kontainer/update", '1','100','icon-pencil'),
						'DELETE'  => array('DELETE',"process/delete/request_dokumen", '1','100','md-close-circle'),
						'PROCESS' => array('POST',"execute/process/update/send_request_dokumen", '1','100','md-mail-send'));
		$this->newtable_edit->multiple_search(true);
		$this->newtable_edit->show_chk($check);
		$this->newtable_edit->show_menu($check);
		$this->newtable_edit->show_search(true);
		$arr_dok = $this->get_combobox('dok_bc','EXP');
		$this->newtable_edit->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NOMOR DOKUMEN'),array('A.TGL_DOK_INOUT','TANGGAL DOKUMEN','DATERANGE')));
		$this->newtable_edit->action(site_url() . "/dokumen/ekspor_request_kontainer");
		#if($check) $this->newtable_edit->detail(array('POPUP',"dokumen/impor_kontainer/detail"));
		$this->newtable_edit->detail(array('POPUP',"dokumen/impor_kontainer/detail"));
		$this->newtable_edit->tipe_proses('button');
		$this->newtable_edit->hiddens(array("ID","KD_STATUS","POST"));
		$this->newtable_edit->keys(array("ID","POST"));
		$this->newtable_edit->validasi(array("KD_STATUS"));
		$this->newtable_edit->cidb($this->db);
		$this->newtable_edit->orderby(6);
		$this->newtable_edit->sortby("DESC");
		$this->newtable_edit->set_formid("tblrequestdokumen");
		$this->newtable_edit->set_divid("divtblrequestdokumen");
		$this->newtable_edit->rowcount(10);
		$this->newtable_edit->clear();
		$this->newtable_edit->menu($proses);
		$tabel .= $this->newtable_edit->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function impor_request_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REQUEST";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT B.NAMA AS 'JENIS DOKUMEN', A.NO_DOK_INOUT AS 'NO. DOKUMEN', DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y') AS 'TGL. DOKUMEN',
				A.NPWP_CONSIGNEE AS 'NPWP CONSIGNEE', C.NAMA AS STATUS, A.TGL_STATUS AS 'WAKTU REKAM', A.KD_STATUS,
				'dokumen/IMPOR_REQUEST_KONTAINER' AS POST, A.ID
				FROM t_request_custimp_hdr A
				INNER JOIN reff_kode_dok_bc B ON B.ID=A.KD_DOK_INOUT
				LEFT JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='REQCUSTIMP'
				WHERE B.KD_PERMIT = 'IMP'".$addsql;
		$proses = array('ENTRY' => array('ADD_MODAL',"dokumen/impor_request_kontainer/add", '0','','md-plus-circle'),
						'DETAIL'  => array('POPUP',"dokumen/impor_request_kontainer/detail", '1','','icon-pencil'));
						#'DELETE'  => array('DELETE',"execute/process/delete/request_dokumen", '1','100','md-close-circle'),
						#'PROCESS' => array('POST',"execute/process/update/send_request_dokumen", '1','100','md-mail-send'));
		$this->newtable_edit->multiple_search(true);
		$this->newtable_edit->show_chk($check);
		$this->newtable_edit->show_menu($check);
		$this->newtable_edit->show_search(true);
		$arr_dok = $this->get_combobox('dok_bc','IMP');
		$this->newtable_edit->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NOMOR DOKUMEN'),array('A.TGL_DOK_INOUT','TANGGAL DOKUMEN','DATERANGE')));
		$this->newtable_edit->action(site_url() . "/dokumen/impor_request_kontainer");
		#if($check) $this->newtable_edit->detail(array('POPUP',"dokumen/impor_request_kontainer/detail"));
		$this->newtable_edit->detail(array('POPUP',"dokumen/impor_request_kontainer/detail"));
		$this->newtable_edit->tipe_proses('button');
		$this->newtable_edit->hiddens(array("ID","KD_STATUS","POST"));
		$this->newtable_edit->keys(array("ID","POST"));
		$this->newtable_edit->validasi(array("KD_STATUS"));
		$this->newtable_edit->cidb($this->db);
		$this->newtable_edit->orderby(6);
		$this->newtable_edit->sortby("DESC");
		$this->newtable_edit->set_formid("tblrequestdokumen");
		$this->newtable_edit->set_divid("divtblrequestdokumen");
		$this->newtable_edit->rowcount(10);
		$this->newtable_edit->clear();
		$this->newtable_edit->menu($proses);
		$tabel .= $this->newtable_edit->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}
 */
?>
