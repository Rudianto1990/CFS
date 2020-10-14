<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_plp extends Model{
	
    function M_plp() {
       parent::Model();
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
        }else if($find == "TPS2"){
          $sql = "SELECT KD_TPS,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '1' and KD_GUDANG <> 'CART' ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_TPS", "NAMA_GUDANG", TRUE);
        }
        
    return $arrdata;
  }
	
	public function pengajuan_plp($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "PENGAJUAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA" && ($TIPE_ORGANISASI != "SPA" && $TIPE_ORGANISASI != "ADMCFS")){
			$addsql .= " AND A.KD_TPS_ASAL = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG_ASAL = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT
				CONCAT('REF. : ',IFNULL(A.REF_NUMBER,'-'),'<BR>NO. : ',IFNULL(A.NO_SURAT,'-'),'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_SURAT,'%d-%m-%Y'),'-')) AS 'SURAT PLP',
				A.NM_ANGKUT AS 'NAMA ANGKUT', A.NO_VOY_FLIGHT AS 'NO VOYAGE', DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA',
				CONCAT('NO. : ',A.NO_BC11,'<BR>TGL. : ',DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y')) AS BC11,
				CONCAT('YOR ASAL : ',IFNULL(A.YOR_ASAL,'-'),'<BR> YOR TUJUAN : ',IFNULL(A.YOR_TUJUAN,'-')) AS 'YOR', 
				CONCAT('TPS : ',func_name(A.KD_TPS_TUJUAN,'TPS'),'<BR>GUDANG : ',func_name(A.KD_GUDANG_TUJUAN,'GUDANG')) AS 'GUDANG TUJUAN', 
				CONCAT(C.NAMA,'<BR>',DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s')) AS STATUS, A.TGL_STATUS, 
				A.ID, A.KD_COCOSTSHDR, A.KD_STATUS
				FROM t_request_plp_hdr A JOIN t_request_plp_cont D ON A.ID=D.ID
				LEFT JOIN reff_kapal B ON B.ID=A.KD_KAPAL
				LEFT JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='PLPAJU'
				WHERE 1=1 and A.KD_GUDANG_TUJUAN IN ('RAYA','BAND')".$addsql;// AND A.KD_ALASAN_PLP='2'
		
		$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
	
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		//$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS");
    	if($KD_GROUP=="SPA" || $TIPE_ORGANISASI == "ADMCFS"){
			$this->newtable->search(array(array('A.NO_SURAT','NO. SURAT'),array('A.REF_NUMBER','REF NUMBER'),array('A.NM_ANGKUT','NAMA ANGKUT'),array('A.TGL_TIBA','TGL. TIBA','DATERANGE'),array('D.NO_CONT','NO. KONTAINER'),array('A.KD_GUDANG_TUJUAN','KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_GUDANG_ASAL','KD TERMINAL', 'OPTION', $arrnamaTPS)));
		}else{
			$this->newtable->search(array(array('A.NO_SURAT','NO. SURAT'),array('A.REF_NUMBER','REF NUMBER'),array('A.NM_ANGKUT','NAMA ANGKUT'),array('A.TGL_TIBA','TGL. TIBA','DATERANGE'),array('D.NO_CONT','NO. KONTAINER')));
		}
		$this->newtable->action(site_url() . "/plp/pengajuan_plp");
		//if($check) $this->newtable->detail(array('POPUP',"plp/pengajuan_plp/detail"));
		$this->newtable->detail(array('POPUP',"plp/pengajuan_plp/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("KD_COCOSTSHDR","ID","KD_STATUS","TGL_STATUS"));
		$this->newtable->keys(array("KD_COCOSTSHDR","ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(10);
		$this->newtable->groupby(array('A.ID'));
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblrequestdokumen");
		$this->newtable->set_divid("divtblrequestdokumen");
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
	
	public function pengajuan_plp_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		$arrid = explode("~",$id);
		/*$SQL = "SELECT A.NO_CONT AS 'NO. KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN
				FROM t_request_plp_cont A
				WHERE A.ID = ".$this->db->escape($arrid[1]);*/
		$SQL = "SELECT CONCAT('NO. KONTAINER : ',IFNULL(A.NO_CONT,'-'),'<BR>UKURAN : ', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN')) AS REQUEST,
				CONCAT('REF. : ',IFNULL(B.REF_NUMBER,'-'),'<BR>NO. : ',C.NO_PLP,'<BR>TGL. : ',DATE_FORMAT(C.TGL_PLP,'%d-%m-%Y')) AS 'PLP',
				CONCAT('NO. KONTAINER : ',IFNULL(C.NO_CONT,'-'),'<BR>UKURAN : ',func_name(IFNULL(C.KD_CONT_UKURAN,'-'),'CONT_UKURAN'),
				'<BR>ALSAN REJECT : ',C.ALASAN_REJECT) AS RESPONSE,
				D.NAMA AS 'STATUS', C.ID, C.NO_CONT
				FROM t_request_plp_cont A 
				INNER JOIN t_request_plp_hdr B ON B.ID=A.ID
				LEFT JOIN (
				SELECT X.ID, X.NO_PLP, X.TGL_PLP, X.ALASAN_REJECT, X.REF_NUMBER, Y.NO_CONT, Y.KD_CONT_UKURAN, Y.KD_STATUS 
					FROM t_respon_plp_asal_hdr X 
				INNER JOIN t_respon_plp_asal_cont Y ON Y.ID=X.ID
				) C ON C.REF_NUMBER=B.REF_NUMBER AND A.NO_CONT=C.NO_CONT
				LEFT JOIN reff_status D ON D.ID=C.KD_STATUS AND D.KD_TIPE_STATUS='PLPRESDTL'
				WHERE A.ID = ".$this->db->escape($id);

		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','KONTAINER')));
		$this->newtable->action(site_url() . "/plp/pengajuan_plp_kontainer/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NO_CONT"));
		$this->newtable->keys(array("ID","NO_CONT"));
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

	//pembatalan
	public function pembatalan_plp($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "PENGAJUAN PEMBATALAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA" && ($TIPE_ORGANISASI != "SPA" && $TIPE_ORGANISASI != "ADMCFS")){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT('NO. : ',IFNULL(A.NO_SURAT,'-'),'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_SURAT,'%d-%m-%Y'),'-')) AS 'SURAT PLP',
				CONCAT('NO. : ',IFNULL(B.NO_PLP,'-'),'<BR>TGL. : ',IFNULL(DATE_FORMAT(B.TGL_PLP,'%d-%m-%Y'),'-')) AS 'RESPON PLP',
				A.NM_PEMOHON AS 'NAMA PEMOHON', A.ALASAN,
				CONCAT(C.NAMA,'<BR>',DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s')) AS STATUS, 
				A.TGL_STATUS, A.KD_STATUS, A.KD_RESPON_PLP_ASAL, A.ID
				FROM t_request_batal_plp_hdr A
				LEFT JOIN t_respon_plp_asal_hdr B ON B.REF_NUMBER=A.REF_NUMBER
				LEFT JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='BTLPLP'
				WHERE 1=1".$addsql;
		$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
	
		$this->newtable->multiple_search(true);
		#$this->newtable->show_chk(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS2");
    	if($KD_GROUP=="SPA" || $TIPE_ORGANISASI == "ADMCFS"){
    		$this->newtable->search(array(array('A.NO_SURAT','NO. SURAT'),array('A.TGL_SURAT','TGL. SURAT','DATERANGE'),array('A.KD_TPS','KD TERMINAL', 'OPTION', $arrnamaTPS)));
    	}else{
    		$this->newtable->search(array(array('A.NO_SURAT','NO. SURAT'),array('A.TGL_SURAT','TGL. SURAT','DATERANGE')));
    	}
		$this->newtable->action(site_url() . "/plp/pembatalan_plp");
		//if($check) $this->newtable->detail(array('POPUP',"plp/pembatalan_plp/detail"));
		$this->newtable->detail(array('POPUP',"plp/pembatalan_plp/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("KD_RESPON_PLP_ASAL","ID","KD_STATUS","TGL_STATUS"));
		$this->newtable->keys(array("KD_RESPON_PLP_ASAL","ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblpembatalan");
		$this->newtable->set_divid("divtblpembatalan");
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
	
	public function pembatalan_plp_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		$arrid = explode("~",$id);
		$SQL = "SELECT B.REF_NUMBER AS 'REF NUMBER',
				CONCAT('NO. KONTAINER : ',IFNULL(A.NO_CONT,'-'),'<BR>UKURAN : ', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN')) 
				AS 'REQUEST BATAL',
				CONCAT('NO. : ',C.NO_PLP,'<BR>TGL. : ',DATE_FORMAT(C.TGL_PLP,'%d-%m-%Y')) AS 'BATAL PLP',
				CONCAT('NO. KONTAINER : ',IFNULL(C.NO_CONT,'-'),'<BR>UKURAN : ',func_name(IFNULL(C.KD_CONT_UKURAN,'-'),'CONT_UKURAN')) 
				AS 'RESPONSE BATAL', D.NAMA AS 'STATUS'
				FROM t_request_batal_plp_cont A 
				INNER JOIN t_request_batal_plp_hdr B ON B.ID=A.ID
				LEFT JOIN (
				SELECT X.NO_BATAL_PLP AS NO_PLP, X.TGL_BATAL_PLP AS TGL_PLP, X.REF_NUMBER, Y.NO_CONT, Y.KD_CONT_UKURAN, Y.KD_STATUS 
					FROM t_respon_batal_plp_asal_hdr X 
				INNER JOIN t_respon_batal_plp_asal_cont Y ON Y.ID=X.ID
				) C ON C.REF_NUMBER=B.REF_NUMBER AND A.NO_CONT=C.NO_CONT
				LEFT JOIN reff_status D ON D.ID=C.KD_STATUS AND D.KD_TIPE_STATUS='PLPRESDTL'
				WHERE A.ID = ".$this->db->escape($arrid[1]);
		$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
	
		$this->newtable->multiple_search(false);
		//$this->newtable->show_chk(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','KONTAINER')));
		$this->newtable->action(site_url() . "/plp/pembatalan_plp_kontainer/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array(""));
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

	function res_plp_asal($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Respon PLP Asal', site_url('plp/res_plp_asal'));
		$judul = "DATA RESPON PLP ASAL";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA" && ($TIPE_ORGANISASI != "SPA" && $TIPE_ORGANISASI != "ADMCFS")){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT(func_name(A.KD_TPS,'TPS'),' [',A.KD_TPS,']') AS TPS, A.NO_PLP AS 'NO. PLP',
				DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') AS 'TGL. PLP', A.ALASAN_REJECT AS ALASAN, B.NAMA AS STATUS, 
				DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s') AS 'TGL. STATUS', A.ID
				FROM t_respon_plp_asal_hdr A
				-- LEFT JOIN t_request_plp_hdr C ON A.REF_NUMBER=C.REF_NUMBER
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPRES'
				WHERE 1=1 -- and C.KD_GUDANG_TUJUAN IN ('RAYA','BAND','PSKA') AND C.KD_ALASAN_PLP='2'
				".$addsql;
		$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS2");
    	if($KD_GROUP=="SPA" || $TIPE_ORGANISASI == "ADMCFS"){
    		$this->newtable->search(array(array('A.NO_PLP','NO. PLP'),array('A.TGL_PLP','TGL. PLP','DATERANGE'),array('A.KD_TPS', 'KD TERMINAL', 'OPTION', $arrnamaTPS)));
    	}else{
    		$this->newtable->search(array(array('A.NO_PLP','NO. PLP'),array('A.TGL_PLP','TGL. PLP','DATERANGE')));
    	}
		
		$this->newtable->action(site_url()."/plp/res_plp_asal");
		$this->newtable->detail(array('POPUP',"plp/res_plp_asal/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;	
	}

	function v_res_plp_asal_kms($act,$id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', 
				A.ID, A.KD_KEMASAN, A.NO_BL_AWB, A.TGL_BL_AWB, A.JML_KMS
				FROM t_respon_plp_asal_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/v_res_plp_asal_kms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->keys(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}

	function v_res_plp_asal_cont($act,$id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KONTAINER";
		$SQL = "SELECT A.NO_CONT as 'NO KONTAINER',func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN, B.NAMA AS 'STATUS', A.NO_CONT, A.ID
				FROM t_respon_plp_asal_cont A JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPRESDTL'
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT', 'NO KONTAINER')));
		$this->newtable->action(site_url() . "/plp/v_res_plp_asal_cont/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NO_CONT"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}

	function res_batal_plp_asal($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Respon Batal PLP Asal', site_url('plp/res_plp_asal'));
		$judul = "DATA RESPON BATAL PLP ASAL";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA" && ($TIPE_ORGANISASI != "SPA" && $TIPE_ORGANISASI != "ADMCFS")){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT(func_name(A.KD_TPS,'TPS'),' [',A.KD_TPS,']') AS TPS, 
				CONCAT('NO. ',A.NO_BATAL_PLP,'<BR>TGL. ',DATE_FORMAT(A.TGL_BATAL_PLP,'%d-%m-%Y')) AS PLP,
				B.NAMA AS STATUS, DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s') AS 'TGL. STATUS', A.ID
				FROM t_respon_batal_plp_asal_hdr A 
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='BTLRES'
				WHERE 1=1".$addsql;
		$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS2");
    	if($KD_GROUP=="SPA" || $TIPE_ORGANISASI == "ADMCFS"){
    		$this->newtable->search(array(array('A.NO_BATAL_PLP','NO. PLP'),array('A.TGL_BATAL_PLP','TGL. PLP','DATERANGE'),array('A.KD_TPS', 'KD TERMINAL', 'OPTION', $arrnamaTPS)));
    	}else{
    		$this->newtable->search(array(array('A.NO_BATAL_PLP','NO. PLP'),array('A.TGL_BATAL_PLP','TGL. PLP','DATERANGE')));
    	}
		
		$this->newtable->action(site_url() . "/plp/res_batal_plp_asal");
		$this->newtable->detail(array('POPUP',"plp/res_batal_plp_asal/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(4);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function res_plp_tujuan($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Respon PLP Tujuan', site_url('plp/res_plp_asal'));
		$judul = "DATA RESPON PLP TUJUAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA" && ($TIPE_ORGANISASI != "SPA" && $TIPE_ORGANISASI != "ADMCFS")){
			$addsql .= " AND A.KD_TPS_TUJUAN = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT(func_name(A.KD_TPS_ASAL,'TPS'),' [',A.KD_TPS_ASAL,']') AS 'TPS ASAL', 
				CASE WHEN A.KD_GUDANG_TUJUAN IS NULL THEN
				CONCAT('TPS : ',func_name(A.KD_TPS_TUJUAN,'TPS'),' [',A.KD_TPS_TUJUAN,']')
				ELSE
				CONCAT('TPS : ',func_name(A.KD_TPS_TUJUAN,'TPS'),' [',A.KD_TPS_TUJUAN,']
				<BR>GUDANG : ',func_name(A.KD_GUDANG_TUJUAN,'GUDANG'),' [',A.KD_GUDANG_TUJUAN,']') END AS 'TPS/GUDANG TUJUAN', 
				CONCAT('NO. ',A.NO_PLP,'<BR>TGL. ',DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y')) AS PLP, 
				CONCAT('NAMA ANGKUT : ',A.NM_ANGKUT,'<BR>NO. VOYAGE : ',A.NO_VOY_FLIGHT,'<BR>CALL SIGN : ',A.CALL_SIGN,'
				<BR>TGL. TIBA : ',DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y')) AS 'DATA ANGKUT',
				B.NAMA AS STATUS, DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s') AS 'TGL. STATUS', A.ID
				FROM t_respon_plp_tujuan_v2_hdr A 
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPTUJ'
				WHERE 1=1".$addsql;
		$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS2");
    	if($KD_GROUP=="SPA" || $TIPE_ORGANISASI == "ADMCFS"){
    		$this->newtable->search(array(array('A.NO_PLP','NO. PLP'),array('A.TGL_PLP','TGL. PLP','DATERANGE'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_TPS_ASAL', 'KD TERMINAL', 'OPTION', $arrnamaTPS)));
    	}else{
    		$this->newtable->search(array(array('A.NO_PLP','NO. PLP'),array('A.TGL_PLP','TGL. PLP','DATERANGE')));
    	}
		
		$this->newtable->action(site_url() . "/plp/res_plp_tujuan");
		$this->newtable->detail(array('POPUP',"plp/res_plp_tujuan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;	
	}

	function v_res_plp_tujuan_kms($act,$id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', 
				A.ID, A.KD_KEMASAN, A.NO_BL_AWB, A.TGL_BL_AWB, A.JML_KMS
				FROM t_respon_plp_tujuan_v2_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
				$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
		$this->newtable->show_chk(true);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/v_res_plp_tujuan_kms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->keys(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}

	function v_res_plp_tujuan_cont($act,$id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KONTAINER";
		$SQL = "SELECT A.NO_CONT as 'NO KONTAINER',func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN, A.NO_POS_BC11 AS 'NO POS BC 1.1', A.NO_CONT, A.ID
				FROM t_respon_plp_tujuan_v2_cont A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(true);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT', 'NO KONTAINER')));
		$this->newtable->action(site_url() . "/plp/v_res_plp_tujuan_cont/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NO_CONT"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}

	function res_batal_plp_tujuan($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Respon Batal PLP Tujuan', site_url('plp/res_plp_asal'));
		$judul = "DATA RESPON BATAL PLP TUJUAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA" && ($TIPE_ORGANISASI != "SPA" && $TIPE_ORGANISASI != "ADMCFS")){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT(func_name(A.KD_TPS,'TPS'),' [',A.KD_TPS,']') AS 'TPS TUJUAN', 
				CONCAT(func_name(A.KD_TPS_ASAL,'TPS'),' [',A.KD_TPS_ASAL,']') AS 'TPS ASAL', 
				CONCAT('NO. ',A.NO_PLP,'<BR>TGL. ',DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y')) AS PLP,
				CONCAT('NO. ',A.NO_BATAL_PLP,'<BR>TGL. ',DATE_FORMAT(A.TGL_BATAL_PLP,'%d-%m-%Y')) AS 'PLP BATAL',
				B.NAMA AS STATUS, DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s') AS 'TGL. STATUS', A.ID
				FROM t_respon_batal_plp_tujuan_hdr A 
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='BTLTUJ'
				WHERE 1=1".$addsql;
		$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS2");
    	if($KD_GROUP=="SPA" || $TIPE_ORGANISASI == "ADMCFS"){
    		$this->newtable->search(array(array('A.NO_BATAL_PLP','NO. PLP'),array('A.TGL_BATAL_PLP','TGL. PLP','DATERANGE'),array('A.KD_TPS', 'KD TERMINAL', 'OPTION', $arrnamaTPS)));
    	}else{
    		$this->newtable->search(array(array('A.NO_BATAL_PLP','NO. PLP'),array('A.TGL_BATAL_PLP','TGL. PLP','DATERANGE')));
    	}
		
		$this->newtable->action(site_url() . "/plp/res_batal_plp_tujuan");
		$this->newtable->detail(array('POPUP',"plp/res_batal_plp_tujuan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(4);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	function execute($type, $act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_KPBC = $this->newsession->userdata('KD_KPBC');
		if($type=="save"){
			if($act=="pengajuan"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = strtoupper($b);
				}
				$DATA['KD_COCOSTSHDR'] = $id;
				$DATA['KD_TPS_ASAL'] = $KD_TPS;
				$DATA['KD_GUDANG_ASAL'] = $KD_GUDANG;
				$DATA['KD_KPBC'] = $KD_KPBC;
				$DATA['TGL_SURAT'] = date_input($DATA['TGL_SURAT']);
				$DATA['TGL_TIBA'] = date_input($DATA['TGL_TIBA']);
				$DATA['TGL_BC11'] = date_input($DATA['TGL_BC11']);
				$DATA['KD_STATUS'] = '100';
				$DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
				$SQL = "SELECT ID FROM t_request_plp_hdr
						WHERE NO_SURAT = ".$this->db->escape(trim($DATA['NO_SURAT']))."
						AND TGL_SURAT = ".$this->db->escape(trim($DATA['TGL_SURAT']));
				$result = $func->main->get_result($SQL);
				if($result){
					$error += 1;
					$message = "Data gagal diproses, periksa No. Surat dan Tgl. Surat";
				}else{
					$id_kms = $this->input->post('tmpchktblkemasan');
					$arr_kms = explode("*",$id_kms);
					$insertKemasan = true;
					for($a=0; $a<count($arr_kms); $a++){
						$kms = explode("~",$arr_kms[$a]);
						$SQL_KMS = "SELECT KD_KEMASAN, JUMLAH, NO_BL_AWB, TGL_BL_AWB
									FROM t_cocostskms
									WHERE ID = ".$this->db->escape($kms[0])."
									AND SERI = ".$this->db->escape($kms[1]);
						$result_kms = $func->main->get_result($SQL_KMS);
						if($result_kms){
							foreach($SQL_KMS->result_array() as $row => $value){
								$arrkms = $value;
							}
							$PLP_KMS = "SELECT A.ID FROM t_request_plp_kms A
										INNER JOIN t_request_plp_hdr B ON B.ID=A.ID
										WHERE B.KD_STATUS = '100'
										AND B.NO_SURAT = ".$this->db->escape(trim($DATA['NO_SURAT']))."
										AND B.TGL_SURAT = ".$this->db->escape(trim($DATA['TGL_SURAT']))."
										AND B.KD_COCOSTSHDR = ".$this->db->escape($id)."
										AND A.KD_KEMASAN = ".$this->db->escape($arrkms['KD_KEMASAN'])."
										AND A.NO_BL_AWB = ".$this->db->escape($arrkms['NO_BL_AWB'])."
										AND A.TGL_BL_AWB = ".$this->db->escape($arrkms['TGL_BL_AWB']);
							$result_plp = $func->main->get_result($PLP_KMS);
							if($result_plp){
								$insertKemasan = false;
							}
						}
					}
					if($insertKemasan){
						$this->db->insert('t_request_plp_hdr',$DATA);
						$ID_PLP = $this->db->insert_id();
						for($a=0; $a<count($arr_kms); $a++){
							$kms = explode("~",$arr_kms[$a]);
							$SQL_KMS = "SELECT KD_KEMASAN, JUMLAH, NO_BL_AWB, TGL_BL_AWB
										FROM t_cocostskms
										WHERE ID = ".$this->db->escape($kms[0])."
										AND SERI = ".$this->db->escape($kms[1]);
							$result_kms = $func->main->get_result($SQL_KMS);
							if($result_kms){
								foreach($SQL_KMS->result_array() as $row => $value){
									$arrkms = $value;
								}
								$arrkms['ID'] = $ID_PLP;
								$arrkms['JML_KMS'] = $arrkms['JUMLAH'];
								unset($arrkms['JUMLAH']);
								$this->db->insert('t_request_plp_kms',$arrkms);
							}
						}
					}else{
						$error += 1;
						$message = "Data gagal diproses, periksa No. BL/AWB dan Tgl. BL/AWB";
					}
				}
				if($error == 0){
					$func->main->get_log("add","t_request_plp_hdr,t_request_plp_kms");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pengajuan";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="pembatalan"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = strtoupper($b);
				}
				$DATA['KD_RESPON_PLP_ASAL'] = $id;
				$DATA['KD_KPBC'] = $KD_KPBC;
				$DATA['KD_TPS'] = $KD_TPS;
				$DATA['KD_GUDANG'] = $KD_GUDANG;
				$DATA['TGL_SURAT'] = date_input($DATA['TGL_SURAT']);	
				$DATA['KD_STATUS'] = '100';
				$DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
				$SQL = "SELECT A.ID
						FROM t_request_batal_plp_hdr A
						WHERE A.NO_SURAT = ".$this->db->escape(trim($DATA['NO_SURAT']))."
						AND A.TGL_SURAT = ".$this->db->escape(trim($DATA['TGL_SURAT']));
				$result = $func->main->get_result($SQL);
				if($result){
					$error += 1;
					$message .= "Data gagal diproses, periksa No. Surat dan Tgl. Surat";
				}else{
					$id_kms = $this->input->post('tmpchktblkemasanplp');
					$arr_kms = explode("*",$id_kms);
					$insertKemasan = true;
					for($a=0; $a<count($arr_kms)-1; $a++){
						$kms = explode("~",$arr_kms[$a]);
						$PLP_KMS = "SELECT ID
									FROM t_request_batal_plp_kms 
									WHERE KD_KEMASAN = ".$this->db->escape(trim($kms[1]))."
									AND NO_BL_AWB = ".$this->db->escape(trim($kms[2]))."
									AND TGL_BL_AWB = ".$this->db->escape(trim($kms[3]));
						$result_kms = $func->main->get_result($PLP_KMS);
						if($result_kms){
							$insertKemasan = false;
						}
					}
					if($insertKemasan){
						$this->db->insert('t_request_batal_plp_hdr',$DATA);
						$ID_PLP = $this->db->insert_id();
						for($a=0; $a<count($arr_kms)-1; $a++){
							$kms = explode("~",$arr_kms[$a]);
							$KMS['ID'] = $ID_PLP;
							$KMS['KD_KEMASAN'] = $kms[1];
							$KMS['NO_BL_AWB'] = $kms[2];
							$KMS['TGL_BL_AWB'] = $kms[3];
							$KMS['JML_KMS'] = $kms[4];
							$this->db->insert('t_request_batal_plp_kms',$KMS);
						}
					}else{
						$error += 1;
						$message .= "Data gagal diproses, periksa No. BL/AWB dan Tgl. BL/AWB";
					}
				}
				if($error == 0){
					$func->main->get_log("add","t_request_batal_plp_hdr,t_request_batal_plp_kms");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pembatalan";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		}else if($type=="update"){
			if($act=="pengajuan"){
				$arrid = explode("~",$id);
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = strtoupper($b);
				}
				$DATA['KD_TPS_ASAL'] = $KD_TPS;
				$DATA['KD_GUDANG_ASAL'] = $KD_GUDANG;
				$DATA['KD_KPBC'] = $KD_KPBC;
				$DATA['TGL_SURAT'] = date_input($DATA['TGL_SURAT']);
				$DATA['TGL_TIBA'] = date_input($DATA['TGL_TIBA']);
				$DATA['TGL_BC11'] = date_input($DATA['TGL_BC11']);
				$DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
				$SQL = "SELECT ID FROM t_request_plp_hdr
						WHERE NO_BC11 = ".$this->db->escape(trim($DATA['NO_BC11']))."
						AND TGL_BC11 = ".$this->db->escape(trim($DATA['TGL_BC11']));
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					$ID_PLP = $arrdata['ID'];
				}
				if($ID_PLP==$arrid[0]){
					$this->db->where(array('ID' => $arrid[0]));
					$exec = $this->db->update('t_request_plp_hdr', $DATA);
					if($exec){
						$this->db->delete('t_request_plp_kms',array('ID'=>$arrid[0]));
						$id_kms = $this->input->post('tmpchktblkemasan');
						$arr_kms = explode("*",$id_kms);
						$insertKemasan = true;
						for($a=0; $a<count($arr_kms); $a++){
							$kms = explode("~",$arr_kms[$a]);
							$SQL_KMS = "SELECT KD_KEMASAN, JUMLAH, NO_BL_AWB, TGL_BL_AWB
										FROM t_cocostskms
										WHERE ID = ".$this->db->escape($kms[0])."
										AND SERI = ".$this->db->escape($kms[1]);
							$result_kms = $func->main->get_result($SQL_KMS);
							if($result_kms){
								foreach($SQL_KMS->result_array() as $row => $value){
									$arrkms = $value;
								}
								$PLP_KMS = "SELECT ID FROM t_request_plp_kms 
											WHERE KD_KEMASAN = ".$this->db->escape($arrkms['KD_KEMASAN'])."
											AND NO_BL_AWB = ".$this->db->escape($arrkms['NO_BL_AWB'])."
											AND TGL_BL_AWB = ".$this->db->escape($arrkms['TGL_BL_AWB']);
								$result_plp = $func->main->get_result($PLP_KMS);
								if($result_plp){
									$insertKemasan = false;
								}
							}
						}
						if($insertKemasan){
							for($a=0; $a<count($arr_kms); $a++){
								$kms = explode("~",$arr_kms[$a]);
								$SQL_KMS = "SELECT KD_KEMASAN, JUMLAH, NO_BL_AWB, TGL_BL_AWB
											FROM t_cocostskms
											WHERE ID = ".$this->db->escape($kms[0])."
											AND SERI = ".$this->db->escape($kms[1]);
								$result_kms = $func->main->get_result($SQL_KMS);
								if($result_kms){
									foreach($SQL_KMS->result_array() as $row => $value){
										$arrkms = $value;
									}
									$arrkms['ID'] = $ID_PLP;
									$arrkms['JML_KMS'] = $arrkms['JUMLAH'];
									unset($arrkms['JUMLAH']);
									$this->db->insert('t_request_plp_kms',$arrkms);
								}
							}
						}else{
							$error += 1;
							$message = "Data gagal diproses, periksa No. BL/AWB dan Tgl. BL/AWB";
						}	
					}
				}else{
					$error += 1;
					$message = "Data gagal diproses, periksa data kembali";
				}
				if($error == 0){
					$func->main->get_log("add","t_request_plp_hdr,t_request_plp_kms");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pengajuan";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="send_pengajuan"){
				$sendData = true;
				foreach($this->input->post('tb_chktblplp') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$status = $arrchk[2];
					if($status!="100"){
						$sendData = false;
					}
				}
				if($sendData){
					foreach($this->input->post('tb_chktblplp') as $chkitem){
						$arrchk = explode("~", $chkitem);
						$id_plp = $arrchk[0];
						$this->db->where(array('ID'=>$id_plp));
						$this->db->update('t_request_plp_hdr',array('KD_STATUS'=>'200'));
					}	
				}else{
					$error += 1;
					$message = "Data gagal diproses";
				}
				if($error == 0){
					$func->main->get_log("update","t_request_plp_hdr");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pengajuan/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="pembatalan"){
				$arrid = explode("~",$id);
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = strtoupper($b);
				}
				$DATA['TGL_SURAT'] = date_input($DATA['TGL_SURAT']);
				$DATA['KD_STATUS'] = '100';
				$DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
				$SQL = "SELECT A.ID
						FROM t_request_batal_plp_hdr A
						WHERE A.NO_SURAT = ".$this->db->escape(trim($DATA['NO_SURAT']))."
						AND A.TGL_SURAT = ".$this->db->escape(trim($DATA['TGL_SURAT']));
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					$ID_PLP = $arrdata['ID'];
				}
				if($ID_PLP==$arrid[0]){
					$this->db->where(array('ID' => $arrid[0]));
					$exec = $this->db->update('t_request_batal_plp_hdr', $DATA);
					if($exec){
						$this->db->delete('t_request_batal_plp_kms',array('ID'=>$arrid[0]));	
						$id_kms = $this->input->post('tmpchktblkemasanplp');
						$arr_kms = explode("*",$id_kms);
						$insertKemasan = true;
						for($a=0; $a<count($arr_kms)-1; $a++){
							$kms = explode("~",$arr_kms[$a]);
							$PLP_KMS = "SELECT ID
										FROM t_request_batal_plp_kms 
										WHERE KD_KEMASAN = ".$this->db->escape(trim($kms[1]))."
										AND NO_BL_AWB = ".$this->db->escape(trim($kms[2]))."
										AND TGL_BL_AWB = ".$this->db->escape(trim($kms[3]));
							$result_kms = $func->main->get_result($PLP_KMS);
							if($result_kms){
								$insertKemasan = false;
							}
						}
						if($insertKemasan){
							for($a=0; $a<count($arr_kms)-1; $a++){
								$kms = explode("~",$arr_kms[$a]);
								$KMS['ID'] = $ID_PLP;
								$KMS['KD_KEMASAN'] = $kms[1];
								$KMS['NO_BL_AWB'] = $kms[2];
								$KMS['TGL_BL_AWB'] = $kms[3];
								$KMS['JML_KMS'] = $kms[4];
								$this->db->insert('t_request_batal_plp_kms',$KMS);
							}
						}else{
							$error += 1;
							$message .= "Data gagal diproses, periksa No. BL/AWB dan Tgl. BL/AWB";
						}
					}
				}else{
					$error += 1;
					$message = "Data gagal diproses, periksa data kembali";
				}
				if($error == 0){
					$func->main->get_log("update","t_request_batal_plp_hdr,t_request_batal_plp_kms");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pembatalan";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="send_pembatalan"){
				$sendData = true;
				foreach($this->input->post('tb_chktblplp') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$status = $arrchk[2];
					if($status!="100"){
						$sendData = false;
					}
				}
				if($sendData){
					foreach($this->input->post('tb_chktblplp') as $chkitem){
						$arrchk = explode("~", $chkitem);
						$id_plp = $arrchk[0];
						$this->db->where(array('ID'=>$id_plp));
						$this->db->update('t_request_batal_plp_hdr',array('KD_STATUS'=>'200'));
					}	
				}else{
					$error += 1;
					$message = "Data gagal diproses";
				}
				if($error == 0){
					$func->main->get_log("update","t_request_batal_plp_hdr");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pembatalan/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			
			}
		}else if($type=="delete"){
			if($act=="pengajuan"){
				$deleteData = true;
				foreach($this->input->post('tb_chktblplp') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$id_plp = $arrchk[0];
					$id_hdr = $arrchk[1];
					$status = $arrchk[2];
					if($status!="100"){
						$deleteData = false;
					}
				}
				if($deleteData){
					foreach($this->input->post('tb_chktblplp') as $chkitem){
						$arrchk = explode("~", $chkitem);
						$id_plp = $arrchk[0];
						$this->db->delete('t_request_plp_status',array('ID'=>$id_plp));
						$this->db->delete('t_request_plp_kms',array('ID'=>$id_plp));
						$this->db->delete('t_request_plp_hdr',array('ID'=>$id_plp));
					}	
				}else{
					$error += 1;
					$message = "Data gagal diproses";
				}
				if($error == 0){
					$func->main->get_log("delete","t_request_plp_hdr,t_request_plp_kms,t_request_plp_status");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pengajuan/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="pembatalan"){
				$deleteData = true;
				foreach($this->input->post('tb_chktblplp') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$id_plp = $arrchk[0];
					$id_respon = $arrchk[1];
					$status = $arrchk[2];
					if($status!="100"){
						$deleteData = false;
					}
				}
				if($deleteData){
					foreach($this->input->post('tb_chktblplp') as $chkitem){
						$arrchk = explode("~", $chkitem);
						$id_plp = $arrchk[0];
						$this->db->delete('t_request_batal_plp_status',array('ID'=>$id_plp));
						$this->db->delete('t_request_batal_plp_kms',array('ID'=>$id_plp));
						$this->db->delete('t_request_batal_plp_hdr',array('ID'=>$id_plp));
					}	
				}else{
					$error += 1;
					$message = "Data gagal diproses";
				}
				if($error == 0){
					$func->main->get_log("delete","t_request_batal_plp_hdr,t_request_batal_plp_kms,t_request_batal_plp_status");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pembatalan/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		}else if($type=="get"){
			if($act=="respon_plp"){
				$arrid = explode("|",$id);
				$SQL = "SELECT A.ID, A.KD_KPBC, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN, A.NO_PLP, A.TGL_PLP, A.NO_SURAT, 
						A.TGL_SURAT, A.NM_ANGKUT, A.NO_VOY_FLIGHT, A.CALL_SIGN, DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, A.NO_BC11, 
						DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') TGL_BC11
						FROM t_respon_plp_tujuan_v2_hdr A
						WHERE A.NO_PLP = ".$this->db->escape(trim($arrid[0]))."
						AND DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y')=".$this->db->escape($arrid[1]);
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
				}else {
					$arrdata = array('ID' => '');
				}
				echo json_encode($arrdata);
			}else if($act=="cocostshdr"){
				$arrid = explode("~",$id);
				$SQL = "SELECT A.*, B.NAMA AS NAMA_KAPAL, B.CALL_SIGN, func_name(A.KD_ASAL_BRG,'ASAL_BARANG') AS ASAL_BARANG,
						func_name(A.KD_ASAL_BRG,'ASAL_BARANG') AS ASAL_BARANG, func_name(A.KD_GUDANG,'GUDANG') AS GUDANG,
						func_name(A.KD_KAPAL,'KAPAL') AS NAMA_KAPAL, DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, 
						func_name(A.KD_PEL_MUAT,'PORT') AS PEL_MUAT, func_name(A.KD_PEL_TRANSIT,'PORT') AS PEL_TRANSIT,
						func_name(A.KD_PEL_BONGKAR,'port') AS PEL_BONGKAR, DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS TGL_BC11, 
						DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y %H:%i:%s') AS TGL_REKAM, func_name(A.KD_TPS,'TPS') AS TPS,
						DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') TGL_PLP
						FROM t_cocostshdr A
						INNER JOIN reff_kapal B ON B.ID=A.KD_KAPAL
						WHERE A.ID = ".$this->db->escape($arrid[0]);
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="cocostskms"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				if($arrid[1]!=""){
					$addsql .= " AND A.SERI = ".$this->db->escape($arrid[1]);
				}
				$SQL = "SELECT A.*, func_name(A.KD_KEMASAN,'KEMASAN') AS KEMASAN, func_name(A.KD_DOK_IN,'DOK_BC') AS NAMA_DOK_IN,
						func_name(A.KD_PEL_MUAT,'PORT') AS PEL_MUAT, func_name(A.KD_PEL_TRANSIT,'PORT') AS PEL_TRANSIT, 
						func_name(A.KD_PEL_BONGKAR,'PORT') AS PEL_BONGKAR, B.NAMA AS CONSIGNEE, 
						DATE_FORMAT(A.WK_IN,'%d-%m-%Y %H:%i:%s') AS WK_IN,
						DATE_FORMAT(A.WK_OUT,'%d-%m-%Y %H:%i:%s') AS WK_OUT, func_name(A.KD_DOK_OUT,'DOK_BC') AS NAMA_DOK_OUT
						FROM t_cocostskms A
						LEFT JOIN t_organisasi B ON B.ID=A.KD_ORG_CONSIGNEE
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="plp_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				if($arrid[1]!=""){
					$addsql .= " AND A.KD_COCOSTSHDR = ".$this->db->escape($arrid[1]);
				}
				$SQL = "SELECT A.*, DATE_FORMAT(A.TGL_SURAT,'%d-%m-%Y') AS TGL_SURAT, func_name(A.KD_TPS_TUJUAN,'TPS') AS TPS_TUJUAN,
						func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG_TUJUAN, B.NAMA AS NM_KAPAL, B.CALL_SIGN, C.NAMA AS ALASAN_PLP
						FROM t_request_plp_hdr A
						LEFT JOIN reff_kapal B ON B.ID=A.KD_KAPAL
						LEFT JOIN reff_alasan_plp C ON C.ID=A.KD_ALASAN_PLP
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="respon_plp_asal_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT A.*, func_name(B.KD_GUDANG_ASAL,'GUDANG') AS TPS
						FROM t_respon_plp_asal_hdr A JOIN t_request_plp_hdr B ON B.REF_NUMBER=A.REF_NUMBER
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="request_batal_plp_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT *, func_name(A.KD_TPS,'TPS') AS TPS, func_name(A.KD_GUDANG,'GUDANG') AS GUDANG
						FROM t_request_batal_plp_hdr A
						INNER JOIN t_respon_plp_asal_hdr B ON B.ID=A.KD_RESPON_PLP_ASAL
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="request_batal_plp_kms"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT A.*, func_name(A.KD_KEMASAN,'KEMASAN') AS KEMASAN
						FROM t_request_batal_plp_kms A
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="respon_plp_tujuan_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT A.*, func_name(A.KD_TPS_ASAL,'TPS') AS TPS_ASAL, func_name(A.KD_TPS_TUJUAN,'TPS') AS TPS_TUJUAN,
						func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG_TUJUAN
						FROM t_respon_plp_tujuan_v2_hdr A
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="respon_batal_plp_asal_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT *, func_name(A.KD_TPS,'TPS') AS TPS
						FROM t_respon_batal_plp_asal_hdr A
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="respon_batal_plp_tujuan_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT *, func_name(A.KD_TPS,'TPS') AS TPS, func_name(A.KD_TPS_ASAL,'TPS') AS TPS_ASAL
						FROM t_respon_batal_plp_tujuan_hdr A
						WHERE 1=1".$addsql;

				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}
		}
	}

	function v_res_batal_plp_tujuan_kms($act, $id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', 
				A.ID, A.KD_KEMASAN, A.NO_BL_AWB, A.TGL_BL_AWB, A.JML_KMS
				FROM t_respon_batal_plp_tujuan_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
				$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
		$check = (grant()=="W")?true:false;
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/v_res_batal_plp_tujuan_kms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->keys(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}

	function v_res_batal_plp_tujuan_cont($act, $id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KONTAINER";
		$SQL = "SELECT A.NO_CONT as 'NO KONTAINER',func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN, A.NO_CONT, A.ID
				FROM t_respon_batal_plp_tujuan_cont A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(true);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT', 'NO KONTAINER')));
		$this->newtable->action(site_url() . "/plp/v_res_batal_plp_tujuan_cont/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NO_CONT"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}

	function v_res_batal_plp_asal_kms($act, $id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', 
				A.ID, A.KD_KEMASAN, A.NO_BL_AWB, A.TGL_BL_AWB, A.JML_KMS
				FROM t_respon_batal_plp_asal_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
				$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
		$check = (grant()=="W")?true:false;
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/v_res_batal_plp_asal_kms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->keys(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}

	function v_res_batal_plp_asal_cont($act, $id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KONTAINER";
		$SQL = "SELECT A.NO_CONT as 'NO KONTAINER',func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN, B.NAMA AS 'STATUS', A.NO_CONT, A.ID
				FROM t_respon_batal_plp_asal_cont A JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPRESDTL'
				WHERE A.ID = ".$this->db->escape($arrid[0]);
				$proses = '';/* array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); */
		$check = (grant()=="W")?true:false;
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT', 'NO KONTAINER')));
		$this->newtable->hiddens(array("ID","NO_CONT"));
		$this->newtable->action(site_url() . "/plp/v_res_batal_plp_asal_cont/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}
}
/* 	function pengajuan_discharge($act,$id){
		$title = "DISCHARGE";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		if(!$this->input->post('ajax')){
			$addsql .= " AND DATE(A.TGL_TIBA) >= DATE_ADD(DATE(NOW()), INTERVAL -7 DAY)";
		}
		$SQL = "SELECT CONCAT(C.NAMA,'<BR>[',A.NM_ANGKUT,']') AS 'NAMA ANGKUT', C.CALL_SIGN AS 'CALL SIGN', 
				A.NO_VOY_FLIGHT AS 'NO. VOY FLIGHT', 
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', A.NO_BC11 AS 'NO. BC11',
				DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL. BC11', A.WK_REKAM AS 'WAKTU REKAM', A.ID
				FROM t_cocostshdr A 
				LEFT JOIN reff_gudang B ON A.KD_TPS = B.KD_TPS AND A.KD_GUDANG = B.KD_GUDANG 
				LEFT JOIN reff_kapal C ON A.KD_KAPAL = C.ID
				WHERE A.KD_ASAL_BRG = '1'".$addsql;
$proses =  array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); 
	
		$this->newtable->show_chk($check);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_BC11','NO. BC11'),array('C.NAMA','NAMA ANGKUT'),array('A.TGL_TIBA','TGL. TIBA','DATERANGE')));
		$this->newtable->action(site_url() . "/plp/pengajuan_discharge");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(7);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldischarge");
		$this->newtable->set_divid("divtbldischarge");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $title, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;	
	}
	
	public function pengajuan_discharge_kontainer($act, $id){
		$title = "";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		$arrid = explode("~",$id);
		$SQL = "SELECT A.NO_CONT AS 'NO. KONTAINER', func_name(A.KD_CONT_UKURAN,'CONT_UKURAN') AS UKURAN, 
				func_name(A.KD_CONT_JENIS,'CONT_JENIS') AS JENIS, func_name(A.KD_CONT_TIPE,'CONT_TIPE') AS TIPE, 
				A.BRUTO, B.NAMA AS CONSIGNEE, A.WK_REKAM AS 'WAKTU REKAM', A.ID, C.NO_CONT AS NO_CONT_PLP
				FROM t_cocostscont A 
				LEFT JOIN t_organisasi B ON B.ID=A.KD_ORG_CONSIGNEE 
				LEFT JOIN(SELECT X.KD_COCOSTSHDR, Y.NO_CONT
						  FROM t_request_plp_hdr X
						  INNER JOIN t_request_plp_cont Y ON Y.ID=X.ID
						  WHERE X.ID = ".$this->db->escape($arrid[1]).") C ON C.KD_COCOSTSHDR=A.ID AND C.NO_CONT=A.NO_CONT
				WHERE A.ID = ".$this->db->escape($arrid[0]);//echo $SQL;die();
		$proses = array('' => array('','', '1','',''));
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($check);
		$this->newtable->checked(array("NO_CONT_PLP"));
		$this->newtable->show_menu(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/plp/pengajuan_discharge_kontainer/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NO_CONT_PLP"));
		$this->newtable->keys(array("ID","NO. KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(9);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkontainer");
		$this->newtable->set_divid("divtblkontainer");
		$this->newtable->rowcount('ALL');
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}
		
	public function pengajuan_respon($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "RESPONS";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT IFNULL(A.REF_NUMBER,'-') AS 'REF NUMBER',
				CONCAT('NO. : ',IFNULL(A.NO_PLP,'-'),'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y'),'-')) AS 'SURAT PLP',
				func_name(A.KD_KPBC,'KPBC') AS KPBC, A.ALASAN_REJECT AS 'ALASAN REJECT', 
				CONCAT(B.NAMA,'<BR>',DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s')) AS STATUS, A.TGL_STATUS, A.ID
				FROM t_respon_plp_asal_hdr A
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPRES'
				WHERE 1=1".$addsql;
					
	$proses =  array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); 
	
		$this->newtable->multiple_search(true);
		#$this->newtable->show_chk(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_PLP','NO. PLP'),array('A.TGL_PLP','TGL. PLP','DATERANGE'),array('A.REF_NUMBER','REF NUMBER')));
		$this->newtable->action(site_url() . "/plp/pengajuan_respon");
		if($check) $this->newtable->detail(array('POPUP',"plp/pengajuan_respon/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","TGL_STATUS"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(7);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblresponsdokumen");
		$this->newtable->set_divid("divtblresponsdokumen");
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
	
	public function pengajuan_respon_plp_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.NO_CONT AS 'NO. KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN, 
				func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS') AS JENIS, B.NAMA AS STATUS
				FROM t_respon_plp_asal_cont A
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPRESDTL'
				WHERE A.ID = ".$this->db->escape($id);
		$proses =  array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); 
	
		$this->newtable->multiple_search(false);
		//$this->newtable->show_chk(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','KONTAINER')));
		$this->newtable->action(site_url() . "/plp/pengajuan_respon_plp_kontainer/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array(""));
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
	function pembatalan_respon_plp($act,$id){
		$title = "RESPONS PLP";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		if(!$this->input->post('ajax')){
			$addsql .= " AND DATE(A.TGL_PLP) >= DATE_ADD(DATE(NOW()), INTERVAL -7 DAY)";
		}
		$SQL = "SELECT CONCAT('NO. : ',IFNULL(A.NO_PLP,'-'),'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y'),'-')) AS 'RESPON PLP',
				func_name(A.KD_KPBC,'KPBC') AS 'KPBC', A.ALASAN_REJECT AS 'ALASAN REJECT', A.REF_NUMBER AS 'REF NUMBER',
				CONCAT(B.NAMA,'<BR>',DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s')) AS STATUS, A.TGL_STATUS, A.ID
				FROM t_respon_plp_asal_hdr A
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPRES'
				WHERE 1=1".$addsql;
		$proses =  array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); 
		#$this->newtable->show_chk(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_PLP','NO. PLP'),array('A.TGL_PLP','TGL. PLP','DATERANGE')));
		$this->newtable->action(site_url() . "/plp/pembatalan_respon_plp");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","TGL_STATUS"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(5);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblrespons");
		$this->newtable->set_divid("divtblrespons");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $title, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;	
	}
	
	public function pembatalan_respon_plp_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		$arrid = explode("~",$id);
		$SQL = "SELECT A.NO_CONT AS 'NO. KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN, 
				func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS') AS JENIS, B.NO_CONT AS NO_CONT_BATAL, A.ID
				FROM t_respon_plp_asal_cont A
				LEFT JOIN (SELECT Y.KD_RESPON_PLP_ASAL, X.NO_CONT
						   FROM t_request_batal_plp_cont X
						   INNER JOIN t_request_batal_plp_hdr Y ON Y.ID=X.ID
						   WHERE X.ID = ".$this->db->escape($arrid[1]).") B ON B.KD_RESPON_PLP_ASAL=A.ID AND B.NO_CONT=A.NO_CONT
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$proses = array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); 
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(true);
		$this->newtable->checked(array("NO_CONT_BATAL"));
		$this->newtable->show_menu(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/plp/pembatalan_respon_plp_kontainer/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NO_CONT_BATAL"));
		$this->newtable->keys(array("ID","NO. KONTAINER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblresponplpkontainer");
		$this->newtable->set_divid("divtblresponplpkontainer");
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
		
	public function pembatalan_respon($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "RESPONS PEMBATALAN PLP";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT('NO. : ',IFNULL(A.NO_BATAL_PLP,'-'),'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_BATAL_PLP,'%d-%m-%Y'),'-'))
				AS 'SURAT PEMBATALAN PLP', func_name(A.KD_KPBC,'KPBC') AS KPBC, A.REF_NUMBER AS 'REF NUMBER', 
				CONCAT(B.NAMA,'<BR>',DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s')) AS STATUS, A.TGL_STATUS, A.ID
				FROM t_respon_batal_plp_asal_hdr A
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='BTLRES'
				WHERE 1=1".$addsql;
		$proses =  array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); 
		$this->newtable->multiple_search(true);
		#$this->newtable->show_chk(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_BATAL_PLP','NO. PEMBATALAN PLP'),array('A.TGL_BATAL_PLP','TGL. PEMBATALAN PLP','DATERANGE')));
		$this->newtable->action(site_url() . "/plp/pembatalan_respon");
		if($check) $this->newtable->detail(array('POPUP',"plp/pembatalan_respon/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","TGL_STATUS"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(5);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblresponsdokumen");
		$this->newtable->set_divid("divtblresponsdokumen");
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
	
	public function pembatalan_respon_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.NO_CONT AS 'NO. KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN, 
				func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS') AS JENIS 
				FROM t_respon_batal_plp_asal_cont A
				WHERE A.ID = ".$this->db->escape($id);
		$proses =  array('REQUEST'	  => array('ADD_MODAL','', '','','glyphicon glyphicon-send'),
						'RESPON'  => array('ADD_MODAL','', '','','glyphicon glyphicon-retweet')); 
		$this->newtable->multiple_search(false);
		#$this->newtable->show_chk(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','KONTAINER')));
		$this->newtable->action(site_url() . "/plp/pembatalan_respon_kontainer/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array(""));
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
	
	function monitoring($act,$id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "PENGAJUAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS_ASAL = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG_ASAL = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT('NO. : ',IFNULL(A.NO_SURAT,'-'),'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_SURAT,'%d-%m-%Y'),'-')) AS 'SURAT PLP',
				A.NM_ANGKUT AS 'NAMA ANGKUT', A.NO_VOY_FLIGHT AS 'VOYAGE/FLIGHT', DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA',
				CONCAT('NO. : ',A.NO_BC11,'<BR>TGL. : ',DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y')) AS BC11,
				CONCAT('YOR ASAL : ',IFNULL(A.YOR_ASAL,'-'),'<BR> YOR TUJUAN : ',IFNULL(A.YOR_TUJUAN,'-')) AS 'YOR', 
				CONCAT('TPS : ',A.KD_TPS_TUJUAN,'<BR>GUDANG : ',A.KD_GUDANG_TUJUAN) AS 'GUDANG TUJUAN', 
				CONCAT(C.NAMA,'<BR>',DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s')) AS STATUS, A.TGL_STATUS, 
				A.ID, A.KD_COCOSTSHDR, A.KD_STATUS
				FROM t_request_plp_hdr A
				LEFT JOIN reff_kapal B ON B.ID=A.KD_KAPAL
				LEFT JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='PLPAJU'
				WHERE 1=1".$addsql;
		
		$proses = array('ENTRY'	  => array('MODAL',"plp/pengajuan_discharge", '','','glyphicon glyphicon-plus-sign'),
						'UPDATE'  => array('GET',site_url()."/plp/pengajuan_plp/update", '1','100','glyphicon glyphicon-edit'),
						'DELETE'  => array('DELETE',"execute/process/delete/pengajuan_plp", '1','100','glyphicon glyphicon-remove-circle'),
						'PROCESS' => array('POST',"execute/process/update/send_pengajuan_plp", '1','100','glyphicon glyphicon-send'),
						'DETAIL'  => array('MODAL',"plp/pengajuan_plp/detail", '1','','glyphicon glyphicon-zoom-in'));
	
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		#$this->newtable->show_chk($check);
		#$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_SURAT','NO. SURAT'),array('A.TGL_SURAT','TGL. SURAT','DATERANGE'),array('A.NM_ANGKUT','NAMA ANGKUT'),array('A.TGL_TIBA','TGL. TIBA','DATERANGE')));
		$this->newtable->action(site_url() . "/plp/pengajuan_plp");
		if($check) $this->newtable->detail(array('POPUP',"plp/pengajuan_plp/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("KD_COCOSTSHDR","ID","KD_STATUS","TGL_STATUS"));
		$this->newtable->keys(array("KD_COCOSTSHDR","ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(9);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblrequestdokumen");
		$this->newtable->set_divid("divtblrequestdokumen");
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
	
	function monitoring_pengajuan($act,$id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = false;
		$arrid = explode("~",$id);
		if($KD_GROUP!="SPA"){
			$addsql .= " AND B.KD_TPS_ASAL = ".$this->db->escape($KD_TPS)." AND B.KD_GUDANG_ASAL = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT B.REF_NUMBER AS 'REF NUMBER', CONCAT('NO. : ',B.NO_SURAT,'<BR>TGL. : ',
				DATE_FORMAT(B.TGL_SURAT,'%d-%m-%Y')) AS 'SURAT', 
				CONCAT('NO. KONTAINER : ',IFNULL(A.NO_CONT,'-'),'<BR>UKURAN : ', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN')) AS REQUEST,
				E.NAMA AS 'STATUS REQUEST', CONCAT('NO. : ',C.NO_PLP,'<BR>TGL. : ',DATE_FORMAT(C.TGL_PLP,'%d-%m-%Y')) AS 'PLP',
				CONCAT('NO. KONTAINER : ',IFNULL(C.NO_CONT,'-'),'<BR>UKURAN : ',func_name(IFNULL(C.KD_CONT_UKURAN,'-'),'CONT_UKURAN'),
				'<BR>ALASAN REJECT : ',C.ALASAN_REJECT) AS RESPONSE,
				D.NAMA AS 'STATUS RESPONSE', C.TGL_STATUS
				FROM t_request_plp_cont A 
				INNER JOIN t_request_plp_hdr B ON B.ID=A.ID
				LEFT JOIN (
				SELECT X.NO_PLP, X.TGL_PLP, X.ALASAN_REJECT, X.REF_NUMBER, Y.NO_CONT, Y.KD_CONT_UKURAN, Y.KD_STATUS, X.TGL_STATUS
					FROM t_respon_plp_asal_hdr X 
				INNER JOIN t_respon_plp_asal_cont Y ON Y.ID=X.ID
				) C ON C.REF_NUMBER=B.REF_NUMBER AND A.NO_CONT=C.NO_CONT
				LEFT JOIN reff_status D ON D.ID=C.KD_STATUS AND D.KD_TIPE_STATUS='PLPRESDTL'
				LEFT JOIN reff_status E ON E.ID=B.KD_STATUS AND E.KD_TIPE_STATUS='PLPAJU'
				WHERE 1=1".$addsql;
		$proses = array('' => array("","", '','','glyphicon glyphicon-zoom-in'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		#$this->newtable->show_chk($check);
		#$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','KONTAINER'),array('B.NO_SURAT','NO. SURAT')));
		$this->newtable->action(site_url() . "/plp/monitoring_pengajuan/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("TGL_STATUS","REF_NUMBER"));
		$this->newtable->keys(array("REF_NUMBER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldetailaju");
		$this->newtable->set_divid("divtbldetailaju");
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
	
	function monitoring_pembatalan($act,$id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = false;
		$arrid = explode("~",$id);
		if($KD_GROUP!="SPA"){
			$addsql .= " AND B.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT B.REF_NUMBER AS 'REF NUMBER', CONCAT('NO. : ',B.NO_SURAT,'<BR>TGL. : ',
				DATE_FORMAT(B.TGL_SURAT,'%d-%m-%Y')) AS 'SURAT', 
				CONCAT('NO. KONTAINER : ',IFNULL(A.NO_CONT,'-'),'<BR>UKURAN : ', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN')) 
				AS 'REQUEST BATAL',
				E.NAMA AS 'STATUS REQUEST', CONCAT('NO. : ',C.NO_PLP,'<BR>TGL. : ',DATE_FORMAT(C.TGL_PLP,'%d-%m-%Y')) AS 'BATAL PLP',
				CONCAT('NO. KONTAINER : ',IFNULL(C.NO_CONT,'-'),'<BR>UKURAN : ',func_name(IFNULL(C.KD_CONT_UKURAN,'-'),'CONT_UKURAN')) 
				AS 'RESPONSE BATAL', D.NAMA AS 'STATUS RESPONSE', C.TGL_STATUS
				FROM t_request_batal_plp_cont A 
				INNER JOIN t_request_batal_plp_hdr B ON B.ID=A.ID
				LEFT JOIN (
				SELECT X.NO_BATAL_PLP AS NO_PLP, X.TGL_BATAL_PLP AS TGL_PLP, X.REF_NUMBER, Y.NO_CONT, Y.KD_CONT_UKURAN, Y.KD_STATUS, X.TGL_STATUS
					FROM t_respon_batal_plp_asal_hdr X 
				INNER JOIN t_respon_batal_plp_asal_cont Y ON Y.ID=X.ID
				) C ON C.REF_NUMBER=B.REF_NUMBER AND A.NO_CONT=C.NO_CONT
				LEFT JOIN reff_status D ON D.ID=C.KD_STATUS AND D.KD_TIPE_STATUS='PLPRESDTL'
				LEFT JOIN reff_status E ON E.ID=B.KD_STATUS AND E.KD_TIPE_STATUS='BTLPLP'
				WHERE 1=1".$addsql;
		$proses = array('' => array("","", '','','glyphicon glyphicon-zoom-in'));
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT','KONTAINER')));
		$this->newtable->action(site_url() . "/plp/monitoring_pembatalan/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("TGL_STATUS"));
		$this->newtable->keys(array(""));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldetailbatal");
		$this->newtable->set_divid("divtbldetailbatal");
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
 */