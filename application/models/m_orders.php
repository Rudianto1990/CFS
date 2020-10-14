<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class m_orders extends Model{

  function m_orders() {
     parent::Model();
  }

  function get_comboboxnamagudang($find){
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        if($find=="GUDANG"){
          $sql = "SELECT KD_GUDANG,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '2' and KD_GUDANG in ('BAND','RAYA') ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "NAMA_GUDANG", TRUE);
        }else if($find == "TPS"){
          $sql = "SELECT KD_GUDANG,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '1' and KD_GUDANG <> 'CART' ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "NAMA_GUDANG", TRUE);
        }
        
    return $arrdata;
  }

	function autocomplete($type,$act,$get){
		$post = $this->input->post('term');
		if($type=="no_bl"){
			if($act=="nama"){        
			  if (!$post) return;
			  $SQL = "select A.ID,A.CAR,A.KD_KANTOR,func_name(IFNULL(A.KD_KANTOR,'-'),'KPBC') AS NM_KANTOR,
				A.KD_DOK_INOUT AS KD_DOK,func_name(IFNULL(A.KD_DOK_INOUT,'-'),'DOK_BC') AS NM_DOK,
				A.NO_DOK_INOUT AS NO_SPPB,DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y') AS TGL_SPPB,func_npwp(A.ID_CONSIGNEE) AS NPWP,
				A.CONSIGNEE,A.NM_ANGKUT,A.KD_GUDANG,func_name(IFNULL(A.KD_GUDANG,'-'),'GUDANG') AS NM_GUDANG,A.NO_BL_AWB AS BL from t_permit_hdr A
				WHERE A.NO_BL_AWB LIKE '%".$post."%' LIMIT 5"; 
			  /* $SQL = "select A.ID,A.CAR,A.KD_KANTOR,A.KD_DOK_INOUT,A.NO_DOK_INOUT,A.TGL_DOK_INOUT,A.ID_CONSIGNEE,
				A.CONSIGNEE,A.NM_ANGKUT,A.KD_GUDANG,B.NO_CONT_ASAL,C.NM_ANGKUT,C.TGL_TIBA,A.NO_BL_AWB
				from t_permit_hdr A join t_cocostskms B on A.NO_BL_AWB = B.NO_BL_AWB join t_cocostshdr C on B.ID=C.ID and A.KD_GUDANG=C.KD_GUDANG
				WHERE A.NO_BL_AWB LIKE '%".$post."%' LIMIT 5"; */ #query untuk setelah data t_permit_hdr dan t_cocostskms ada
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $BL = strtoupper($row->BL);
				  $KD_DOK = strtoupper($row->KD_DOK);
				  $NM_DOK = strtoupper($row->NM_DOK);
				  $CAR = strtoupper($row->CAR);
				  $NO_SPPB = strtoupper($row->NO_SPPB);
				  $TGL_SPPB = strtoupper($row->TGL_SPPB);
				  $KD_KANTOR = strtoupper($row->KD_KANTOR);
				  $NM_KANTOR = strtoupper($row->NM_KANTOR);
				  $NPWP = strtoupper($row->NPWP);
				  $CONSIGNEE = strtoupper($row->CONSIGNEE);
				  $KD_GUDANG = strtoupper($row->KD_GUDANG);
				  $NM_GUDANG = strtoupper($row->NM_GUDANG);
				  $NM_ANGKUT = strtoupper($row->NM_ANGKUT);
				  $arrayDataTemp[] = array("value"=>$BL,"KD_DOK"=>$KD_DOK,"NM_DOK"=>$NM_DOK,"CAR"=>$CAR,"NO_SPPB"=>$NO_SPPB,"TGL_SPPB"=>$TGL_SPPB,"NM_ANGKUT"=>$NM_ANGKUT,"KD_KANTOR"=>$KD_KANTOR,"NM_KANTOR"=>$NM_KANTOR,"NPWP"=>$NPWP,"CONSIGNEE"=>$CONSIGNEE,"KD_GUDANG"=>$KD_GUDANG,"NM_GUDANG"=>$NM_GUDANG);
				}
			  } 
			}
			echo json_encode($arrayDataTemp);
		}
	}

	function ppbarang($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('Permohonan Pengeluaran Barang', 'javascript:void(0)');
		$data['title'] = 'PERMOHONAN PENGELUARAN BARANG';
		$title = "DATA PERMOHONAN PENGELUARAN BARANG";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.ID,A.NO_ORDER AS 'NO ORDER',CONCAT('NO D/O: ',IFNULL(A.NO_DO,'-'),'<BR>TGL D/O : ',IFNULL(DATE_FORMAT(A.TGL_DO,'%d-%m-%Y'),'-'),
				'<BR>TGL EXPIRED D/O : ',IFNULL(DATE_FORMAT(A.TGL_EXPIRED_DO,'%d-%m-%Y'),'-')) AS 'NO D/O',A.NAMA_FORWARDER AS 'NAMA FORWARDER',
				A.NO_CONT_ASAL AS 'NO CONTAINER', CONCAT('JENIS DOKUMEN IZIN : ',func_name(IFNULL(A.KODE_DOK,'-'),'DOK_BC'),'<BR>NO :',
				IFNULL(A.NO_SPPB,'-'),'<BR>TGL : ',IFNULL(DATE_FORMAT(A.TGL_SPPB,'%d-%m-%Y'),'-')) AS 'NO SPPB',
				CONCAT('NAMA : ',A.CONSIGNEE,'<BR>NPWP : ',func_npwp(A.NPWP_CONSIGNEE)) AS 'CONSIGNEE',func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'GUDANG',
				CONCAT('NAMA KAPAL : ',A.NM_ANGKUT,'<BR>TGL TIBA :',IFNULL(DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y'),'-')) AS 'KAPAL',
				CONCAT(IFNULL(A.STATUS,'-'),'<BR>TGL KONFIRM : ',IFNULL(DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y'),'-'),'<BR>TGL BUAT : ',
				IFNULL(DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y'),'-'),'<BR>PETUGAS : ',B.NM_LENGKAP) AS 'STATUS',A.CAR 
				FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID WHERE A.NO_ORDER LIKE 'KMS%'".$addsql;
		$proses = array(
			'ENTRY'	 => array('ADD_MODAL',"/order/ppbarang/add", '0','','icon-plus', '', '1'),
			'UPDATE' => array('EDIT_MODAL',"/order/ppbarang/edit", '1','','icon-refresh'),
			'DELETE' => array('DELETE', site_url() . "/order/execute/delete/sppb", 'ALL', '', 'icon-trash'),
			'KIRIM' => array('MODAL', "order/ppbarang/kirim", '1', '', 'icon-share-alt')
		);
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA FORWARDER'),array('A.CONSIGNEE','NAMA CONSIGNEE'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.STATUS', 'STATUS', 'OPTION', array(''=>'','DRAFT'=>'DRAFT','KIRIM'=>'KIRIM','DISETUJUI'=>'DISETUJUI','DITOLAK'=>'DITOLAK'))));
    	}else{
    		$this->newtable->search(array(array('A.NO_BL','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA FORWARDER')));
    	}
		
		$this->newtable->action(site_url() . "/order/ppbarang");
		//if($check) $this->newtable->detail(array('POPUP',"ppbarang/listdata/detail"));
		$this->newtable->detail(array('POPUP',"order/ppbarang/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("CAR","ID"));
		$this->newtable->keys(array("CAR","ID"));
		//$this->newtable->validasi(array("ID_SPPB"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblppbarang");
		$this->newtable->set_divid("divtblppbarang");
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

	function approval($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('Approval Nilai Tagihan', 'javascript:void(0)');
		$data['title'] = 'APPROVAL NILAI TAGIHAN';
		$title = "DATA APPROVAL NILAI TAGIHAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.ID,A.NO_ORDER AS 'NO ORDER',CONCAT('NO D/O: ',IFNULL(A.NO_DO,'-'),'<BR>TGL D/O : ',IFNULL(DATE_FORMAT(A.TGL_DO,'%d-%m-%Y'),'-'),
				'<BR>TGL EXPIRED D/O : ',IFNULL(DATE_FORMAT(A.TGL_EXPIRED_DO,'%d-%m-%Y'),'-')) AS 'NO D/O',A.NAMA_FORWARDER AS 'NAMA FORWARDER',
				A.NO_CONT_ASAL AS 'NO CONTAINER', CONCAT('JENIS DOKUMEN IZIN : ',func_name(IFNULL(A.KODE_DOK,'-'),'DOK_BC'),'<BR>NO :',
				IFNULL(A.NO_SPPB,'-'),'<BR>TGL : ',IFNULL(DATE_FORMAT(A.TGL_SPPB,'%d-%m-%Y'),'-')) AS 'NO SPPB',
				CONCAT('NAMA : ',A.CONSIGNEE,'<BR>NPWP : ',func_npwp(A.NPWP_CONSIGNEE)) AS 'CONSIGNEE',func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'GUDANG',
				CONCAT('NAMA KAPAL : ',A.NM_ANGKUT,'<BR>TGL TIBA :',IFNULL(DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y'),'-')) AS 'KAPAL',
				CONCAT(IFNULL(A.STATUS,'-'),'<BR>TGL KONFIRM : ',IFNULL(DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y'),'-'),'<BR>TGL BUAT : ',
				IFNULL(DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y'),'-'),'<BR>PETUGAS : ',B.NM_LENGKAP) AS 'STATUS',A.CAR 
				FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID WHERE A.NO_ORDER LIKE 'KMS%' AND A.STATUS = '300'".$addsql;
		$proses = array('PRINT' => array('PRINT', site_url() . "/order/proses_print/order/lalalalacetak", '1', '', 'icon-printer'));
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_BL','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA FORWARDER'),array('A.CONSIGNEE','NAMA CONSIGNEE'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.STATUS', 'STATUS', 'OPTION', array(''=>'','DRAFT'=>'DRAFT','KIRIM'=>'KIRIM','DISETUJUI'=>'DISETUJUI','DITOLAK'=>'DITOLAK'))));
    	}else{
    		$this->newtable->search(array(array('A.NO_BL','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA FORWARDER')));
    	}
		
		$this->newtable->action(site_url() . "/order/approval");
		//if($check) $this->newtable->detail(array('POPUP',"ppbarang/listdata/detail"));
		$this->newtable->detail(array('POPUP',"order/approval/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("CAR","ID"));
		$this->newtable->keys(array("CAR","ID"));
		//$this->newtable->validasi(array("ID_SPPB"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblppbarang");
		$this->newtable->set_divid("divtblppbarang");
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

	function clearing($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('PENGAJUAN CLEARING PLP', 'javascript:void(0)');
		$data['title'] = 'PENGAJUAN CLEARING PLP';
		$title = "DATA PENGAJUAN CLEARING PLP";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.ID,A.NO_ORDER AS 'NO CLEARING PLP', A.NO_DO AS 'NO PERMOHONAN CFS', A.NAMA_FORWARDER AS 'NAMA FORWARDER',
				CONCAT('TERMINAL ASAL: ',func_name(IFNULL(A.KODE_DOK,'-'),'DOK_BC'),'<BR>GUDANG TUJUAN:',
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG')) AS 'TEMPAT', CONCAT('NO BC 1.1 : ',A.CONSIGNEE,'<BR>TGL BC 1.1 : ',A.NPWP_CONSIGNEE) AS 'BC',
				CONCAT('NAMA KAPAL : ',A.NM_ANGKUT,'<BR>TGL TIBA :',IFNULL(DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y'),'-')) AS 'KAPAL',A.NO_CONT_ASAL AS 'NO CONTAINER',
				CONCAT(IFNULL(A.STATUS,'-'),'<BR>TGL KONFIRM : ',IFNULL(DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y'),'-'),'<BR>TGL BUAT : ',
				IFNULL(DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y'),'-'),'<BR>PETUGAS : ',B.NM_LENGKAP) AS 'STATUS',A.CAR 
				FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID WHERE A.NO_ORDER LIKE 'CONT%'".$addsql;
		$proses = array(
			'ENTRY'	 => array('ADD_MODAL',"/order/clearing/add", '0','','icon-plus', '', '1'),
			'UPDATE' => array('EDIT_MODAL',"/order/clearing/edit", '1','','icon-refresh'),
			'DELETE' => array('DELETE', site_url() . "/order/execute/delete/clearing", 'ALL', '', 'icon-trash'),
			'KIRIM' => array('MODAL', "order/clearing/kirim", '1', '', 'icon-share-alt')
		);
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_BL','NO. CLEARING PLP'),array('A.NO_SPPB','NO. PERMOHONAN CFS'),array('A.NAMA_FORWARDER','NAMA FORWARDER'),array('A.CONSIGNEE','NO CONTAINER'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_GUDANG_TUJUAN', 'TERMINAL', 'OPTION', $arrnamaTPS)));
    	}else{
    		$this->newtable->search(array(array('A.NO_BL','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA FORWARDER')));
    	}
		
		$this->newtable->action(site_url() . "/order/clearing");
		//if($check) $this->newtable->detail(array('POPUP',"clearing/listdata/detail"));
		$this->newtable->detail(array('POPUP',"order/clearing/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("CAR","ID"));
		$this->newtable->keys(array("CAR","ID"));
		//$this->newtable->validasi(array("ID_SPPB"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblclearing");
		$this->newtable->set_divid("divtblclearing");
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

	function approval_clearing($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('Approval Nilai CLEARING PLP', 'javascript:void(0)');
		$data['title'] = 'APPROVAL NILAI CLEARING PLP';
		$title = "DATA APPROVAL NILAI CLEARING PLP";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.ID,A.NO_ORDER AS 'NO CLEARING PLP', A.NO_DO AS 'NO PERMOHONAN CFS', A.NAMA_FORWARDER AS 'NAMA FORWARDER',
				CONCAT('TERMINAL ASAL: ',func_name(IFNULL(A.KODE_DOK,'-'),'DOK_BC'),'<BR>GUDANG TUJUAN:',
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG')) AS 'TEMPAT', CONCAT('NO BC 1.1 : ',A.CONSIGNEE,'<BR>TGL BC 1.1 : ',A.NPWP_CONSIGNEE) AS 'BC',
				CONCAT('NAMA KAPAL : ',A.NM_ANGKUT,'<BR>TGL TIBA :',IFNULL(DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y'),'-')) AS 'KAPAL',A.NO_CONT_ASAL AS 'NO CONTAINER',
				CONCAT(IFNULL(A.STATUS,'-'),'<BR>TGL KONFIRM : ',IFNULL(DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y'),'-'),'<BR>TGL BUAT : ',
				IFNULL(DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y'),'-'),'<BR>PETUGAS : ',B.NM_LENGKAP) AS 'STATUS',A.CAR 
				FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID WHERE A.NO_ORDER LIKE 'CONT%' AND A.STATUS = 'DISETUJUI'".$addsql;
		$proses = array('PRINT' => array('PRINT', site_url() . "/order/proses_print/order/lalalalacetak", '1', '', 'icon-printer'));
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_BL','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA FORWARDER'),array('A.CONSIGNEE','NAMA CONSIGNEE'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.STATUS', 'STATUS', 'OPTION', array(''=>'','DRAFT'=>'DRAFT','KIRIM'=>'KIRIM','DISETUJUI'=>'DISETUJUI','DITOLAK'=>'DITOLAK'))));
    	}else{
    		$this->newtable->search(array(array('A.NO_BL','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA FORWARDER')));
    	}
		
		$this->newtable->action(site_url() . "/order/approval_clearing");
		//if($check) $this->newtable->detail(array('POPUP',"approval_clearing/listdata/detail"));
		$this->newtable->detail(array('POPUP',"order/approval_clearing/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("CAR","ID"));
		$this->newtable->keys(array("CAR","ID"));
		//$this->newtable->validasi(array("ID_SPPB"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblapproval_clearing");
		$this->newtable->set_divid("divtblapproval_clearing");
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

	function validasi_manual($act, $id) {
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('VALIDASI PEMBAYARAN MANUAL', 'javascript:void(0)');
		$data['title'] = 'VALIDASI PEMBAYARAN MANUAL';
		$judul = "DATA VALIDASI PEMBAYARAN MANUAL";
		$addsql = '';
		$SQL = "SELECT A.ID,func_name(A.KD_GUDANG,'GUDANG') AS GUDANG, A.NO_CONT AS CONTAINER, 
			CONCAT('NOMOR : ',A.NO_NOTA,'<BR>TGL : ',A.TGL_NOTA) AS 'NOTA',
			A.NO_FAKTUR AS 'NOMOR FAKTUR', A.TOT_TAGIHAN AS 'TOTAL TAGIHAN',
			CONCAT('STATUS : ',A.STATUS,'<BR>TGL BAYAR : ',A.TGL_BAYAR,'<BR>BANK : ',A.NAMA_BANK) AS 'STATUS'
			FROM t_manual_payment A WHERE 1=1" . $addsql;
		$proses = array('DETAIL' => array('MODAL',"order/validasi_manual/detail", '1','','icon-pencil'),
						'PRINT' => array('PRINT', site_url() . "/order/proses_print/order/cetakinvoice", '1', '', 'icon-printer'));
		$check = (grant() == "W") ? true : false;
		$this->newtable_edit->show_chk(true);
		$this->newtable_edit->multiple_search(true);
		$this->newtable_edit->show_search(true);
		$this->newtable_edit->search(array(array('A.NO_NOTA','NO. PROFORMA INVOICE'),array('A.NO_FAKTUR','NO. BUKTI BAYAR')));
		$this->newtable_edit->action(site_url() . "/order/validasi_manual");
		$this->newtable_edit->detail(array('POPUP',"order/validasi_manual/detail"));
		$this->newtable_edit->tipe_proses('button');
		$this->newtable_edit->hiddens(array("ID"));
		$this->newtable_edit->keys(array("ID"));
		$this->newtable_edit->validasi(array("ID"));
		$this->newtable_edit->cidb($this->db);
		$this->newtable_edit->orderby(1);
		$this->newtable_edit->sortby("DESC");
		$this->newtable_edit->set_formid("tblvalidasi");
		$this->newtable_edit->set_divid("divtblvalidasi");
		$this->newtable_edit->rowcount(10);
		$this->newtable_edit->clear();
		$this->newtable_edit->menu($proses);
		$tabel .= $this->newtable_edit->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
		echo $tabel;
		else
		return $arrdata;
	}

	function surat_jalan($act, $id) {
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('SURAT JALAN', 'javascript:void(0)');
		$data['title'] = 'SURAT JALAN';
		$judul = "DATA SURAT JALAN";
		$addsql = '';
		$SQL = "SELECT A.ID,CONCAT('NOMOR : ',A.NO_BL_AWB,'<BR>TGL : ',DATE_FORMAT(A.TGL_BL_AWB, '%d-%m-%y')) AS 'NOMOR BL',
			CONCAT('NOMOR : ',A.NO_DOK_INOUT,'<BR>TGL : ',DATE_FORMAT(A.TGL_DOK_INOUT, '%d-%m-%y')) AS 'SPPB',
			CONCAT('NAMA : ',A.CONSIGNEE,'<BR>NPWP : ',func_npwp(A.ID_CONSIGNEE)) AS 'CONSIGNEE',
			func_name(A.KD_GUDANG,'GUDANG') AS 'GUDANG' FROM t_permit_hdr A WHERE 1=1" . $addsql;
		$proses = array('DETAIL' => array('MODAL',"order/surat_jalan/detail", '1','','icon-pencil'),
						'PRINT' => array('PRINT', site_url() . "/order/proses_print/order/cetaksuratjalan", '1', '', 'icon-printer'));
		$check = (grant() == "W") ? true : false;
		$this->newtable_edit->show_chk(true);
		$this->newtable_edit->multiple_search(true);
		$this->newtable_edit->show_search(true);
		$this->newtable_edit->search(array(array('A.NO_BL_AWB','NO. BL'),array('A.NO_DOK_INOUT','NO. SPPB')));
		$this->newtable_edit->action(site_url() . "/order/surat_jalan");
		$this->newtable_edit->detail(array('POPUP',"order/surat_jalan/detail"));
		$this->newtable_edit->tipe_proses('button');
		$this->newtable_edit->hiddens(array("ID"));
		$this->newtable_edit->keys(array("ID"));
		$this->newtable_edit->validasi(array("ID"));
		$this->newtable_edit->cidb($this->db);
		$this->newtable_edit->orderby(1);
		$this->newtable_edit->sortby("DESC");
		$this->newtable_edit->set_formid("tblsuratjalan");
		$this->newtable_edit->set_divid("divtblsuratjalan");
		$this->newtable_edit->rowcount(10);
		$this->newtable_edit->clear();
		$this->newtable_edit->menu($proses);
		$tabel .= $this->newtable_edit->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
		echo $tabel;
		else
		return $arrdata;
	}

	function proses_print($type, $act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        if ($act == "cetakinvoice") {
            $data = array();
            $datadtl = array();
            $arrid = explode("~", $id);
           
   		    $SQL = "SELECT * FROM t_order_hdr A WHERE A.ID = " . $this->db->escape($arrid[1]);
            $hasil = $func->main->get_result($SQL);
            if ($hasil) {
                foreach ($SQL->result_array() as $row => $value) {
                    $data = $value;
                }
            }
            $arrid = explode('~', $id);
			
			$SQLDTL = "SELECT * FROM t_billing_hdr A WHERE A.ID = " . $this->db->escape($arrid[1]);
            $hasil = $func->main->get_result($SQLDTL);
            if ($hasil) {
                foreach ($SQLDTL->result_array() as $row => $value) {
                    $datadtl[] = $value;
                }
            }
            $returnArray = array('data' => $data,
                'datadtl' => $datadtl
            );
            return $returnArray;
        }
    }

    function input_manual($act, $id) {
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('VALIDASI PEMBAYARAN MANUAL', 'javascript:void(0)');
		$data['title'] = 'VALIDASI PEMBAYARAN MANUAL';
		$judul = "DATA VALIDASI PEMBAYARAN MANUAL";
		$addsql = '';
		$SQL = "SELECT A.ID,func_name(A.KD_GUDANG,'GUDANG') AS GUDANG, A.NO_CONT AS CONTAINER, 
			CONCAT('NOMOR : ',A.NO_NOTA,'<BR>TGL : ',A.TGL_NOTA) AS 'NOTA',
			A.NO_FAKTUR AS 'NOMOR FAKTUR', A.TOT_TAGIHAN AS 'TOTAL TAGIHAN',
			CONCAT('STATUS : ',A.STATUS,'<BR>TGL BAYAR : ',A.TGL_BAYAR,'<BR>BANK : ',A.NAMA_BANK) AS 'STATUS'
			FROM t_manual_payment A WHERE 1=1" . $addsql;
		$proses = array('DETAIL' => array('MODAL',"order/input_manual/detail", '1','','icon-pencil'),
						'PRINT' => array('PRINT', site_url() . "/order/proses_print/order/cetakinvoice", '1', '', 'icon-printer'));
		$check = (grant() == "W") ? true : false;
		$this->newtable_edit->show_chk(true);
		$this->newtable_edit->multiple_search(true);
		$this->newtable_edit->show_search(true);
		$this->newtable_edit->search(array(array('A.NO_NOTA','NO. PROFORMA INVOICE'),array('A.NO_FAKTUR','NO. BUKTI BAYAR')));
		$this->newtable_edit->action(site_url() . "/order/input_manual");
		$this->newtable_edit->detail(array('POPUP',"order/input_manual/detail"));
		$this->newtable_edit->tipe_proses('button');
		$this->newtable_edit->hiddens(array("ID"));
		$this->newtable_edit->keys(array("ID"));
		$this->newtable_edit->validasi(array("ID"));
		$this->newtable_edit->cidb($this->db);
		$this->newtable_edit->orderby(1);
		$this->newtable_edit->sortby("DESC");
		$this->newtable_edit->set_formid("tblvalidasi");
		$this->newtable_edit->set_divid("divtblvalidasi");
		$this->newtable_edit->rowcount(10);
		$this->newtable_edit->clear();
		$this->newtable_edit->menu($proses);
		$tabel .= $this->newtable_edit->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
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
		// for detail
		$arrdata = array();
        if ($type == "get") {
			if ($act == "sppb") {
				$SQL = "SELECT A.CAR, A.NO_ORDER,A.NO_SPPB, DATE_FORMAT(A.TGL_SPPB, '%d-%m-%y') as TGL_SPPB, A.NO_DO, DATE_FORMAT(A.TGL_DO, '%d-%m-%y') as TGL_DO, 
					A.KD_KPBC, DATE_FORMAT(A.TGL_EXPIRED_DO, '%d-%m-%y') as TGL_EXPIRED_DO, A.NAMA_FORWARDER, A.NO_CONT_ASAL, A.KODE_DOK,
					A.NPWP_CONSIGNEE, A.CONSIGNEE, A.NO_BL, A.NM_ANGKUT, A.KD_GUDANG_TUJUAN, A.STATUS, func_name(IFNULL(A.KODE_DOK,'-'),'DOK_BC') AS 'DOK_BC',
					func_name(IFNULL(KD_KPBC,'-'),'KPBC') AS 'NM_KPBC', func_name(IFNULL(A.NM_ANGKUT,'-'),'CALL_SIGN') AS 'CALL_SIGN',
					DATE_FORMAT(A.TGL_TIBA, '%d-%m-%y') as TGL_TIBA, DATE_FORMAT(A.TGL_STATUS, '%d-%m-%y') as TGL_STATUS,
					DATE_FORMAT(A.WK_REKAM, '%d-%m-%y') as WK_REKAM, func_name(IFNULL(KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'NM_GUDANG' 
					FROM t_order_hdr A WHERE A.ID = " . $this->db->escape($id);
				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					return $arrdata;
				} else {
					redirect(site_url(), 'refresh');
				}
			} else if ($act == "validasi_manual") {
				$SQL = "SELECT DATE_FORMAT(A.TGL_BAYAR, '%d-%m-%y') AS TGL_BAYAR
					FROM t_manual_payment A WHERE A.ID = " . $this->db->escape($id);
				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					return $arrdata;
				} else {
					redirect(site_url(), 'refresh');
				}
			} else if ($act == "surat_jalan") {
				$SQL = "SELECT A.NO_BL_AWB, A.NO_DOK_INOUT,A.CONSIGNEE, func_npwp(A.ID_CONSIGNEE) AS NPWP, 
					func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG, A.NO_BC11,A.TGL_BC11
					FROM t_permit_hdr A WHERE A.ID = " . $this->db->escape($id);
				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					return $arrdata;
				} else {
					redirect(site_url(), 'refresh');
				}
			}
        }else if ($type == "detail") {
			if($act == 't_billing_hdr'){
				$SQL = "SELECT * FROM t_billing_hdr A WHERE A.ID = " . $this->db->escape($id);
				// print_r($SQL);die();
				$result = $func->main->get_result($SQL);
				if ($result) {
				  foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
				  }
				  return $arrdata;
				}else {
				  redirect(site_url(), 'refresh');
				}
			}
		}elseif ($type == "save") {
			if($act == 'sppb'){
				$npwp1=str_replace("-","",$this->input->post('NPWP_IMP'));$npwp=str_replace(".","",$npwp1);
				$DATA= array(
				  'NO_ORDER'	=> 'KMS'.date('YmdHis'),
				  'CAR'			=> ($this->input->post('CAR') == '')?null:$this->input->post('CAR'),
				  'KD_KPBC'		=> trim(validate($this->input->post('KD_KPBC'))),
				  'KD_GUDANG_TUJUAN'	=> $this->input->post('KD_GUDANG'),
				  'NO_BL'		=> trim(validate($this->input->post('NO_BL'))),
				  'NO_DO'		=> trim(validate($this->input->post('NO_DO'))),
				  'TGL_DO'		=> validate(date_input($this->input->post('TGL_DO'))),
				  'TGL_EXPIRED_DO'	=> validate(date_input($this->input->post('TGL_EXPIRED_DO'))),
				  'NAMA_FORWARDER'	=> trim(validate($this->input->post('NAMA_FORWARDER'))),
				  'NO_CONT_ASAL'	=> trim(validate($this->input->post('NO_CONT_ASAL'))),
				  'KODE_DOK'	=> $this->input->post('JENIS_DOK_IZIN'),
				  'NO_SPPB'		=> trim(validate($this->input->post('NO_SPPB'))),
				  'TGL_SPPB'	=> validate(date_input($this->input->post('TGL_SPPB'))),
				  'NPWP_CONSIGNEE'	=> $npwp,
				  'CONSIGNEE'	=> trim(validate($this->input->post('NAMA_IMP'))),
				  'NM_ANGKUT'	=> trim(validate($this->input->post('NAMA_KAPAL'))),
				  'TGL_TIBA'	=> validate(date_input($this->input->post('TGL_TIBA'))),
				  'STATUS'		=> 'DRAFT',
				  'ID_USER'		=> $this->newsession->userdata('ID'),
				  'WK_REKAM'	=> date('Y-m-d H:i:s')
				);
				$result = $this->db->insert('t_order_hdr', $DATA);
				if ($result) {
						$func->main->get_log("add", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/ppbarang/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'clearing'){
				$npwp1=str_replace("-","",$this->input->post('NPWP_IMP'));$npwp=str_replace(".","",$npwp1);
				$DATA= array(
				  'NO_ORDER'	=> 'CONT'.date('YmdHis'),
				  'CAR'			=> ($this->input->post('CAR') == '')?null:$this->input->post('CAR'),
				  'KD_KPBC'		=> trim(validate($this->input->post('KD_KPBC'))),
				  'KD_GUDANG_TUJUAN'	=> $this->input->post('KD_GUDANG'),
				  'NO_BL'		=> trim(validate($this->input->post('NO_BL'))),
				  'NO_DO'		=> trim(validate($this->input->post('NO_DO'))),
				  'TGL_DO'		=> validate(date_input($this->input->post('TGL_DO'))),
				  'TGL_EXPIRED_DO'	=> validate(date_input($this->input->post('TGL_EXPIRED_DO'))),
				  'NAMA_FORWARDER'	=> trim(validate($this->input->post('NAMA_FORWARDER'))),
				  'NO_CONT_ASAL'	=> trim(validate($this->input->post('NO_CONT_ASAL'))),
				  'KODE_DOK'	=> $this->input->post('JENIS_DOK_IZIN'),
				  'NO_SPPB'		=> trim(validate($this->input->post('NO_SPPB'))),
				  'TGL_SPPB'	=> validate(date_input($this->input->post('TGL_SPPB'))),
				  'NPWP_CONSIGNEE'	=> $npwp,
				  'CONSIGNEE'	=> trim(validate($this->input->post('NAMA_IMP'))),
				  'NM_ANGKUT'	=> trim(validate($this->input->post('NAMA_KAPAL'))),
				  'TGL_TIBA'	=> validate(date_input($this->input->post('TGL_TIBA'))),
				  'STATUS'		=> 'DRAFT',
				  'ID_USER'		=> $this->newsession->userdata('ID'),
				  'WK_REKAM'	=> date('Y-m-d H:i:s')
				);
				$result = $this->db->insert('t_order_hdr', $DATA);
				if ($result) {
						$func->main->get_log("add", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/clearing/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}
		} else if ($type == "update") { 
			if($act == 'sppb'){
				$arrchk = explode("~", $id);
				$npwp1=str_replace("-","",$this->input->post('NPWP_IMP'));$npwp=str_replace(".","",$npwp1);
				$DATA= array(
				  'NO_ORDER'	=> 'KMS'.date('YmdHis'),
				  'CAR'			=> ($this->input->post('CAR') == '')?null:$this->input->post('CAR'),
				  'KD_KPBC'		=> trim(validate($this->input->post('KD_KPBC'))),
				  'KD_GUDANG_TUJUAN'	=> $this->input->post('KD_GUDANG'),
				  'NO_BL'		=> trim(validate($this->input->post('NO_BL'))),
				  'NO_DO'		=> trim(validate($this->input->post('NO_DO'))),
				  'TGL_DO'		=> validate(date_input($this->input->post('TGL_DO'))),
				  'TGL_EXPIRED_DO'	=> validate(date_input($this->input->post('TGL_EXPIRED_DO'))),
				  'NAMA_FORWARDER'	=> trim(validate($this->input->post('NAMA_FORWARDER'))),
				  'NO_CONT_ASAL'	=> trim(validate($this->input->post('NO_CONT_ASAL'))),
				  'KODE_DOK'	=> $this->input->post('JENIS_DOK_IZIN'),
				  'NO_SPPB'		=> trim(validate($this->input->post('NO_SPPB'))),
				  'TGL_SPPB'	=> validate(date_input($this->input->post('TGL_SPPB'))),
				  'NPWP_CONSIGNEE'	=> $npwp,
				  'CONSIGNEE'	=> trim(validate($this->input->post('NAMA_IMP'))),
				  'NM_ANGKUT'	=> trim(validate($this->input->post('NAMA_KAPAL'))),
				  'TGL_TIBA'	=> validate(date_input($this->input->post('TGL_TIBA'))),
				  'STATUS'		=> 'DRAFT',
				  'ID_USER'		=> $this->newsession->userdata('ID'),
				  'WK_REKAM'	=> date('Y-m-d H:i:s')
				);
                $this->db->where(array('ID' => $arrchk[1]));
                $result = $this->db->update('t_order_hdr', $DATA);
				if ($result) {
						$func->main->get_log("add", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/ppbarang/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'clearing'){
				$arrchk = explode("~", $id);
				$npwp1=str_replace("-","",$this->input->post('NPWP_IMP'));$npwp=str_replace(".","",$npwp1);
				$DATA= array(
				  'NO_ORDER'	=> 'CONT'.date('YmdHis'),
				  'CAR'			=> ($this->input->post('CAR') == '')?null:$this->input->post('CAR'),
				  'KD_KPBC'		=> trim(validate($this->input->post('KD_KPBC'))),
				  'KD_GUDANG_TUJUAN'	=> $this->input->post('KD_GUDANG'),
				  'NO_BL'		=> trim(validate($this->input->post('NO_BL'))),
				  'NO_DO'		=> trim(validate($this->input->post('NO_DO'))),
				  'TGL_DO'		=> validate(date_input($this->input->post('TGL_DO'))),
				  'TGL_EXPIRED_DO'	=> validate(date_input($this->input->post('TGL_EXPIRED_DO'))),
				  'NAMA_FORWARDER'	=> trim(validate($this->input->post('NAMA_FORWARDER'))),
				  'NO_CONT_ASAL'	=> trim(validate($this->input->post('NO_CONT_ASAL'))),
				  'KODE_DOK'	=> $this->input->post('JENIS_DOK_IZIN'),
				  'NO_SPPB'		=> trim(validate($this->input->post('NO_SPPB'))),
				  'TGL_SPPB'	=> validate(date_input($this->input->post('TGL_SPPB'))),
				  'NPWP_CONSIGNEE'	=> $npwp,
				  'CONSIGNEE'	=> trim(validate($this->input->post('NAMA_IMP'))),
				  'NM_ANGKUT'	=> trim(validate($this->input->post('NAMA_KAPAL'))),
				  'TGL_TIBA'	=> validate(date_input($this->input->post('TGL_TIBA'))),
				  'STATUS'		=> 'DRAFT',
				  'ID_USER'		=> $this->newsession->userdata('ID'),
				  'WK_REKAM'	=> date('Y-m-d H:i:s')
				);
                $this->db->where(array('ID' => $arrchk[1]));
                $result = $this->db->update('t_order_hdr', $DATA);
				if ($result) {
						$func->main->get_log("add", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/clearing/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}
		}else if ($type == "delete") {      
			if($act == 'sppb'){
				foreach ($this->input->post('tb_chktblppbarang') as $chkitem) {
					$arrchk = explode("~", $chkitem);
					$ID = $arrchk[1];
					$result = $this->db->delete('t_order_hdr', array('ID' => $ID));
					if (!$result) {
						$error += 1;
						$message .= "Could not be processed data";
					} 
				}
				if ($error == 0) {
				  $func->main->get_log("delete", "t_order_hdr");
				  echo "MSG#OK#Successfully to be processed#". site_url() . "/order/ppbarang/post";
				} else {
				  echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'clearing'){
				foreach ($this->input->post('tb_chktblclearing') as $chkitem) {
					$arrchk = explode("~", $chkitem);
					$ID = $arrchk[1];
					$result = $this->db->delete('t_order_hdr', array('ID' => $ID));
					if (!$result) {
						$error += 1;
						$message .= "Could not be processed data";
					} 
				}
				if ($error == 0) {
				  $func->main->get_log("delete", "t_order_hdr");
				  echo "MSG#OK#Successfully to be processed#". site_url() . "/order/clearing/post";
				} else {
				  echo "MSG#ERR#" . $message . "#";
				}
			}
		}
		// for detail
	}
}



