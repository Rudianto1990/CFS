<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_monitoring extends Model{

  function M_monitoring() {
     parent::Model();
  }

	function simkeu($act, $id){
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
		$sgudang="";
		if($TIPE_ORGANISASI == 'TPS2'){
			$addsql = " AND A.KD_GUDANG_TUJUAN = ".$this->db->escape($KD_GUDANG);
			$sgudang =$KD_GUDANG;
		}
		$SQL = "select a.ID,b.NO_INVOICE,b.TGL_TERIMA,c.CUSTOMER_NUMBER,b.NO_INVOICE as 'TRX NUMBER',c.CUSTOMER_NUMBER as 'ID CUSTOMER', d.BANK_ID AS 'ID BANK',
			DATE_FORMAT(b.TGL_TERIMA,'%d-%m-%Y %h:%i:%s') AS 'TANGGAL TRANSAKSI', 
			CONCAT( CASE a.STATUS_AR WHEN 'S' THEN '<h4><span class=\"label label-success\">SUCCESS</span></h4><br>' 
			WHEN 'F' THEN '<h4><span class=\"label label-danger\">FAILED</span></h4><br>' ELSE '-' END,
			IFNULL(a.MESSAGE_AR,'')) AS 'AR INVOICE',
			CONCAT( CASE a.STATUS_RECEIPT WHEN 'S' THEN '<h4><span class=\"label label-success\">SUCCESS</span></h4><br>' 
			WHEN 'F' THEN '<h4><span class=\"label label-danger\">FAILED</span></h4><br>' ELSE '-' END,
			IFNULL(a.MESSAGE_RECEIPT,'')) AS 'RECEIPT',
			CONCAT( CASE a.STATUS_AP WHEN 'S' THEN '<h4><span class=\"label label-success\">SUCCESS</span></h4><br>' 
			WHEN 'F' THEN '<h4><span class=\"label label-danger\">FAILED</span></h4><br>' ELSE '-' END,
			IFNULL(a.MESSAGE_AP,'')) AS 'AP'
			from t_billing_cfshdr a 
			join t_edc_payment_bank b on a.NO_ORDER=b.NO_ORDER 
			join t_order_hdr c on a.NO_ORDER=c.NO_ORDER and a.FLAG_APPROVE='Y' and a.KD_ALASAN_BILLING='ACCEPT'
			join mst_bank_account_simkeu d on b.BANK=d.BANK_NAME and d.`TYPE`='P'
			where a.STATUS_AR='F' or a.STATUS_RECEIPT='F' or a.STATUS_AP in ('F','X')";
		$proses = array(
			'ENTRY'	 => array('MODAL',"/order/ppbarang/add", '0','','icon-plus', '', 'menu'),
			'UPDATE' => array('MODAL',"/order/ppbarang/edit", '1','100','icon-refresh', '', 'list'),
			'DELETE' => array('DELETE', site_url() . "/order/execute/delete/sppb", 'ALL', '100', 'icon-trash', '', 'menu'),
			'VIEW' => array('MODAL',"order/ppbarang/detail", '1','','icon-pencil', '', 'list'),
			'KIRIM' => array('MODAL', "order/ppbarang/kirim", '1', '100', 'icon-share-alt', '', 'list')
		);
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG",$sgudang);
    	$arrnamaTPS = $this->get_comboboxnamagudang("TPS");
    	$arrnamaStatus = $this->get_comboboxnamagudang("ENTRY");
    	if($TIPE_ORGANISASI=="SPA" || $TIPE_ORGANISASI=="PCFS"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('A.CONSIGNEE','NAMA PEMILIK'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.STATUS', 'STATUS', 'OPTION', $arrnamaStatus)));
    	}else{
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER')));
    	}
		$this->newtable->action(site_url() . "/order/ppbarang");
		//$this->newtable->detail(array('POPUP',"order/ppbarang/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses2('button');
		$this->newtable->hiddens(array("CAR","ID","KD_STATUS","WK_REKAM"));
		$this->newtable->keys(array("NO ORDER","ID"));
		$this->newtable->cidb($this->db);
        $this->newtable->validasi(array("KD_STATUS"));
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
				$SQL = "SELECT 
					A.NO_ORDER,A.NO_SPPB, DATE_FORMAT(A.TGL_SPPB, '%d-%m-%Y') as TGL_SPPB, A.ALAMAT_CONSIGNEE,
					DATE_FORMAT(A.TGL_DO, '%d-%m-%Y') as TGL_DO, DATE_FORMAT(A.TGL_STRIPPING, '%d-%m-%Y') as TGL_STRIPPING_B,
					A.JENIS_BAYAR, (case when (D.NO_INVOICE is not null) THEN '200' ELSE '100' END) as INVOICE,A.JENIS_TRANSAKSI,
					(CASE WHEN A.JENIS_BAYAR = 'A' THEN 'CASH' ELSE 'KREDIT' END) AS 'JENIS_PEMBAYARAN',A.TGL_STRIPPING, 
					A.KD_KPBC, DATE_FORMAT(A.TGL_EXPIRED_DO, '%d-%m-%Y') as TGL_EXPIRED_DO, A.NAMA_FORWARDER, A.NO_CONT_ASAL, 
					A.KODE_DOK,A.NO_DO,A.KD_STATUS,DATE_FORMAT(A.TGL_KELUAR_LAMA,'%d-%m-%Y') AS TGL_KELUAR_LAMA,
					A.NPWP_FORWARDER,A.ALAMAT_FORWARDER, B.NO_POLISI_TRUCK,func_name(IFNULL(A.KODE_DOK,'-'),'DOK_BC') AS 'DOK_BC', 
					A.NPWP_CONSIGNEE, A.CONSIGNEE, A.NO_BL_AWB, A.NM_ANGKUT, A.KD_GUDANG_TUJUAN, 
					A.CAR, DATE_FORMAT(A.TGL_KELUAR,'%d-%m-%Y') AS TGL_KELUAR, func_name(IFNULL(KD_KPBC,'-'),'KPBC') AS 'NM_KPBC', 
					func_name(IFNULL(A.NM_ANGKUT,'-'),'CALLSIGN') AS 'CALL_SIGN',DATE_FORMAT(A.TGL_TIBA, '%d-%m-%Y') as TGL_TIBA, 
					DATE_FORMAT(A.TGL_STATUS, '%d-%m-%Y') as TGL_STATUS, DATE_FORMAT(A.WK_REKAM, '%d-%m-%Y') as WK_REKAM, 
					func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'NM_GUDANG',A.NO_VOYAGE,A.CUSTOMER_NUMBER,
					A.NO_MASTER_BL_AWB,A.TGL_MASTER_BL_AWB,A.TGL_BL_AWB,A.NO_BC11,A.TGL_BC11
					FROM t_order_hdr A LEFT JOIN t_order_kms B ON B.ID=A.ID LEFT JOIN t_billing_cfshdr D on A.NO_ORDER=D.NO_ORDER
					WHERE A.ID = " . $this->db->escape($id);
					//DATE_FORMAT(C.WK_IN, '%d-%m-%y %H:%i:%s') as WK_IN,  join t_cocostscont C on C.NO_CONT=A.NO_CONT_ASAL
				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					return $arrdata;
				} else {
					redirect(site_url(), 'refresh');
				}
			} else if ($act == "clearing") {
				$SQL = "SELECT A.NO_PERMOHONAN_CFS, A.JENIS_BAYAR, (CASE WHEN A.JENIS_BAYAR = 'A' THEN 'CASH' ELSE 'KREDIT' END) AS 'JENIS_PEMBAYARAN', DATE_FORMAT(A.TGL_KELUAR,'%d-%m-%Y') AS TGL_KELUAR, A.NO_BL_AWB,
				A.NO_ORDER, A.NAMA_FORWARDER,func_npwp(A.NPWP_FORWARDER) as NPWP_FORWARDER,A.ALAMAT_FORWARDER, A.NAMA_AGEN,
				A.NM_ANGKUT, func_name(IFNULL(A.NM_ANGKUT,'-'),'CALL_SIGN') AS 'CALL_SIGN',A.NO_VOYAGE, A.CONSIGNEE,
				DATE_FORMAT(A.TGL_TIBA, '%d-%m-%y') as TGL_TIBA, A.NO_BC11, DATE_FORMAT(A.TGL_BC11, '%d-%m-%y') as TGL_BC11,
				A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_ASAL, A.KD_GUDANG_TUJUAN, 
				(case when (D.NO_INVOICE is not null) THEN '200' ELSE '100' END) as INVOICE,
				func_name(IFNULL(A.KD_GUDANG_ASAL,'-'),'GUDANG') AS 'GUDANGASAL', func_npwp(A.NPWP_CONSIGNEE) as NPWP_CONSIGNEE,
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'GUDANGTUJUAN',
				A.KD_STATUS,  DATE_FORMAT(A.TGL_STATUS, '%d-%m-%y') as TGL_STATUS, 
				DATE_FORMAT(A.WK_REKAM, '%d-%m-%y') as WK_REKAM, B.NO_SP2
				FROM t_order_hdr A left JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER 
				LEFT JOIN t_billing_cfshdr D on A.NO_ORDER=D.NO_ORDER WHERE A.ID = " . $this->db->escape($id);
				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					return $arrdata;
				} else {
					redirect(site_url(), 'refresh');
				}
			} else if ($act == "t_order_cont") {
				$SQL = "SELECT NO_CONT,KD_CONT_UKURAN,NO_POLISI_TRUCK,
					CONCAT(NO_CONT,'~',KD_CONT_UKURAN,'~',NO_POLISI_TRUCK) AS TB_CHK
					FROM t_order_cont
					WHERE ID = " . $this->db->escape($id);
				$query = $this->db->query($SQL);
				if ($query->num_rows() > 0){
					return $query->result();
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
				$SQL = "select A.NO_ORDER, B.NO_SP2, func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG, A.NM_ANGKUT, A.NO_VOYAGE,
					DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, C.NO_POLISI_TRUCK, A.NO_BL_AWB, A.NO_DO, 
					A.CONSIGNEE, A.ALAMAT_CONSIGNEE, DATE_FORMAT(A.TGL_KELUAR,'%d-%m-%Y') AS TGL_KELUAR
					from t_order_hdr A JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER 
					JOIN t_order_kms C ON C.ID=A.ID where A.NO_ORDER=" . $this->db->escape($id);
				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					return $arrdata;
				} else {
					redirect(site_url(), 'refresh');
				}
			} else if ($act == "tarif_dasar") {
				$SQL = "SELECT * FROM reff_billing_cfs A WHERE A.ID = " . $this->db->escape($id);
				$result = $func->main->get_result($SQL);
				if ($result) {
					foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}
					return $arrdata;
				} else {
					redirect(site_url(), 'refresh');
				}
			} else if ($act == "pbm") {
				$SQL = "SELECT A.ID, func_npwp(A.NPWP) as NPWP, A.NAMA, A.ALAMAT, A.NOTELP, A.NOFAX, A.EMAIL, A.JENIS_ORGANISASI
						FROM t_organisasi A WHERE A.ID = " . $this->db->escape($id);
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
				$SQL = "SELECT * FROM t_billing_cfshdr A WHERE A.NO_ORDER = " . $this->db->escape($id);
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
			if($act == 'tes'){
				print_r($_FILES);
				print_r($_POST);
			}
			if($act == 'sppb'){
				//$npwp1=str_replace("-","",$this->input->post('NPWP_CONSIGNEE'));$npwp=str_replace(".","",$npwp1);
				//$npwpf1=str_replace("-","",$this->input->post('NPWP_FORWARDER'));$npwp_forwarder=str_replace(".","",$npwpf1);
				$kod=($this->input->post('KD_GUDANG_TUJUAN')=='BAND')?'02':'01';
				$check = $this->db->query("select max(A.NO_ORDER) as 'ORDER' from t_order_hdr A where A.NO_ORDER like '10".$kod.date('Ymd')."%'");
				$resulte = $check->row_array();
				if($resulte['ORDER']!=""){
					$urut = (int) substr($resulte['ORDER'], 12);
					$urut++;
					$urut = sprintf("%03s", $urut);
					$NO_ORDER='10'.$kod.date('Ymd').$urut;
				}else{
					$NO_ORDER='10'.$kod.date('Ymd').'001';
				}
				$DATA= array(
				  'NO_ORDER'			=> $NO_ORDER,
				  'JENIS_BILLING'		=> '2',
				  'JENIS_TRANSAKSI'		=> $this->input->post('JENIS_TRANSAKSI'),
				  'TGL_KELUAR_LAMA'		=> ($this->input->post('TGL_KELUAR_LAMA') == '')?null:validate(date_input($this->input->post('TGL_KELUAR_LAMA'))),
				  'TGL_KELUAR'			=> validate(date_input($this->input->post('TGL_KELUAR'))),
				  'NO_MASTER_BL_AWB'	=> ($this->input->post('NO_MASTER_BL_AWB') == '')?null:$this->input->post('NO_MASTER_BL_AWB'),
				  'TGL_MASTER_BL_AWB'	=> ($this->input->post('TGL_MASTER_BL_AWB') == '')?null:$this->input->post('TGL_MASTER_BL_AWB'),
				  'NO_BL_AWB'			=> trim(validate($this->input->post('NO_BL_AWB'))),
				  'TGL_BL_AWB'			=> ($this->input->post('TGL_BL_AWB') == '')?null:$this->input->post('TGL_BL_AWB'),
				  'TGL_STRIPPING'		=> ($this->input->post('TGL_STRIPPING') == '')?null:validate(date_input($this->input->post('TGL_STRIPPING'))),
				  'NO_DO'				=> ($this->input->post('NO_DO') == '')?null:trim(validate($this->input->post('NO_DO'))),
				  'TGL_DO'				=> ($this->input->post('TGL_DO') == '')?null:validate(date_input($this->input->post('TGL_DO'))),
				  'TGL_EXPIRED_DO'		=> ($this->input->post('TGL_EXPIRED_DO') == '')?null:validate(date_input($this->input->post('TGL_EXPIRED_DO'))),
				  'CUSTOMER_NUMBER'		=> ($this->input->post('CUSTOMER_NUMBER') == '')?null:trim(validate($this->input->post('CUSTOMER_NUMBER'))),
				  'NAMA_FORWARDER'		=> ($this->input->post('NAMA_FORWARDER') == '')?null:trim(validate($this->input->post('NAMA_FORWARDER'))),
				  'NPWP_FORWARDER'		=> ($this->input->post('NPWP_FORWARDER') == '')?null:$this->input->post('NPWP_FORWARDER'),
				  'ALAMAT_FORWARDER'	=> ($this->input->post('ALAMAT_FORWARDER') == '')?null:trim(validate($this->input->post('ALAMAT_FORWARDER'))),
				  'CONSIGNEE'			=> ($this->input->post('CONSIGNEE') == '')?null:trim(validate($this->input->post('CONSIGNEE'))),
				  'NPWP_CONSIGNEE'		=> ($this->input->post('NPWP_CONSIGNEE') == '')?null:$this->input->post('NPWP_CONSIGNEE'),
				  'ALAMAT_CONSIGNEE'	=> ($this->input->post('ALAMAT_CONSIGNEE') == '')?null:$this->input->post('ALAMAT_CONSIGNEE'),
				  'KD_GUDANG_TUJUAN'	=> $this->input->post('KD_GUDANG_TUJUAN'),
				  'NO_BC11'				=> ($this->input->post('NO_BC11') == '')?null:$this->input->post('NO_BC11'),
				  'TGL_BC11'			=> ($this->input->post('TGL_BC11') == '')?null:$this->input->post('TGL_BC11'),
				  'NO_CONT_ASAL'		=> trim(validate($this->input->post('NO_CONT_ASAL'))),
				  'NM_ANGKUT'			=> trim(validate($this->input->post('NAMA_KAPAL'))),
				  'NO_VOYAGE'			=> trim(validate($this->input->post('NO_VOY_FLIGHT'))),
				  'TGL_TIBA'			=> validate(date_input($this->input->post('TGL_TIBA'))),
				  'CAR'					=> ($this->input->post('CAR') == '')?null:$this->input->post('CAR'),
				  'KD_KPBC'				=> trim(validate($this->input->post('KD_KPBC'))),
				  'KODE_DOK'			=> $this->input->post('JENIS_DOK_IZIN'),
				  'NO_SPPB'				=> trim(validate($this->input->post('NO_SPPB'))),
				  'TGL_SPPB'			=> validate(date_input($this->input->post('TGL_SPPB'))),
				  'KD_STATUS'			=> '100',
				  'TGL_STATUS'			=> NULL,
				  'ID_USER'				=> $this->newsession->userdata('ID'),
				  'WK_REKAM'			=> date('Y-m-d H:i:s'),
				  'JENIS_BAYAR'			=> 'A' //trim(validate($this->input->post('JENIS_BAYAR')))
				);
				if ($DATA['TGL_DO']!=null) {
					if ($DATA['TGL_KELUAR'] < $DATA['TGL_DO']) {
						$error += 1;
						$message .= "Tanggal keluar tidak boleh kurang dari tanggal DO";
					} else if ($DATA['TGL_KELUAR'] > $DATA['TGL_EXPIRED_DO']) {
						$error += 1;
						$message .= "Tanggal keluar tidak boleh melebihi dari tanggal expired DO";
					}
				}
				if ($DATA['CUSTOMER_NUMBER']==null) {
					$check = $this->db->query("select A.CUSTOMER_ID from mst_customer A WHERE A.NPWP='".$DATA['NPWP_CONSIGNEE']."'");
					$resulte = $check->row_array();
					if($resulte['CUSTOMER_ID']==""){
						$error += 1;
						$message .= "Consignee belum terdaftar di sistem CDM. Silahkan daftarkan melalui CS Cabang Tanjung Priok.";
					}else{
						$DATA['CUSTOMER_NUMBER']=$resulte['CUSTOMER_ID'];
					}
				}
				if ($error < 1) {
					$check = $this->db->query("select A.TGL_KELUAR from t_order_hdr A WHERE A.NO_BL_AWB='".$DATA['NO_BL_AWB']."' AND A.TGL_BL_AWB='".$DATA['TGL_BL_AWB']."' order by A.ID desc limit 1");
					$resulte = $check->row_array();
					if($resulte['TGL_KELUAR']!=""){
						$DATA['TGL_KELUAR_LAMA']=$resulte['TGL_KELUAR'];
						$DATA['JENIS_TRANSAKSI']='P';
					}else{
						$DATA['TGL_KELUAR_LAMA']=null;
						$DATA['JENIS_TRANSAKSI']='B';
					}
					$result = $this->db->insert('t_order_hdr', $DATA);
					$id_permit = $this->db->insert_id();
					$DATA['TGL_BL_AWB']= ($DATA['TGL_BL_AWB']==null)?"null":"'".$DATA['TGL_BL_AWB']."'";
					$check = $this->db->query("select B.* from t_permit_hdr A LEFT JOIN t_permit_kms B on B.ID=A.ID WHERE A.NO_BL_AWB='".$DATA['NO_BL_AWB']."' AND A.TGL_BL_AWB=".$DATA['TGL_BL_AWB']."");
					$resulte = $check->result_array();
					foreach($resulte as $result){
						$this->db->set('ID', $id_permit); 
						$this->db->set('JNS_KMS', $result['JNS_KMS']); 
						$this->db->set('MERK_KMS', $result['MERK_KMS']); 
						$this->db->set('JML_KMS', $result['JML_KMS']); 
						$this->db->set('NO_POLISI_TRUCK', ($this->input->post('NO_POLISI_TRUCK') == '')?null:trim(validate($this->input->post('NO_POLISI_TRUCK')))); 
						$run3 = $this->db->insert('t_order_kms'); 
					}
				}
				if ($result) {
						$func->main->get_log("add", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/ppbarang/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'edc'){
				$NO_ORDER = trim(validate($this->input->post('NO_ORDER')));
				$SQL = $this->db->query("SELECT A.ID AS ID, A.TOTAL AS TOTAL, A.NO_PROFORMA_INVOICE AS NO_PROFORMA_INVOICE FROM t_billing_cfshdr A WHERE A.NO_ORDER = '". $NO_ORDER ."'");
				$result = $func->main->get_result($SQL);
				foreach ($SQL->result_array() as $row => $value) {
					$arrdata = $value;
				}
				$IDbef = $arrdata['ID']-1;
				$SQL1 = $this->db->query("SELECT substr(A.NO_INVOICE, 15) AS NO_INVOICE FROM t_edc_payment_bank A WHERE A.ID = (SELECT MAX(ID) FROM t_edc_payment_bank)");
				$result = $func->main->get_result($SQL1);
				foreach ($SQL1->result_array() as $row => $value) {
					$arrdata1 = $value;
				}
				$layananpro = substr($arrdata['NO_PROFORMA_INVOICE'], 0,1);


				$faktur = '010.010';
			    $years = date('y');
			    $nolayanan = '23';
			    /* if($layananpro == '01'){
			    	$nolayanan = '36';
			    }elseif ($layananpro == '01') {
			    	$nolayanan = '37';
			    } */
			    $invbef = $arrdata1['NO_INVOICE'];
			    $invnew = $invbef+1;
			   

			    if($invnew<=9){
			        $inv = '00000';
			    }elseif(99>=$invnew && $invnew>9){
			        $inv = '0000';
			    }elseif(999>=$invnew && $invnew>99){
			        $inv = '000';
			    }elseif(9999>=$invnew && $invnew>999){
			        $inv = '00';
			    }elseif(99999>=$invnew && $invnew>9999){
			        $inv = '0';
			    }elseif(999999>=$invnew && $invnew>99999){
			        $inv = '';
			    }

			    $invurut = $inv.$invnew;

			    $NOINV = $faktur.'-'.$years.'.'.$nolayanan.'.'.$invurut;

				$DATA= array(
				  'BUNDLED_INVOICE_KEY'		=> ($this->input->post('BUNDLED_INVOICE_KEY') == '')?null:trim(validate($this->input->post('BUNDLED_INVOICE_KEY'))),
				  'BANK'		=> trim(validate($this->input->post('BANK'))),
				  'NO_ORDER'		=> trim(validate($this->input->post('NO_ORDER'))),
				  'NAMA_PEMILIK'		=> trim(validate($this->input->post('NAMA_PEMILIK'))),
				  'NPWP_PEMILIK'		=> trim(validate($this->input->post('NPWP_PEMILIK'))),
				  'AMOUNT'		=> $arrdata['TOTAL'],//ini  
				  'TGL_TERIMA'		=> date('Y-m-d H:i:s'),
				  'REFF_NO'		=> ($this->input->post('REFF_NO') == '')?null:trim(validate($this->input->post('REFF_NO'))),
				  'TRACE_NO'		=> ($this->input->post('TRACE_NO') == '')?null:trim(validate($this->input->post('TRACE_NO'))),
				  'APPR_CODE'		=> ($this->input->post('APPROVAL_CODE') == '')?null:trim(validate($this->input->post('APPROVAL_CODE'))),
				  'NO_PROFORMA_INVOICE'		=> $arrdata['NO_PROFORMA_INVOICE'],
				  // 'NO_INVOICE'		=> '000.000-17.'.substr(trim(validate($this->input->post('NO_ORDER'))), 12)
				  'NO_INVOICE'		=> $NOINV  
				);
				$DATAUPDATE= array(
				  'STATUS_BAYAR'		=> 'SETTLED', 
				  // 'NO_INVOICE'		=> '000.000-17.'.substr(trim(validate($this->input->post('NO_ORDER'))), 12),
				  'NO_INVOICE'		=> $NOINV,
				  'NO_SP2'		=> 'SP'.substr(trim(validate($this->input->post('NO_ORDER'))), 12)  
				);
				// print_r($DATA);die();
				$result1 = $this->db->insert('t_edc_payment_bank', $DATA);

				if ($result1) {
						$this->db->where(array('NO_ORDER' => trim(validate($this->input->post('NO_ORDER')))));
						$result2 = $this->db->update('t_billing_cfshdr', $DATAUPDATE);
						$func->main->get_log("add", "t_edc_payment_bank");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/input_manual/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'clearing'){
				$npwp1=str_replace("-","",$this->input->post('NPWP_CONSIGNEE'));$npwp=str_replace(".","",$npwp1);
				$npwpf1=str_replace("-","",$this->input->post('NPWP_FORWARDER'));$npwp_forwarder=str_replace(".","",$npwpf1);
				$DATA= array(
				  'NO_ORDER'	=> 'CONT'.date('YmdHis'),
				  'JENIS_BILLING'		=> '1',
				  'TGL_KELUAR'			=> validate(date_input($this->input->post('TGL_KELUAR'))),
				  'NAMA_AGEN'			=> ($this->input->post('NAMA_AGEN') == '')?null:trim(validate($this->input->post('NAMA_AGEN'))),
				  'NO_PERMOHONAN_CFS'	=> ($this->input->post('NO_PERMOHONAN_CFS') == '')?null:trim(validate($this->input->post('NO_PERMOHONAN_CFS'))),
				  'NO_BL_AWB'			=> trim(validate($this->input->post('NO_BL_AWB'))),
				  'NAMA_FORWARDER'		=> ($this->input->post('NAMA_FORWARDER') == '')?null:trim(validate($this->input->post('NAMA_FORWARDER'))),
				  'NPWP_FORWARDER'		=> ($this->input->post('NPWP_FORWARDER') == '')?null:$npwp_forwarder,
				  'ALAMAT_FORWARDER'	=> ($this->input->post('ALAMAT_FORWARDER') == '')?null:trim(validate($this->input->post('ALAMAT_FORWARDER'))),
				  'CONSIGNEE'			=> ($this->input->post('NAMA_CONSIGNEE') == '')?null:trim(validate($this->input->post('NAMA_CONSIGNEE'))),
				  'NPWP_CONSIGNEE'		=> ($this->input->post('NPWP_CONSIGNEE') == '')?null:$npwp,
				  'ALAMAT_CONSIGNEE'	=> ($this->input->post('ALAMAT_CONSIGNEE') == '')?null:trim(validate($this->input->post('ALAMAT_CONSIGNEE'))),
				  'KD_TPS_ASAL'			=> $this->input->post('TPS_ASAL'),
				  'KD_TPS_TUJUAN'		=> $this->input->post('TPS_TUJUAN'),
				  'KD_GUDANG_ASAL'		=> $this->input->post('GUDANG_ASAL'),
				  'KD_GUDANG_TUJUAN'	=> $this->input->post('GUDANG_TUJUAN'),
				  'NO_BC11'				=> trim(validate($this->input->post('NO_BC11'))),
				  'TGL_BC11'			=> validate(date_input($this->input->post('TGL_BC11'))),
				  'NM_ANGKUT'			=> trim(validate($this->input->post('NAMA_KAPAL'))),
				  'NO_VOYAGE'			=> trim(validate($this->input->post('NO_VOY_FLIGHT'))),
				  'TGL_TIBA'			=> validate(date_input($this->input->post('TGL_TIBA'))),
				  'KD_STATUS'			=> '100',
				  'TGL_STATUS'			=> NULL,
				  'ID_USER'				=> $this->newsession->userdata('ID'),
				  'WK_REKAM'			=> date('Y-m-d H:i:s'),
				  'JENIS_BAYAR'			=> trim(validate($this->input->post('JENIS_BAYAR')))
				);
				$result = $this->db->insert('t_order_hdr', $DATA);
				$ID_CFS = $this->db->insert_id();
				$CONTE = $this->input->post('tb_chktblconte');
				$total = count($CONTE);
				$DATA_C = array();
				for ($x=0;$x<$total;$x++) {
					$CONTEs = explode('~',$CONTE[$x]);
					$this->db->set('ID', $ID_CFS);
					$this->db->set('NO_CONT', trim(validate($CONTEs[0]))); 
					$this->db->set('KD_CONT_UKURAN', $CONTEs[1]); 
					$this->db->set('NO_POLISI_TRUCK', trim(validate($CONTEs[2]))); 
					$run2 = $this->db->insert('t_order_cont'); 
				}
				if ($result) {
						$func->main->get_log("add", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/clearing/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'tarif_dasar'){
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
				$result = $this->db->insert('reff_billing_cfs', $DATA);
				if ($result) {
						$func->main->get_log("add", "reff_billing_cfs");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/tarif_dasar/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
            } else if ($act == "pbm") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "") {
                        $DATA[$a] = NULL;
                    } else {
						if ($a=="NPWP"){
							$b=str_replace(".","",str_replace("-","",$b));
						}
                        $DATA[$a] = $b;
					}
                }
                $result = $this->db->insert('t_organisasi', $DATA);
                if ($result) {
                    $func->main->get_log("add", "t_organisasi");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/pbm/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
		} else if ($type == "update") { 
			if($act == 'sppb'){
				$arrchk = explode("~", $id);
				//$npwp1=str_replace("-","",$this->input->post('NPWP_CONSIGNEE'));$npwp=str_replace(".","",$npwp1);
				//$npwpf1=str_replace("-","",$this->input->post('NPWP_FORWARDER'));$npwp_forwarder=str_replace(".","",$npwpf1);
				$DATA= array(
				  'TGL_KELUAR'			=> validate(date_input($this->input->post('TGL_KELUAR'))),
				  'NO_MASTER_BL_AWB'	=> ($this->input->post('NO_MASTER_BL_AWB') == '')?null:$this->input->post('NO_MASTER_BL_AWB'),
				  'TGL_MASTER_BL_AWB'	=> ($this->input->post('TGL_MASTER_BL_AWB') == '')?null:$this->input->post('TGL_MASTER_BL_AWB'),
				  'NO_BL_AWB'			=> trim(validate($this->input->post('NO_BL_AWB'))),
				  'TGL_BL_AWB'			=> ($this->input->post('TGL_BL_AWB') == '')?null:$this->input->post('TGL_BL_AWB'),
				  'TGL_STRIPPING'		=> ($this->input->post('TGL_STRIPPING') == '')?null:validate(date_input($this->input->post('TGL_STRIPPING'))),
				  'NO_DO'				=> ($this->input->post('NO_DO') == '')?null:trim(validate($this->input->post('NO_DO'))),
				  'TGL_DO'				=> ($this->input->post('TGL_DO') == '')?null:validate(date_input($this->input->post('TGL_DO'))),
				  'TGL_EXPIRED_DO'		=> ($this->input->post('TGL_EXPIRED_DO') == '')?null:validate(date_input($this->input->post('TGL_EXPIRED_DO'))),
				  'CUSTOMER_NUMBER'		=> ($this->input->post('CUSTOMER_NUMBER') == '')?null:trim(validate($this->input->post('CUSTOMER_NUMBER'))),
				  'NAMA_FORWARDER'		=> ($this->input->post('NAMA_FORWARDER') == '')?null:trim(validate($this->input->post('NAMA_FORWARDER'))),
				  'NPWP_FORWARDER'		=> ($this->input->post('NPWP_FORWARDER') == '')?null:$this->input->post('NPWP_FORWARDER'),
				  'ALAMAT_FORWARDER'	=> ($this->input->post('ALAMAT_FORWARDER') == '')?null:trim(validate($this->input->post('ALAMAT_FORWARDER'))),
				  'CONSIGNEE'			=> ($this->input->post('CONSIGNEE') == '')?null:trim(validate($this->input->post('CONSIGNEE'))),
				  'NPWP_CONSIGNEE'		=> ($this->input->post('NPWP_CONSIGNEE') == '')?null:$this->input->post('NPWP_CONSIGNEE'),
				  'ALAMAT_CONSIGNEE'	=> ($this->input->post('ALAMAT_CONSIGNEE') == '')?null:$this->input->post('ALAMAT_CONSIGNEE'),
				  'KD_GUDANG_TUJUAN'	=> $this->input->post('KD_GUDANG_TUJUAN'),
				  'NO_BC11'				=> ($this->input->post('NO_BC11') == '')?null:$this->input->post('NO_BC11'),
				  'TGL_BC11'			=> ($this->input->post('TGL_BC11') == '')?null:$this->input->post('TGL_BC11'),
				  'NO_CONT_ASAL'		=> trim(validate($this->input->post('NO_CONT_ASAL'))),
				  'NM_ANGKUT'			=> trim(validate($this->input->post('NAMA_KAPAL'))),
				  'NO_VOYAGE'			=> trim(validate($this->input->post('NO_VOY_FLIGHT'))),
				  'TGL_TIBA'			=> validate(date_input($this->input->post('TGL_TIBA'))),
				  'CAR'					=> ($this->input->post('CAR') == '')?null:$this->input->post('CAR'),
				  'KD_KPBC'				=> trim(validate($this->input->post('KD_KPBC'))),
				  'KODE_DOK'			=> $this->input->post('JENIS_DOK_IZIN'),
				  'NO_SPPB'				=> trim(validate($this->input->post('NO_SPPB'))),
				  'TGL_SPPB'			=> validate(date_input($this->input->post('TGL_SPPB'))),
				  'ID_USER'				=> $this->newsession->userdata('ID'),
				  'WK_REKAM'			=> date('Y-m-d H:i:s'),
				  'JENIS_BAYAR'			=> 'A' //trim(validate($this->input->post('JENIS_BAYAR')))
				);
				if($DATA['NO_BL_AWB']!=trim(validate($this->input->post('NO_BL_AWB1')))){
					$check = $this->db->query("select A.TGL_KELUAR from t_order_hdr A WHERE A.NO_BL_AWB='".$DATA['NO_BL_AWB']."' AND A.TGL_BL_AWB='".$DATA['TGL_BL_AWB']."' order by A.ID desc limit 1");
					$resulte = $check->row_array();
					if($resulte['TGL_KELUAR']!=""){
						$DATA['TGL_KELUAR_LAMA']=$resulte['TGL_KELUAR'];
						$DATA['JENIS_TRANSAKSI']='P';
					}else{
						$DATA['TGL_KELUAR_LAMA']=null;
						$DATA['JENIS_TRANSAKSI']='B';
					}
				}
				if ($DATA['NPWP_FORWARDER']==null) {
					$check = $this->db->query("select A.CUSTOMER_ID from mst_customer A WHERE A.NPWP='".$DATA['NPWP_CONSIGNEE']."'");
					$resulte = $check->row_array();
					if($resulte['CUSTOMER_ID']==""){
						$error += 1;
						$message .= "Consignee belum terdaftar di sistem CDM. Silahkan daftarkan melalui CS Cabang Tanjung Priok.";
					}else{
						$DATA['CUSTOMER_NUMBER']=$resulte['CUSTOMER_ID'];
					}
				}
				if ($error < 1) {
					$this->db->where(array('ID' => $arrchk[1]));
					$result = $this->db->update('t_order_hdr', $DATA);
					$id_permit = $arrchk[1];
					$HAPUS = $this->db->delete('t_order_kms', array('ID' => $id_permit));
					if ($HAPUS == false) {
						$error += 1;
						$message .= "Could not be processed data";
					} else {
						$DATA['TGL_BL_AWB'] = ($DATA['TGL_BL_AWB']==null)?"null":"'".$DATA['TGL_BL_AWB']."'";
						$check = $this->db->query("select B.* from t_permit_hdr A LEFT JOIN t_permit_kms B on B.ID=A.ID WHERE A.NO_BL_AWB='".$DATA['NO_BL_AWB']."' AND A.TGL_BL_AWB=".$DATA['TGL_BL_AWB']."");
						$resulte = $check->result_array();
						foreach($resulte as $result){
							$this->db->set('ID', $id_permit); 
							$this->db->set('JNS_KMS', $result['JNS_KMS']); 
							$this->db->set('MERK_KMS', $result['MERK_KMS']); 
							$this->db->set('JML_KMS', $result['JML_KMS']); 
							$this->db->set('NO_POLISI_TRUCK', ($this->input->post('NO_POLISI_TRUCK') == '')?null:trim(validate($this->input->post('NO_POLISI_TRUCK')))); 
							$run3 = $this->db->insert('t_order_kms'); 
						}
					}
				}
				if ($result) {
						$func->main->get_log("add", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/ppbarang/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'clearing'){
				$arrchk = explode("~", $id);
				$npwp1=str_replace("-","",$this->input->post('NPWP_CONSIGNEE'));$npwp=str_replace(".","",$npwp1);
				$npwpf1=str_replace("-","",$this->input->post('NPWP_FORWARDER'));$npwp_forwarder=str_replace(".","",$npwpf1);
				$DATA= array(
				  'NO_ORDER'	=> 'CONT'.date('YmdHis'),
				  'JENIS_BILLING'		=> '1',
				  'TGL_KELUAR'			=> validate(date_input($this->input->post('TGL_KELUAR'))),
				  'NAMA_AGEN'			=> trim(validate($this->input->post('NAMA_AGEN'))),
				  'NO_PERMOHONAN_CFS'	=> trim(validate($this->input->post('NO_PERMOHONAN_CFS'))),
				  'NO_BL_AWB'			=> trim(validate($this->input->post('NO_BL_AWB'))),
				  'NAMA_FORWARDER'		=> ($this->input->post('NAMA_FORWARDER') == '')?null:trim(validate($this->input->post('NAMA_FORWARDER'))),
				  'NPWP_FORWARDER'		=> ($this->input->post('NPWP_FORWARDER') == '')?null:$npwp_forwarder,
				  'ALAMAT_FORWARDER'	=> ($this->input->post('ALAMAT_FORWARDER') == '')?null:trim(validate($this->input->post('ALAMAT_FORWARDER'))),
				  'CONSIGNEE'			=> ($this->input->post('NAMA_CONSIGNEE') == '')?null:trim(validate($this->input->post('NAMA_CONSIGNEE'))),
				  'NPWP_CONSIGNEE'		=> ($this->input->post('NPWP_CONSIGNEE') == '')?null:$npwp,
				  'ALAMAT_CONSIGNEE'	=> ($this->input->post('ALAMAT_CONSIGNEE') == '')?null:trim(validate($this->input->post('ALAMAT_CONSIGNEE'))),
				  'KD_TPS_ASAL'			=> $this->input->post('TPS_ASAL'),
				  'KD_TPS_TUJUAN'		=> $this->input->post('TPS_TUJUAN'),
				  'KD_GUDANG_ASAL'		=> $this->input->post('GUDANG_ASAL'),
				  'KD_GUDANG_TUJUAN'	=> $this->input->post('GUDANG_TUJUAN'),
				  'NO_BC11'				=> trim(validate($this->input->post('NO_BC11'))),
				  'TGL_BC11'			=> validate(date_input($this->input->post('TGL_BC11'))),
				  'NM_ANGKUT'			=> trim(validate($this->input->post('NAMA_KAPAL'))),
				  'NO_VOYAGE'			=> trim(validate($this->input->post('NO_VOY_FLIGHT'))),
				  'TGL_TIBA'			=> validate(date_input($this->input->post('TGL_TIBA'))),
				  'KD_STATUS'			=> '100',
				  'TGL_STATUS'			=> NULL,
				  'ID_USER'				=> $this->newsession->userdata('ID'),
				  'WK_REKAM'			=> date('Y-m-d H:i:s'),
				  'JENIS_BAYAR'			=> trim(validate($this->input->post('JENIS_BAYAR')))
				);
                $this->db->where(array('ID' => $arrchk[1]));
                $result = $this->db->update('t_order_hdr', $DATA);
				$id_permit = $arrchk[1];
				$HAPUS = $this->db->delete('t_order_cont', array('ID' => $id_permit));
				if ($HAPUS == false) {
					$error += 1;
					$message .= "Could not be processed data";
				} else {
					$CONTE = $this->input->post('tb_chktblconte');
					$total = count($CONTE);
					$DATA_C = array();
					for ($x=0;$x<$total;$x++) {
						$CONTEs = explode('~',$CONTE[$x]);
						$this->db->set('ID', $id_permit);
						$this->db->set('NO_CONT', trim(validate($CONTEs[0]))); 
						$this->db->set('KD_CONT_UKURAN', $CONTEs[1]); 
						$this->db->set('NO_POLISI_TRUCK', trim(validate($CONTEs[2]))); 
						$run2 = $this->db->insert('t_order_cont'); 
					}
				}
				if ($result) {
						$func->main->get_log("add", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/clearing/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'tarif_dasar'){
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('reff_billing_cfs', $DATA);
				if ($result) {
						$func->main->get_log("add", "reff_billing_cfs");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/tarif_dasar/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
            } else if ($act == "pbm") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "") {
                        $DATA[$a] = NULL;
                    } else {
						if ($a=="NPWP"){
							$b=str_replace(".","",str_replace("-","",$b));
						}
                        $DATA[$a] = $b;
					}
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('t_organisasi', $DATA);
                if ($result) {
                    $func->main->get_log("update", "t_organisasi");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/pbm/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
			}
		}else if ($type == "delete") {      
			if($act == 'sppb'){
				foreach ($this->input->post('tb_chktblppbarang') as $chkitem) {
					$arrchk = explode("~", $chkitem);
					$ID = $arrchk[1];
					$result1 = $this->db->delete('t_order_kms', array('ID' => $ID));
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
					$result1 = $this->db->delete('t_order_cont', array('ID' => $ID));
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
			}elseif($act == 'tarif_dasar'){
				foreach ($this->input->post('tb_chktbltarif_dasar') as $chkitem) {
					$arrchk = explode("~", $chkitem);
					$ID = $arrchk[0];
					$result = $this->db->delete('reff_billing_cfs', array('ID' => $ID));
					if (!$result) {
						$error += 1;
						$message .= "Could not be processed data";
					} 
				}
				if ($error == 0) {
				  $func->main->get_log("delete", "reff_billing_cfs");
				  echo "MSG#OK#Successfully to be processed#". site_url() . "/order/tarif_dasar/post";
				} else {
				  echo "MSG#ERR#" . $message . "#";
				}
            } else if ($act == "pbm") {
                foreach ($this->input->post('tb_chktblpbm') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
					$check = $this->db->query("select A.ID from app_user A WHERE A.KD_ORGANISASI='".$ID."' limit 1");
					$resulte = $check->row_array();
					if($resulte['ID']==null){
						$result = $this->db->delete('t_organisasi', array('ID' => $ID));
						if (!$result) {
							$error += 1;
							$message .= "Could not be processed data";
						}
					}else{
						if (!$result) {
							$error += 1;
							$message .= "Could not be processed data. Organization is used for user";
						}
					}
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "t_organisasi");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/order/pbm/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
			}
		} else if ($type == "proses") { 
			if($act == 'sppb'){
				$arrchk = explode("~", $id);
				$DATA= array(
				  'KD_STATUS'		=> '200',
				  'WK_REKAM'	=> date('Y-m-d H:i:s')
				);
                $this->db->where(array('ID' => $arrchk[1]));
                $result = $this->db->update('t_order_hdr', $DATA);
				if ($result) {
						$func->main->get_log("send", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/ppbarang/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'clearing'){
				$arrchk = explode("~", $id);
				$DATA= array(
				  'KD_STATUS'		=> '200',
				  'WK_REKAM'	=> date('Y-m-d H:i:s')
				);
                $this->db->where(array('ID' => $arrchk[1]));
                $result = $this->db->update('t_order_hdr', $DATA);
				if ($result) {
						$func->main->get_log("send", "t_order_hdr");
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/clearing/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}
		}
		// for detail
	}
	
	function coba(){
		echo 'oke';
	}
}
