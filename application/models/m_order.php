<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_order extends Model{

  function M_order() {
     parent::Model();
  }

  function get_combobox($find, $gudang=""){
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        if($find=="GUDANG"){
		  $addsql=($gudang=="")?"in ('BAND','RAYA','PSKA')":"='".$gudang."'";
          $sql = "SELECT KD_GUDANG,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '2' and KD_GUDANG ".$addsql." ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "NAMA_GUDANG", TRUE);
        }else if($find == "TPS"){
          $sql = "SELECT KD_GUDANG,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '1' and KD_GUDANG <> 'CART' ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "NAMA_GUDANG", TRUE);
        }else if($find == "ENTRY"){
          $sql = "SELECT ID, NAMA FROM reff_status WHERE KD_TIPE_STATUS='ORDERCFS' AND ID IN ('100','200','300') ORDER BY ID ASC";
          $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
        }else if($find == "TAGIHAN"){
          $sql = "SELECT ID, NAMA FROM reff_status WHERE KD_TIPE_STATUS='ORDERCFS' AND ID NOT IN ('100','200','300') ORDER BY ID ASC";
          $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
        }else if($find == "BANK"){
          $sql = "SELECT BANK_NAME FROM mst_bank_account_simkeu WHERE TYPE='P' ORDER BY BANK_NAME ASC";
          $arrdata = $func->main->get_combobox($sql, "BANK_NAME", "BANK_NAME", TRUE);
        }
        
    return $arrdata;
  }

	function autocomplete($type,$act,$get){
		$post = $this->input->post('term');
		if($type=="no_bl"){
			if($act=="nama"){
			  if (!$post) return;
			  $SQL = "select A.NO_MASTER_BL_AWB, A.TGL_MASTER_BL_AWB, A.NO_BL_AWB, A.TGL_BL_AWB, K.NO_CONT_ASAL,
				ifnull(A.KD_GUDANG,K.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN,
				func_name(IFNULL(A.KD_GUDANG,K.KD_GUDANG_TUJUAN),'GUDANG') AS NM_GUDANG,
				A.NO_BC11, A.TGL_BC11, A.CONSIGNEE, func_npwp(A.ID_CONSIGNEE) AS NPWP_CONSIGNEE, A.ALAMAT_CONSIGNEE,
				A.NM_ANGKUT,A.NO_VOY_FLIGHT,DATE_FORMAT(C.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA,DATE_FORMAT(K.WK_IN,'%d-%m-%Y') AS WK_IN,
				A.ID,A.CAR,A.KD_KANTOR,func_name(IFNULL(A.KD_KANTOR,'-'),'KPBC') AS NM_KANTOR,
				A.KD_DOK_INOUT AS KD_DOK,func_name(IFNULL(A.KD_DOK_INOUT,'-'),'DOK_BC') AS NM_DOK,
				A.NO_DOK_INOUT AS NO_SPPB,DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y') AS TGL_SPPB, O.NO_BL_AWB AS BL
				from t_permit_hdr A 
				join t_cocostskms K on K.NO_BL_AWB=A.NO_BL_AWB and K.TGL_BL_AWB=A.TGL_BL_AWB JOIN t_cocostshdr C on C.ID=K.ID left 
				join (select b.NO_BL_AWB,b.TGL_BL_AWB,b.TGL_KELUAR from t_order_hdr b JOIN t_billing_cfshdr a on a.NO_ORDER=b.NO_ORDER where b.KD_STATUS = '700' and a.IS_VOID is null group by b.NO_BL_AWB,b.TGL_BL_AWB) O on O.NO_BL_AWB=A.NO_BL_AWB and O.TGL_BL_AWB=A.TGL_BL_AWB
				WHERE ((A.KD_GUDANG = 'BAND' OR K.KD_GUDANG_TUJUAN = 'BAND') OR (A.KD_GUDANG = 'PSKA' OR K.KD_GUDANG_TUJUAN = 'PSKA')) 
				AND K.WK_OUT IS NULL AND A.NO_BL_AWB LIKE '".$post."%' LIMIT 5"; 
			  /* 
				LEFT JOIN t_cocostshdr C 
				on A.NM_ANGKUT=C.NM_ANGKUT AND A.NO_VOY_FLIGHT=C.NO_VOY_FLIGHT AND A.NO_BC11=C.NO_BC11 AND A.TGL_BC11=C.TGL_BC11
				left join t_cocostskms K on K.NO_BL_AWB=A.NO_BL_AWB

				$SQL = "select A.ID,A.CAR,A.KD_KANTOR,A.KD_DOK_INOUT,A.NO_DOK_INOUT,A.TGL_DOK_INOUT,A.ID_CONSIGNEE,
				A.CONSIGNEE,A.NM_ANGKUT,A.KD_GUDANG,B.NO_CONT_ASAL,C.NM_ANGKUT,C.TGL_TIBA,A.NO_BL_AWB
				from t_permit_hdr A join t_cocostskms B on A.NO_BL_AWB = B.NO_BL_AWB join t_cocostshdr C on B.ID=C.ID and A.KD_GUDANG=C.KD_GUDANG
				WHERE A.NO_BL_AWB LIKE '%".$post."%' LIMIT 5"; */ #query untuk setelah data t_permit_hdr dan t_cocostskms ada
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $NO_MASTER_BL_AWB = strtoupper($row->NO_MASTER_BL_AWB);
				  $TGL_MASTER_BL_AWB = strtoupper($row->TGL_MASTER_BL_AWB);
				  $NO_BL_AWB = strtoupper($row->NO_BL_AWB);
				  $TGL_BL_AWB = strtoupper($row->TGL_BL_AWB);
				  $KD_GUDANG_TUJUAN = strtoupper($row->KD_GUDANG_TUJUAN);
				  $NM_GUDANG = strtoupper($row->NM_GUDANG);
				  $NO_BC11 = strtoupper($row->NO_BC11);
				  $TGL_BC11 = strtoupper($row->TGL_BC11);
				  $CONSIGNEE = strtoupper($row->CONSIGNEE);
				  $NPWP_CONSIGNEE = strtoupper($row->NPWP_CONSIGNEE);
				  $ALAMAT_CONSIGNEE = strtoupper($row->ALAMAT_CONSIGNEE);
				  $NM_ANGKUT = strtoupper($row->NM_ANGKUT);
				  $NO_VOY_FLIGHT = strtoupper($row->NO_VOY_FLIGHT);
				  $TGL_TIBA = strtoupper($row->TGL_TIBA);
				  $ID = strtoupper($row->ID);
				  $CAR = strtoupper($row->CAR);
				  $KD_KANTOR = strtoupper($row->KD_KANTOR);
				  $NM_KANTOR = strtoupper($row->NM_KANTOR);
				  $KD_DOK = strtoupper($row->KD_DOK);
				  $NM_DOK = strtoupper($row->NM_DOK);
				  $NO_SPPB = strtoupper($row->NO_SPPB);
				  $TGL_SPPB = strtoupper($row->TGL_SPPB);
				  $NO_CONT_ASAL = strtoupper($row->NO_CONT_ASAL);
				  $TGL_STRIPPING = strtoupper($row->WK_IN);
				  $BL = strtoupper($row->BL);
				  $arrayDataTemp[] = array(
					"value"=>$NO_BL_AWB,"NO_MASTER_BL_AWB"=>$NO_MASTER_BL_AWB,"TGL_MASTER_BL_AWB"=>$TGL_MASTER_BL_AWB,"TGL_BL_AWB"=>$TGL_BL_AWB,
					"KD_GUDANG_TUJUAN"=>$KD_GUDANG_TUJUAN,"NM_GUDANG"=>$NM_GUDANG,"NO_BC11"=>$NO_BC11,"TGL_BC11"=>$TGL_BC11,"CONSIGNEE"=>$CONSIGNEE,
					"NPWP_CONSIGNEE"=>$NPWP_CONSIGNEE,"ALAMAT_CONSIGNEE"=>$ALAMAT_CONSIGNEE,"NM_ANGKUT"=>$NM_ANGKUT,"NO_VOY_FLIGHT"=>$NO_VOY_FLIGHT,
					"TGL_TIBA"=>$TGL_TIBA,"ID_PERMIT"=>$ID,"CAR"=>$CAR,"KD_KANTOR"=>$KD_KANTOR,"NM_KANTOR"=>$NM_KANTOR,"KD_DOK"=>$KD_DOK,"BL"=>$BL,
					"NM_DOK"=>$NM_DOK,"NO_SPPB"=>$NO_SPPB,"TGL_SPPB"=>$TGL_SPPB,"NO_CONT_ASAL"=>$NO_CONT_ASAL,"TGL_STRIPPING"=>$TGL_STRIPPING
				  );
				}
			  } 
			}elseif($act=="order"){
			  if (!$post) return;
			  $SQL = "select A.NO_MASTER_BL_AWB, A.TGL_MASTER_BL_AWB, A.NO_BL_AWB, A.TGL_BL_AWB, A.NO_CONT_ASAL,A.KD_GUDANG_TUJUAN,
				func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS NM_GUDANG, A.NO_BC11, A.TGL_BC11, A.CONSIGNEE, A.NPWP_CONSIGNEE, 
				A.ALAMAT_CONSIGNEE, A.NM_ANGKUT,DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA,
				DATE_FORMAT(A.TGL_STRIPPING,'%d-%m-%Y') AS WK_IN,A.NO_SPPB,
				A.ID,A.CAR,A.KD_KPBC AS KD_KANTOR,func_name(A.KD_KPBC,'KPBC') AS NM_KANTOR,A.KODE_DOK AS KD_DOK,
				func_name(A.KODE_DOK,'DOK_BC') AS NM_DOK,A.NO_VOYAGE AS NO_VOY_FLIGHT,
				DATE_FORMAT(A.TGL_SPPB,'%d-%m-%Y') AS TGL_SPPB,
				A.JENIS_TRANSAKSI,(CASE A.JENIS_TRANSAKSI WHEN 'B' THEN 'BARU' WHEN 'P' THEN 'PERPANJANGAN' ELSE '' END) AS JENIS_T,
				C.NO_POLISI_TRUCK, B.NO_INVOICE,DATE_FORMAT(A.TGL_KELUAR_LAMA,'%d-%m-%Y') AS TGL_KELUAR_LAMA,
				DATE_FORMAT(A.TGL_KELUAR,'%d-%m-%Y') AS TGL_KELUAR,A.CUSTOMER_NUMBER,A.NAMA_FORWARDER,A.NPWP_FORWARDER,
				A.ALAMAT_FORWARDER,A.NO_DO,DATE_FORMAT(A.TGL_DO,'%d-%m-%Y') AS TGL_DO,
				DATE_FORMAT(A.TGL_EXPIRED_DO,'%d-%m-%Y') AS TGL_EXPIRED_DO, CONCAT(A.NO_BL_AWB,' - ',B.NO_INVOICE) AS CARI
				from t_order_hdr A join t_billing_cfshdr B on A.NO_ORDER=B.NO_ORDER JOIN t_order_kms C ON C.ID=A.ID
				WHERE B.NO_INVOICE IS NOT NULL AND B.IS_VOID IS NULL AND CONCAT(A.NO_BL_AWB,' - ',B.NO_INVOICE) LIKE '".$post."%' LIMIT 5"; 
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $NO_MASTER_BL_AWB = strtoupper($row->NO_MASTER_BL_AWB);
				  $TGL_MASTER_BL_AWB = strtoupper($row->TGL_MASTER_BL_AWB);
				  $NO_BL_AWB = strtoupper($row->NO_BL_AWB);
				  $TGL_BL_AWB = strtoupper($row->TGL_BL_AWB);
				  $NO_CONT_ASAL = strtoupper($row->NO_CONT_ASAL);
				  $KD_GUDANG_TUJUAN = strtoupper($row->KD_GUDANG_TUJUAN);
				  $NM_GUDANG = strtoupper($row->NM_GUDANG);
				  $NO_BC11 = strtoupper($row->NO_BC11);
				  $TGL_BC11 = strtoupper($row->TGL_BC11);
				  $CONSIGNEE = strtoupper($row->CONSIGNEE);
				  $NPWP_CONSIGNEE = strtoupper($row->NPWP_CONSIGNEE);
				  $ALAMAT_CONSIGNEE = strtoupper($row->ALAMAT_CONSIGNEE);
				  $NM_ANGKUT = strtoupper($row->NM_ANGKUT);
				  $NO_VOY_FLIGHT = strtoupper($row->NO_VOY_FLIGHT);
				  $TGL_TIBA = strtoupper($row->TGL_TIBA);
				  $TGL_STRIPPING = strtoupper($row->WK_IN);
				  $NO_SPPB = strtoupper($row->NO_SPPB);
				  $TGL_SPPB = strtoupper($row->TGL_SPPB);
				  $ID = strtoupper($row->ID);
				  $CAR = strtoupper($row->CAR);
				  $KD_KANTOR = strtoupper($row->KD_KANTOR);
				  $NM_KANTOR = strtoupper($row->NM_KANTOR);
				  $KD_DOK = strtoupper($row->KD_DOK);
				  $NM_DOK = strtoupper($row->NM_DOK);
				  $JENIS_TRANSAKSI = strtoupper($row->JENIS_TRANSAKSI);
				  $JENIS_T = strtoupper($row->JENIS_T);
				  $NO_POLISI_TRUCK = strtoupper($row->NO_POLISI_TRUCK);
				  $EX_NOTA = strtoupper($row->NO_INVOICE);
				  $TGL_KELUAR_LAMA = strtoupper($row->TGL_KELUAR_LAMA);
				  $TGL_KELUAR = strtoupper($row->TGL_KELUAR);
				  $CUSTOMER_NUMBER = strtoupper($row->CUSTOMER_NUMBER);
				  $NAMA_FORWARDER = strtoupper($row->NAMA_FORWARDER);
				  $NPWP_FORWARDER = strtoupper($row->NPWP_FORWARDER);
				  $ALAMAT_FORWARDER = strtoupper($row->ALAMAT_FORWARDER);
				  $NO_DO = strtoupper($row->NO_DO);
				  $TGL_DO = strtoupper($row->TGL_DO);
				  $TGL_EXPIRED_DO = strtoupper($row->TGL_EXPIRED_DO);
				  $CARI = strtoupper($row->CARI);
				  $arrayDataTemp[] = array(
					"value"=>$NO_BL_AWB,"label"=>$CARI,"NO_BL_AWB"=>$NO_BL_AWB,"NO_MASTER_BL_AWB"=>$NO_MASTER_BL_AWB,"TGL_MASTER_BL_AWB"=>$TGL_MASTER_BL_AWB,"TGL_BL_AWB"=>$TGL_BL_AWB,"KD_GUDANG_TUJUAN"=>$KD_GUDANG_TUJUAN,"NM_GUDANG"=>$NM_GUDANG,"NO_BC11"=>$NO_BC11,"TGL_BC11"=>$TGL_BC11,"CONSIGNEE"=>$CONSIGNEE,"NPWP_CONSIGNEE"=>$NPWP_CONSIGNEE,"ALAMAT_CONSIGNEE"=>$ALAMAT_CONSIGNEE,"NM_ANGKUT"=>$NM_ANGKUT,"NO_VOY_FLIGHT"=>$NO_VOY_FLIGHT,"TGL_TIBA"=>$TGL_TIBA,"ID_PERMIT"=>$ID,"CAR"=>$CAR,"KD_KANTOR"=>$KD_KANTOR,"NM_KANTOR"=>$NM_KANTOR,"KD_DOK"=>$KD_DOK,"JENIS_TRANSAKSI"=>$JENIS_TRANSAKSI,"JENIS_T"=>$JENIS_T,"NO_POLISI_TRUCK"=>$NO_POLISI_TRUCK,"NM_DOK"=>$NM_DOK,"NO_SPPB"=>$NO_SPPB,"TGL_SPPB"=>$TGL_SPPB,"NO_CONT_ASAL"=>$NO_CONT_ASAL,"TGL_STRIPPING"=>$TGL_STRIPPING,"EX_NOTA"=>$EX_NOTA,"TGL_KELUAR_LAMA"=>$TGL_KELUAR_LAMA,"TGL_KELUAR"=>$TGL_KELUAR,"CUSTOMER_NUMBER"=>$CUSTOMER_NUMBER,"NAMA_FORWARDER"=>$NAMA_FORWARDER,"NPWP_FORWARDER"=>$NPWP_FORWARDER,"ALAMAT_FORWARDER"=>$ALAMAT_FORWARDER,"NO_DO"=>$NO_DO,"TGL_DO"=>$TGL_DO,"TGL_EXPIRED_DO"=>$TGL_EXPIRED_DO
				  );
				}
			  } 
			}elseif($act=="nama2"){
			  if (!$post) return;
			  $SQL = "select B.NO_POLISI_TRUCK,DATE_FORMAT(A.TGL_KELUAR,'%d-%m-%Y') AS TGL_KELUAR,A.NO_DO,
				DATE_FORMAT(A.TGL_DO,'%d-%m-%Y') AS TGL_DO,DATE_FORMAT(A.TGL_EXPIRED_DO,'%d-%m-%Y') AS TGL_EXPIRED_DO,A.NO_CONT_ASAL,
				A.NAMA_FORWARDER,func_npwp(A.NPWP_FORWARDER) AS NPWP_FORWARDER,A.ALAMAT_FORWARDER,
				A.JENIS_BAYAR,A.NO_MASTER_BL_AWB, A.TGL_MASTER_BL_AWB, A.NO_BL_AWB, A.TGL_BL_AWB, 
				A.KD_GUDANG_TUJUAN,func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG') AS NM_GUDANG,
				A.NO_BC11, A.TGL_BC11, A.CONSIGNEE, func_npwp(A.NPWP_CONSIGNEE) AS NPWP_CONSIGNEE, A.ALAMAT_CONSIGNEE,
				A.NM_ANGKUT, A.NO_VOYAGE, DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA,
				A.ID,A.CAR,A.KD_KPBC,func_name(IFNULL(A.KD_KPBC,'-'),'KPBC') AS NM_KANTOR,
				A.KODE_DOK,func_name(IFNULL(A.KODE_DOK,'-'),'DOK_BC') AS NM_DOK,
				A.NO_SPPB,DATE_FORMAT(A.TGL_SPPB,'%d-%m-%Y') AS TGL_SPPB
				from t_order_hdr A JOIN t_order_kms B ON A.ID=B.ID
				JOIN ( SELECT NO_BL_AWB, MAX(ID) MaxID FROM t_order_hdr GROUP BY NO_BL_AWB ) r 
				ON A.NO_BL_AWB = r.NO_BL_AWB AND A.ID = r.MaxID
				WHERE A.NO_BL_AWB LIKE '%".$post."%' and A.NO_ORDER LIKE 'KMS%' group by A.NO_BL_AWB order by ID desc LIMIT 5"; 
				// DATE_FORMAT(C.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, JOIN t_cocostshdr C 
				//on A.NM_ANGKUT=C.NM_ANGKUT AND A.NO_VOY_FLIGHT=C.NO_VOY_FLIGHT AND A.NO_BC11=C.NO_BC11 AND A.TGL_BC11=C.TGL_BC11
			  /* $SQL = "select A.ID,A.CAR,A.KD_KANTOR,A.KD_DOK_INOUT,A.NO_DOK_INOUT,A.TGL_DOK_INOUT,A.ID_CONSIGNEE,
				A.CONSIGNEE,A.NM_ANGKUT,A.KD_GUDANG,B.NO_CONT_ASAL,C.NM_ANGKUT,C.TGL_TIBA,A.NO_BL_AWB
				from t_permit_hdr A join t_cocostskms B on A.NO_BL_AWB = B.NO_BL_AWB join t_cocostshdr C on B.ID=C.ID and A.KD_GUDANG=C.KD_GUDANG
				WHERE A.NO_BL_AWB LIKE '%".$post."%' LIMIT 5"; */ #query untuk setelah data t_permit_hdr dan t_cocostskms ada
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $NO_POLISI_TRUCK = strtoupper($row->NO_POLISI_TRUCK);
				  $TGL_KELUAR = strtoupper($row->TGL_KELUAR);
				  $NO_DO = strtoupper($row->NO_DO);
				  $TGL_DO = strtoupper($row->TGL_DO);
				  $JENIS_BAYAR = strtoupper($row->JENIS_BAYAR);
				  $TGL_EXPIRED_DO = strtoupper($row->TGL_EXPIRED_DO);
				  $NO_CONT_ASAL = strtoupper($row->NO_CONT_ASAL);
				  $NO_MASTER_BL_AWB = strtoupper($row->NO_MASTER_BL_AWB);
				  $TGL_MASTER_BL_AWB = strtoupper($row->TGL_MASTER_BL_AWB);
				  $NO_BL_AWB = strtoupper($row->NO_BL_AWB);
				  $TGL_BL_AWB = strtoupper($row->TGL_BL_AWB);
				  $KD_GUDANG_TUJUAN = strtoupper($row->KD_GUDANG_TUJUAN);
				  $NM_GUDANG = strtoupper($row->NM_GUDANG);
				  $NO_BC11 = strtoupper($row->NO_BC11);
				  $TGL_BC11 = strtoupper($row->TGL_BC11);
				  $CONSIGNEE = strtoupper($row->CONSIGNEE);
				  $NPWP_CONSIGNEE = strtoupper($row->NPWP_CONSIGNEE);
				  $ALAMAT_CONSIGNEE = strtoupper($row->ALAMAT_CONSIGNEE);
				  $NAMA_FORWARDER = strtoupper($row->NAMA_FORWARDER);
				  $NPWP_FORWARDER = strtoupper($row->NPWP_FORWARDER);
				  $ALAMAT_FORWARDER = strtoupper($row->ALAMAT_FORWARDER);
				  $NM_ANGKUT = strtoupper($row->NM_ANGKUT);
				  $NO_VOY_FLIGHT = strtoupper($row->NO_VOYAGE);
				  $TGL_TIBA = strtoupper($row->TGL_TIBA);
				  $ID = strtoupper($row->ID);
				  $CAR = strtoupper($row->CAR);
				  $KD_KANTOR = strtoupper($row->KD_KPBC);
				  $NM_KANTOR = strtoupper($row->NM_KANTOR);
				  $KD_DOK = strtoupper($row->KODE_DOK);
				  $NM_DOK = strtoupper($row->NM_DOK);
				  $NO_SPPB = strtoupper($row->NO_SPPB);
				  $TGL_SPPB = strtoupper($row->TGL_SPPB);
				  $arrayDataTemp[] = array(
					"value"=>$NO_BL_AWB,"NO_POLISI_TRUCK"=>$NO_POLISI_TRUCK,"TGL_KELUAR"=>$TGL_KELUAR,"NO_DO"=>$NO_DO,"TGL_DO"=>$TGL_DO,"JENIS_BAYAR"=>$JENIS_BAYAR,"TGL_EXPIRED_DO"=>$TGL_EXPIRED_DO,"NO_CONT_ASAL"=>$NO_CONT_ASAL,"NO_MASTER_BL_AWB"=>$NO_MASTER_BL_AWB,"TGL_MASTER_BL_AWB"=>$TGL_MASTER_BL_AWB,"TGL_BL_AWB"=>$TGL_BL_AWB,"NAMA_FORWARDER"=>$NAMA_FORWARDER,
					"NPWP_FORWARDER"=>$NPWP_FORWARDER,"ALAMAT_FORWARDER"=>$ALAMAT_FORWARDER,
					"KD_GUDANG_TUJUAN"=>$KD_GUDANG_TUJUAN,"NM_GUDANG"=>$NM_GUDANG,"NO_BC11"=>$NO_BC11,"TGL_BC11"=>$TGL_BC11,"CONSIGNEE"=>$CONSIGNEE,
					"NPWP_CONSIGNEE"=>$NPWP_CONSIGNEE,"ALAMAT_CONSIGNEE"=>$ALAMAT_CONSIGNEE,"NM_ANGKUT"=>$NM_ANGKUT,"NO_VOY_FLIGHT"=>$NO_VOY_FLIGHT,
					"TGL_TIBA"=>$TGL_TIBA,"ID_PERMIT"=>$ID,"CAR"=>$CAR,"KD_KANTOR"=>$KD_KANTOR,"NM_KANTOR"=>$NM_KANTOR,"KD_DOK"=>$KD_DOK,
					"NM_DOK"=>$NM_DOK,"NO_SPPB"=>$NO_SPPB,"TGL_SPPB"=>$TGL_SPPB
				  );
				}
			  } 
			}elseif($act=="nama3"){
			  if (!$post) return;
			  $SQL = "select A.NO_BL_AWB, A.KD_GUDANG_TUJUAN, func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG,
				B.NO_BC11,DATE_FORMAT(B.TGL_BC11,'%d-%m-%Y') AS TGL_BC11,B.NM_ANGKUT,B.CALL_SIGN, A.CONSIGNEE,
				B.NO_VOY_FLIGHT,DATE_FORMAT(B.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, C.KD_TPS, func_npwp(A.KD_ORG_CONSIGNEE) AS NPWP_CONSIGNEE
				from t_cocostscont A JOIN t_cocostshdr B ON A.ID=B.ID AND B.KD_ASAL_BRG='2'
				JOIN reff_gudang C ON C.KD_GUDANG=A.KD_GUDANG_TUJUAN LEFT JOIN t_order_hdr D ON A.NO_BL_AWB=D.NO_BL_AWB
				WHERE A.NO_BL_AWB IS NOT NULL AND A.KD_CONT_JENIS='L' AND A.WK_OUT IS NULL AND A.NO_BL_AWB LIKE '%".$post."%' AND D.NO_BL_AWB IS NULL GROUP BY A.NO_BL_AWB LIMIT 5"; 
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();$cont = array();$NO=0;
			  if($banyakData > 0){
				foreach($result->result() as $row){
					$NO_BL_AWB = strtoupper($row->NO_BL_AWB);
					$KD_GUDANG_TUJUAN = strtoupper($row->KD_GUDANG_TUJUAN);
					$GUDANG = strtoupper($row->GUDANG);
					$NO_BC11 = strtoupper($row->NO_BC11);
					$TGL_BC11 = strtoupper($row->TGL_BC11);
					$NM_ANGKUT = strtoupper($row->NM_ANGKUT);
					$CALL_SIGN = strtoupper($row->CALL_SIGN);
					$NO_VOY_FLIGHT = strtoupper($row->NO_VOY_FLIGHT);
					$TGL_TIBA = strtoupper($row->TGL_TIBA);
					$KD_TPS = strtoupper($row->KD_TPS);
					$CONSIGNEE = strtoupper($row->CONSIGNEE);
					$NPWP_CONSIGNEE = strtoupper($row->NPWP_CONSIGNEE);
					$SQL2="SELECT B.ID, A.NO_CONT,A.KD_CONT_UKURAN, A.NO_BL_AWB, C.NO_CONT_ASAL,C.NO_BL_AWB, C.JML
					FROM t_cocostscont A
					JOIN t_cocostshdr B ON A.ID=B.ID AND B.KD_ASAL_BRG='2'
					LEFT JOIN (
					SELECT Y.NO_CONT_ASAL,X.NO_BL_AWB,(SELECT COUNT(N.NO_CONT_ASAL) FROM t_cocostskms N WHERE N.NO_CONT_ASAL=X.NO_CONT AND N.ID=X.ID) AS JML
					FROM t_cocostscont X
					JOIN t_cocostskms Y ON Y.ID=X.ID AND Y.NO_CONT_ASAL=X.NO_CONT
					GROUP BY Y.NO_CONT_ASAL
					) C ON C.NO_BL_AWB=A.NO_BL_AWB AND A.NO_CONT=C.NO_CONT_ASAL
					WHERE A.NO_BL_AWB IS NOT NULL AND A.WK_OUT IS NULL AND A.NO_BL_AWB='".$NO_BL_AWB."';";
				    $result2 = $this->db->query($SQL2);
				    foreach($result2->result() as $row){
						$stat=($row->NO_CONT_ASAL=='')?'BELUM STRIPING':'SIAP';
						$cont[] = array("NOD"=>$NO,"NO_CONT"=>$row->NO_CONT,"KD_CONT_UKURAN"=>$row->KD_CONT_UKURAN,"STATUS"=>$stat);
					}
				  $arrayDataTemp[] = array(
					"value"=>$NO_BL_AWB,"NOH"=>$NO,"NO_BL_AWB"=>$NO_BL_AWB,"KD_GUDANG_TUJUAN"=>$KD_GUDANG_TUJUAN,"GUDANG"=>$GUDANG,"NO_BC11"=>$NO_BC11,"TGL_BC11"=>$TGL_BC11,"NM_ANGKUT"=>$NM_ANGKUT,"CALL_SIGN"=>$CALL_SIGN,"NO_VOY_FLIGHT"=>$NO_VOY_FLIGHT,"TGL_TIBA"=>$TGL_TIBA,"KD_TPS"=>$KD_TPS,"CONSIGNEE"=>$CONSIGNEE,"NPWP_CONSIGNEE"=>$NPWP_CONSIGNEE,"KONTAINER"=>$cont
				  );$NO++;
				}
			  } 
			}elseif($act=="organisasi"){
			  if (!$post) return;
			  //$SQL = "select A.NAMA, func_npwp(A.NPWP) as NPWP, A.ALAMAT from t_organisasi A
				//WHERE A.NAMA LIKE '%".$post."%' AND A.KD_TIPE_ORGANISASI IN('FWD','CONS') LIMIT 5"; 
				//CONCAT(A.ADDRESS,IFNULL(CONCAT(', ',A.KELURAHAN),''),IFNULL(CONCAT(', ',A.KECAMATAN),''),IFNULL(CONCAT(', ',A.CITY),'')) AS ADDRESS,
			  $SQL = "select A.ALT_NAME, A.NPWP, A.ADDRESS, A.CUSTOMER_ID from mst_customer A
				WHERE A.ALT_NAME LIKE '%".$post."%' AND A.STATUS_CUSTOMER='A' AND A.STATUS_APPROVAL='A' LIMIT 5"; 
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $NAMA = strtoupper($row->ALT_NAME);
				  $NPWP = strtoupper($row->NPWP);
				  $ALAMAT = strtoupper($row->ADDRESS);
				  $NUMBER = strtoupper($row->CUSTOMER_ID);
				  $arrayDataTemp[] = array(
					"value"=>$NAMA,"NAMA"=>$NAMA,"NPWP"=>$NPWP,"ALAMAT"=>$ALAMAT,"NUMBER"=>$NUMBER
				  );
				}
			  } 
			}elseif($act=="edc"){
			  if (!$post) return;
			  $SQL = "select a.NO_ORDER,ifnull(a.CONSIGNEE,a.NAMA_FORWARDER) as NAMA_PEMILIK,b.TOTAL,
				ifnull(a.NPWP_CONSIGNEE,a.NPWP_FORWARDER) as NPWP_PEMILIK,b.NO_PROFORMA_INVOICE, 
				CONCAT(b.NO_ORDER,' - ',b.NO_PROFORMA_INVOICE) AS CARI
				from t_order_hdr a join t_billing_cfshdr b on a.NO_ORDER=b.NO_ORDER
				where b.FLAG_APPROVE='Y' and b.KD_ALASAN_BILLING='ACCEPT' and a.NO_ORDER like '10%' and b.NO_INVOICE is null
				and a.KD_STATUS = '500' and a.NO_ORDER LIKE '%".$post."%' LIMIT 5"; 
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $NO_ORDER = strtoupper($row->NO_ORDER);
				  $NAMA_PEMILIK = strtoupper($row->NAMA_PEMILIK);
				  $NPWP_PEMILIK = strtoupper($row->NPWP_PEMILIK);
				  $TOTAL = strtoupper($row->TOTAL);
				  $CARI = strtoupper($row->CARI);
				  $NO_PROFORMA_INVOICE = strtoupper($row->NO_PROFORMA_INVOICE);
				  $arrayDataTemp[] = array(
					"value"=>$NO_ORDER,"label"=>$CARI,"NAMA_PEMILIK"=>$NAMA_PEMILIK,"NPWP_PEMILIK"=>$NPWP_PEMILIK,"TOTAL"=>$TOTAL,"NO_PROFORMA_INVOICE"=>$NO_PROFORMA_INVOICE
				  );
				}
			  } 
			}
			echo json_encode($arrayDataTemp);
		}elseif($type=="reff_gudang"){
			if($act=="nama"){        
			  if (!$post) return;
			  $addSQL = '';
			  if($get == '1'){
				$addSQL .= " AND A.TIPE = '1' ";
				$addSQL .= " AND A.KD_GUDANG <> 'CART' ";
			  }else if($get == '2'){
				$addSQL .= " AND A.TIPE = '2' ";
				$addSQL .= " AND A.KD_GUDANG IN ('BAND','RAYA') ";
			  }

			  $SQL = "SELECT func_name(A.KD_GUDANG,'GUDANG') AS TPS, A.KD_GUDANG AS GUDANG,CONCAT(A.NAMA_GUDANG,' - ',B.NAMA_TPS) AS NAMANYA 
			  FROM reff_gudang A LEFT JOIN reff_tps B ON A.KD_TPS=B.KD_TPS 
			  WHERE CONCAT(A.KD_GUDANG,' ',A.NAMA_GUDANG,' ',B.NAMA_TPS) LIKE '%".$post."%' ".$addSQL." LIMIT 5"; 
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $NAMA = strtoupper($row->TPS);
				  $KODE = strtoupper($row->GUDANG);
				  $NAME = strtoupper($row->NAMANYA);
				  $arrayDataTemp[] = array("value"=>$NAME,"NAMA"=>$NAMA,"KODE"=>$KODE);
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
		$sgudang="";
		if($TIPE_ORGANISASI == 'TPS2'){
			$addsql = " AND A.KD_GUDANG_TUJUAN = ".$this->db->escape($KD_GUDANG);
			$sgudang =$KD_GUDANG;
		}
		if(!$this->input->post('ajax')){
			$addsql .= " AND A.WK_REKAM >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)";
		}
		$SQL = "SELECT A.WK_REKAM,A.ID,A.NO_ORDER AS 'NO ORDER', A.NO_BL_AWB AS 'NO BL', A.NO_CONT_ASAL AS 'NO CONTAINER', 
				CONCAT('NAMA : ',IFNULL(A.NAMA_FORWARDER,'-'),'<BR>NPWP : ',IFNULL(A.NPWP_FORWARDER,'-')) AS 'COSTUMER',
				CONCAT('NAMA : ',A.CONSIGNEE,'<BR>NPWP : ',A.NPWP_CONSIGNEE) AS 'PEMILIK',
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'GUDANG',
				(case when A.JENIS_TRANSAKSI='B' THEN 'BARU' ELSE 'PERPANJANGAN' END) AS 'JENIS TRANSAKSI',
				CONCAT('<h4><span class=\"label label-', CASE A.KD_STATUS WHEN '500' THEN 'success' WHEN '200' THEN 'info' WHEN 
				'300' THEN 'info' WHEN '400' THEN 'warning' WHEN '600' THEN 'danger' WHEN '700' THEN 'primary' WHEN '800' THEN 'danger' ELSE 'default' END,'\">',C.NAMA,'</span></h4><BR>TGL ORDER : ',DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y %h:%i:%s'),'<br>CREATED BY: ',B.NM_LENGKAP) AS 'STATUS',A.CAR, A.KD_STATUS
				FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='ORDERCFS' WHERE A.EX_NOTA IS NULL".$addsql;//A.KD_STATUS IN ('100','200') AND
		$proses = array(
			'ENTRY'	 => array('MODAL',"/order/ppbarang/add", '0','','icon-plus', '', 'menu'),
			'UPDATE' => array('MODAL',"/order/ppbarang/edit", '1','100','icon-pencil', '', 'list'),
			'DELETE' => array('DELETE', site_url() . "/order/execute/delete/sppb", 'ALL', '100', 'icon-trash', '', 'menu'),
			'VIEW' => array('MODAL',"order/ppbarang/detail", '1','','icon-magnifier-add', '', 'list'),
			'KIRIM' => array('MODAL', "order/ppbarang/kirim", '1', '100', 'icon-share-alt', '', 'list')
		);
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG",$sgudang);
    	$arrnamaTPS = $this->get_combobox("TPS");
    	$arrnamaStatus = $this->get_combobox("ENTRY");
    	if($TIPE_ORGANISASI=="SPA" || $TIPE_ORGANISASI=="PCFS"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('A.CONSIGNEE','NAMA PEMILIK'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_STATUS', 'STATUS', 'OPTION', $arrnamaStatus)));
    	}else{
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER')));
    	}
		$this->newtable->action(site_url() . "/order/ppbarang");
		//$this->newtable->detail(array('POPUP',"order/ppbarang/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses2('button');
		$this->newtable->hiddens(array("CAR","ID","KD_STATUS","WK_REKAM"));
		$this->newtable->keys(array("NO ORDER","ID","KD_STATUS"));
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

	function restitusi($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('Permohonan Pengeluaran Barang - RESTITUSI', 'javascript:void(0)');
		$data['title'] = 'PERMOHONAN PENGELUARAN BARANG - RESTITUSI';
		$title = "DATA PERMOHONAN PENGELUARAN BARANG - RESTITUSI";
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
		$SQL = "SELECT A.WK_REKAM,A.ID,A.NO_ORDER AS 'NO ORDER', A.NO_BL_AWB AS 'NO BL', A.NO_CONT_ASAL AS 'NO CONTAINER', 
				CONCAT('NAMA : ',IFNULL(A.NAMA_FORWARDER,'-'),'<BR>NPWP : ',IFNULL(A.NPWP_FORWARDER,'-')) AS 'COSTUMER',
				CONCAT('NAMA : ',A.CONSIGNEE,'<BR>NPWP : ',A.NPWP_CONSIGNEE) AS 'PEMILIK',
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'GUDANG',
				(case when A.JENIS_TRANSAKSI='B' THEN 'BARU' ELSE 'PERPANJANGAN' END) AS 'JENIS TRANSAKSI',
				CONCAT('<h4><span class=\"label label-', CASE A.KD_STATUS WHEN '500' THEN 'success' WHEN '200' THEN 'info' WHEN 
				'300' THEN 'info' WHEN '400' THEN 'warning' WHEN '600' THEN 'danger' WHEN '700' THEN 'primary' WHEN '800' THEN 'danger' ELSE 'default' END,'\">',C.NAMA,'</span></h4><BR>TGL RESTITUSI : ',DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y %h:%i:%s'),'<br>CREATED BY: ',B.NM_LENGKAP) AS 'STATUS',A.CAR, A.KD_STATUS
				FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='ORDERCFS' WHERE A.EX_NOTA IS NOT NULL".$addsql;
				//var_dump($SQL);die();
				//A.KD_STATUS IN ('100','200') AND
		$proses = array(
			'ENTRY'	 => array('MODAL',"/order/restitusi/add", '0','','icon-plus', '', 'menu'),
			//'UPDATE' => array('MODAL',"/order/restitusi/edit", '1','100','icon-refresh', '', 'list'),
			'DELETE' => array('DELETE', site_url() . "/order/execute/delete/sppb", 'ALL', '100', 'icon-trash', '', 'menu'),
			'VIEW' => array('MODAL',"order/restitusi/detail", '1','','icon-magnifier-add', '', 'list'),
			'KIRIM' => array('MODAL', "order/restitusi/kirim", '1', '100', 'icon-share-alt', '', 'list')
		);
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG",$sgudang);
    	$arrnamaTPS = $this->get_combobox("TPS");
    	$arrnamaStatus = $this->get_combobox("ENTRY");
    	if($TIPE_ORGANISASI=="SPA" || $TIPE_ORGANISASI=="PCFS"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('A.CONSIGNEE','NAMA PEMILIK'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_STATUS', 'STATUS', 'OPTION', $arrnamaStatus)));
    	}else{
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER')));
    	}
		$this->newtable->action(site_url() . "/order/restitusi");
		//$this->newtable->detail(array('POPUP',"order/restitusi/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses2('button');
		$this->newtable->hiddens(array("CAR","ID","KD_STATUS","WK_REKAM"));
		$this->newtable->keys(array("NO ORDER","ID","KD_STATUS"));
		$this->newtable->cidb($this->db);
        $this->newtable->validasi(array("KD_STATUS"));
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblrestitusi");
		$this->newtable->set_divid("divtblrestitusi");
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
		$sgudang="";
		if($TIPE_ORGANISASI == 'TPS2'){
			$addsql = " AND A.KD_GUDANG_TUJUAN = ".$this->db->escape($KD_GUDANG);
			$sgudang =$KD_GUDANG;
		}
		if(!$this->input->post('ajax')){
			$addsql .= " AND A.WK_REKAM >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)";
		}
		$SQL = "SELECT D.TGL_UPDATE,D.ID as IDB,A.ID,A.NO_ORDER AS 'NO ORDER',D.TOTAL AS 'TOTAL (Rp)',
				CONCAT('JENIS: ',(case when A.JENIS_TRANSAKSI='B' THEN 'BARU' ELSE 'PERPANJANGAN' END),
				'<BR>NO B/L: ',A.NO_BL_AWB,'<BR>NO CONTAINER: ',A.NO_CONT_ASAL) AS 'TRANSAKSI',
				CONCAT('TGL STRIPPING: ',IFNULL(DATE_FORMAT(A.TGL_STRIPPING,'%d-%m-%Y'),'-'),
				'<BR>TGL KELUAR: ',DATE_FORMAT(A.TGL_KELUAR,'%d-%m-%Y')) AS TANGGAL,
				CONCAT('NAMA : ',IFNULL(A.NAMA_FORWARDER,'-'),'<BR>NPWP : ',IFNULL(A.NPWP_FORWARDER,'-')) AS 'COSTUMER',
				(case when (D.NO_INVOICE is not null) THEN '200' ELSE '100' END) as INVOICE,
				CONCAT('NAMA : ',A.CONSIGNEE,'<BR>NPWP : ',A.NPWP_CONSIGNEE) AS 'PEMILIK',
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'GUDANG',
				CONCAT('<h4><span class=\"label label-', CASE A.KD_STATUS WHEN '400' THEN 'warning' WHEN '500' THEN 'success' 
				WHEN '600' THEN 'danger' WHEN '700' THEN 'primary' WHEN '800' THEN 'danger' ELSE 'default' END,'\">',C.NAMA,'</span></h4>
				<BR>TGL KONFIRMASI : ',DATE_FORMAT(D.TGL_UPDATE,'%d-%m-%Y %h:%i:%s')) AS 'STATUS',A.CAR, A.KD_STATUS
				FROM t_order_hdr A left JOIN app_user B ON A.ID_USER=B.ID 
				JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='ORDERCFS' 
				JOIN (select bb.ID,bb.NO_ORDER,bb.NO_INVOICE,bb.TOTAL,bb.TGL_UPDATE from t_billing_cfshdr bb
				JOIN (select max(ID) as IDB,NO_ORDER, NO_INVOICE,TOTAL from t_billing_cfshdr group by NO_ORDER) bc on bb.ID=bc.IDB) D on A.NO_ORDER=D.NO_ORDER
				WHERE A.KD_STATUS NOT IN ('100','200','300')".$addsql;//and D.NO_INVOICE is null
				//var_dump($SQL);die();
		$proses = array(
			'PRINT' => array('PRINT', site_url() . "/order/proses_print/order/proforma_invoice", '1', '500', 'icon-printer', '', 'list'),
			'VIEW' => array('MODAL', "order/approval/detail", '1', '', 'icon-magnifier-add', '', 'list')
		);
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG",$sgudang);
    	$arrnamaTagihan = $this->get_combobox("TAGIHAN");
    	if($TIPE_ORGANISASI=="SPA" || $TIPE_ORGANISASI=="PCFS"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('A.CONSIGNEE','NAMA PEMILIK'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_STATUS', 'STATUS', 'OPTION', $arrnamaTagihan)));
    	}else{
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('A.KD_STATUS', 'STATUS', 'OPTION', $arrnamaTagihan)));
    	}
		
		$this->newtable->action(site_url() . "/order/approval");
		$this->newtable->detail(array('POPUP',"order/approval/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses2('button');
		$this->newtable->hiddens(array("CAR","ID","KD_STATUS","INVOICE","IDB","TGL_UPDATE"));
		$this->newtable->numberformat(array("TOTAL (Rp)"));
		$this->newtable->keys(array("NO ORDER","ID","IDB"));
		$this->newtable->cidb($this->db);
        $this->newtable->validasi(array("KD_STATUS"));
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("A.NO_ORDER"));
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

	public function approval_billing($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		$arrid = explode("~",$id);
		/*$SQL = "SELECT A.NO_CONT AS 'NO. KONTAINER', func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN') AS UKURAN
				FROM t_request_plp_cont A
				WHERE A.ID = ".$this->db->escape($arrid[1]);*/
		if($act=='surat_jalan'){
			$title = "DETAIL KEMASAN";
			$SQL = "SELECT B.MRK_KMS AS 'MERK KEMASAN', B.JNS_KMS AS 'JENIS KEMASAN', B.JML_KMS AS 'JUMLAH KEMASAN',
				B.WEIGHT AS TON, B.MEASURE AS M3
				FROM t_billing_cfsdtl B WHERE B.ID = ".$this->db->escape($id)." group by B.MRK_KMS";
			$info='';
		}else{
			$title = "DAFTAR TAGIHAN LAYANAN KEMASAN";
			$SQL = "select A.KODE_BILL AS KODE, C.NO_ORDER,(case when (C.JENIS_BAYAR = 'A') THEN 'CASH' ELSE 'KREDIT' END) as JENIS_BAYAR,C.SUBTOTAL,C.PPN,C.TOTAL as TOTAL_BAYAR, 
				A.ID, A.NO_CONT, B.DESKRIPSI as 'NAMA ITEM', A.TARIF_DASAR as 'TARIF DASAR', A.QTY,A.HARI, A.TOTAL
				from t_billing_cfsdtl A LEFT join reff_billing_cfs B on A.KODE_BILL=B.KODE_BILL JOIN t_billing_cfshdr C ON C.ID=A.ID
				WHERE C.ID = ".$this->db->escape($id);
			$check = $this->db->query($SQL);
			$resulte = $check->row_array();
			$check1 = $this->db->query("SELECT B.NO_CONT, func_name(B.KD_UK_CONT,'CONT_UKURAN') AS UKURAN_CONT, SUM(B.TOTAL) AS SUBTOTAL, B.WEIGHT, 
			B.MEASURE from t_billing_cfshdr A join t_billing_cfsdtl B on B.ID=A.ID
			where A.ID=".$this->db->escape($id));
			$resulte1 = $check1->row_array();
			$info = '<div class="table-responsive"><table class="table m-b-0"><tbody>
					<tr><th width="20%">NO ORDER</th><td>'.$resulte['NO_ORDER'].'</td></tr>
					<tr><th>SUBTOTAL</th><td>Rp '.number_format($resulte['SUBTOTAL'], '0', ',', '.').',-</td></tr>
					<tr><th>PPN</th><td>Rp '.number_format($resulte['PPN'], '0', ',', '.').',-</td></tr>
					<tr><th>TOTAL</th><td>Rp '.number_format($resulte['TOTAL_BAYAR'], '0', ',', '.').',-</td></tr>
					<tr><th>JENIS BAYAR</th><td>'.$resulte['JENIS_BAYAR'].'</td></tr>
					<tr><th>WEIGHT</th><td>'.$resulte1['WEIGHT'].' KG</td></tr>
					<tr><th>MEASURE</th><td>'.$resulte1['MEASURE'].' M3</td></tr>
				  </tbody></table></div>';
		}
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(false);
		$this->newtable->action(site_url() . "/plp/approval_billing/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NO_CONT","JENIS_BAYAR","SUBTOTAL","PPN","TOTAL_BAYAR","NO_ORDER"));
		$this->newtable->keys(array("ID","NO_CONT"));
		$this->newtable->numberformat(array("TARIF DASAR","QTY","HARI","TOTAL"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbldetail");
		$this->newtable->set_divid("divtbldetail");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => "<div class='text-center'><strong>".$title."</strong></div>", "info" => $info,"content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	function invoice_kemasan($act, $id){
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
		$sgudang="";
		if($TIPE_ORGANISASI == 'TPS2'){
			$addsql = " AND A.KD_GUDANG_TUJUAN = ".$this->db->escape($KD_GUDANG);
			$sgudang =$KD_GUDANG;
		}
		if(!$this->input->post('ajax')){
			$addsql .= " AND A.WK_REKAM >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)";
		}
		$SQL = "SELECT A.TGL_STATUS,D.ID as IDB,A.ID,A.NO_ORDER AS 'NO ORDER',D.NO_INVOICE as 'NO INVOICE',
				D.TOTAL AS 'TOTAL (Rp)',
				CONCAT('JENIS: ',(case when A.JENIS_TRANSAKSI='B' THEN 'BARU' ELSE 'PERPANJANGAN' END),
				'<BR>NO B/L: ',A.NO_BL_AWB,'<BR>NO CONTAINER: ',A.NO_CONT_ASAL) AS 'TRANSAKSI',
				CONCAT('NAMA : ',IFNULL(A.NAMA_FORWARDER,'-'),'<BR>NPWP : ',IFNULL(A.NPWP_FORWARDER,'-')) AS 'COSTUMER',
				CONCAT('NAMA : ',A.CONSIGNEE,'<BR>NPWP : ',A.NPWP_CONSIGNEE) AS 'PEMILIK', 
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'GUDANG',
				CONCAT('<h4><span class=\"label label-primary\">',C.NAMA,'</span></h4><BR>TGL KONFIRMASI : ',
				IFNULL(DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %h:%i:%s'),'-')) AS 'STATUS',A.CAR, A.KD_STATUS
				FROM t_order_hdr A LEFT JOIN app_user B ON A.ID_USER=B.ID JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='ORDERCFS' 
				JOIN (select bb.ID,bb.NO_ORDER,bb.NO_INVOICE,bb.TOTAL,bb.IS_VOID from t_billing_cfshdr bb
				JOIN (select max(ID) as IDB,NO_ORDER, NO_INVOICE,TOTAL from t_billing_cfshdr group by NO_ORDER) bc on bb.ID=bc.IDB
				where bb.FLAG_APPROVE='Y' and bb.KD_ALASAN_BILLING='ACCEPT' and bb.NO_INVOICE is not null and bb.IS_VOID is null 
				and bb.STATUS_BAYAR='SETTLED') D on A.NO_ORDER=D.NO_ORDER
				WHERE A.KD_STATUS='700' AND D.NO_INVOICE is not null and D.IS_VOID is null".$addsql;
				//var_dump($SQL);die();
		$proses = array(
			'PRINT' => array('PRINT', site_url() . "/order/proses_print/order/invoice", '1', '700', 'icon-printer','','list'),
			'VIEW' => array('MODAL',"order/invoice_kemasan/detail", '1', '', 'icon-magnifier-add','','list')
		);
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG",$sgudang);
    	$arrnamaTagihan = $this->get_combobox("TAGIHAN");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('D.NO_INVOICE','NO. INVOICE'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('A.CONSIGNEE','NAMA PEMILIK'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.JENIS_BAYAR', 'STATUS', 'OPTION', array(''=>'','A'=>'CASH','B'=>'KREDIT'))));
    	}else{
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('D.NO_INVOICE','NO. INVOICE'),array('A.NAMA_FORWARDER','NAMA COSTUMER')));
    	}
		
		$this->newtable->action(site_url() . "/order/invoice_kemasan");
		//$this->newtable->detail(array('POPUP',"order/invoice_kemasan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses2('button');
		$this->newtable->hiddens(array("CAR","ID","KD_STATUS","IDB","TGL_STATUS"));
		$this->newtable->numberformat(array("TOTAL (Rp)"));
		$this->newtable->keys(array("NO ORDER","ID","IDB"));
		$this->newtable->cidb($this->db);
        $this->newtable->validasi(array("KD_STATUS"));
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("A.NO_ORDER"));
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblinvoice_kemasan");
		$this->newtable->set_divid("divtblinvoice_kemasan");
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

	function surat_jalan($act, $id) {
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('SURAT JALAN', 'javascript:void(0)');
		$data['title'] = 'SURAT JALAN';
		$judul = "DATA SURAT JALAN";
		$addsql = '';
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$sgudang="";
		if($TIPE_ORGANISASI == 'TPS2'){
			$addsql = " AND A.KD_GUDANG_TUJUAN = ".$this->db->escape($KD_GUDANG);
			$sgudang =$KD_GUDANG;
		}
		$SQL = "SELECT CONCAT('NO ORDER : ',D.NO_ORDER,'<BR>NO SURAT JALAN : ',D.NO_SP2,'<BR>NO BL : ',A.NO_BL_AWB,'<BR>NO DO : ',A.NO_DO) AS NOMOR, 
		func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG, A.NO_VOYAGE AS 'NO VOYAGE', DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL KEDATANGAN', A.NO_ORDER, D.ID,A.ID AS ID_ORDER,
		CONCAT('NAMA : ',A.NAMA_FORWARDER,'<BR>NPWP : ',func_npwp(A.NPWP_FORWARDER),'<BR>ALAMAT : ',A.ALAMAT_FORWARDER) AS COSTUMER,
		CONCAT('NAMA : ',A.CONSIGNEE,'<BR>NPWP : ',func_npwp(A.NPWP_CONSIGNEE),'<BR>ALAMAT : ',A.ALAMAT_CONSIGNEE) AS PEMILIK
		FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID 
		JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='ORDERCFS' 
		JOIN t_billing_cfshdr D on A.NO_ORDER=D.NO_ORDER
		WHERE A.KD_STATUS IN ('300','400') AND A.NO_ORDER LIKE '10%' and D.NO_SP2 is not null" . $addsql;
		$proses = array(
			'PRINT' => array('PRINT', site_url() . "/order/proses_print/order/cetaksuratjalan", '1', '', 'icon-printer'),
			'VIEW' => array('MODAL',"order/surat_jalan/detail", '1','','icon-magnifier-add')
		);
		$check = (grant() == "W") ? true : false;
		$this->newtable->show_chk(true);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG",$sgudang);
    	$arrnamaTagihan = $this->get_combobox("TAGIHAN");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('A.CONSIGNEE','NAMA PEMILIK'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.JENIS_BAYAR', 'STATUS', 'OPTION', array(''=>'','A'=>'CASH','B'=>'KREDIT'))));
    	}else{
    		$this->newtable->search(array(array('A.NO_BL_AWB','NO. BL'),array('A.NO_SPPB','NO. SPPB'),array('A.NAMA_FORWARDER','NAMA COSTUMER')));
    	}
		//$this->newtable_edit->action(site_url() . "/order/surat_jalan");
		//$this->newtable->detail(array('POPUP',"order/surat_jalan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("NO_ORDER","ID","ID_ORDER"));
		$this->newtable->keys(array("NO_ORDER","ID","ID_ORDER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblsurat_jalan");
		$this->newtable->set_divid("divtblsurat_jalan");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
		echo $tabel;
		else
		return $arrdata;
	}

	function clearing($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('PEMBAYARAN LAYANAN PETIKEMAS', 'javascript:void(0)');
		$data['title'] = 'PEMBAYARAN LAYANAN PETIKEMAS';
		$title = "DATA PEMBAYARAN LAYANAN PETIKEMAS";
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
		$SQL = "SELECT A.ID,A.NO_ORDER AS 'NO PEMBAYARAN PETIKEMAS', 
				CONCAT('NAMA : ',A.NAMA_FORWARDER,'<BR>NPWP : ',func_npwp(A.NPWP_FORWARDER),'<BR>ALAMAT : ',A.ALAMAT_FORWARDER) AS COSTUMER, 
				A.NO_ORDER, CONCAT('TERMINAL ASAL:<BR>',func_name(IFNULL(A.KD_GUDANG_ASAL,'-'),'GUDANG'),'<BR>GUDANG TUJUAN:<BR>',
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG')) AS 'TEMPAT', CONCAT('NO BC 1.1 : ',A.NO_BC11,
				'<BR>TGL BC 1.1 : ',A.TGL_BC11) AS 'BC',CONCAT('NAMA KAPAL : ',A.NM_ANGKUT,'<BR>TGL TIBA :',
				IFNULL(DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y'),'-')) AS 'KAPAL', A.NO_CONT_ASAL AS 'NO CONTAINER',
				CONCAT(IFNULL(C.NAMA,'-'),'<BR>TGL KONFIRM : ',IFNULL(DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y'),'-'),'<BR>TGL BUAT : ',
				IFNULL(DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y'),'-'),'<BR>PETUGAS : ',B.NM_LENGKAP) AS 'STATUS',A.CAR,A.KD_STATUS
				FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='ORDERCFS'
				JOIN t_order_cont D ON A.ID=D.ID
				WHERE  A.NO_ORDER LIKE 'CONT%'".$addsql;//A.KD_STATUS IN ('100','200') AND
		$proses = array(
			'ENTRY'	 => array('ADD_MODAL',"/order/clearing/add", '0','','icon-plus', '', '1'),
			'UPDATE' => array('EDIT_MODAL',"/order/clearing/edit", '1','100','icon-pencil'),
			'DELETE' => array('DELETE', site_url() . "/order/execute/delete/clearing", 'ALL', '100', 'icon-trash'),
			'KIRIM' => array('MODAL', "order/clearing/kirim", '1', '100', 'icon-share-alt')
		);
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG",$sgudang);
    	$arrnamaTPS = $this->get_combobox("TPS");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. PEMBAYARAN PETIKEMAS'),array('A.NO_BL_AWB','NO. BL'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('D.NO_CONT','NO CONTAINER'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_GUDANG_ASAL', 'TERMINAL', 'OPTION', $arrnamaTPS)));
    	}else{
    		$this->newtable->search(array(array('A.NO_ORDER','NO. PEMBAYARAN PETIKEMAS'),array('A.NO_BL_AWB','NO. BL'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('D.NO_CONT','NO CONTAINER')));
    	}
		
		$this->newtable->action(site_url() . "/order/clearing");
		//if($check) $this->newtable->detail(array('POPUP',"clearing/listdata/detail"));
		$this->newtable->detail(array('POPUP',"order/clearing/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("CAR","ID","NO_ORDER","KD_STATUS","NO CONTAINER"));
		$this->newtable->keys(array("NO_ORDER","ID"));
        $this->newtable->validasi(array("KD_STATUS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("A.NO_ORDER"));
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
		$sgudang="";
		if($TIPE_ORGANISASI == 'TPS2'){
			$addsql = " AND A.KD_GUDANG_TUJUAN = ".$this->db->escape($KD_GUDANG);
			$sgudang =$KD_GUDANG;
		}
		$SQL = "SELECT A.ID,A.NO_ORDER AS 'NO PEMBAYARAN PETIKEMAS',D.TOTAL AS 'TOTAL (Rp)',
				CONCAT('NAMA : ',A.NAMA_FORWARDER,'<BR>NPWP : ',func_npwp(A.NPWP_FORWARDER),'<BR>ALAMAT : ',A.ALAMAT_FORWARDER) AS COSTUMER,
				A.NO_ORDER, CONCAT('TERMINAL ASAL:<BR>',func_name(IFNULL(A.KD_GUDANG_ASAL,'-'),'GUDANG'),'<BR>GUDANG TUJUAN:<BR>',
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG')) AS 'TEMPAT',
				CONCAT('NO BC 1.1 : ',A.NO_BC11,'<BR>TGL BC 1.1 : ',A.TGL_BC11) AS 'BC',
				CONCAT('NAMA KAPAL : ',A.NM_ANGKUT,'<BR>TGL TIBA :',IFNULL(DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y'),'-')) AS 'KAPAL',
				A.NO_CONT_ASAL AS 'NO CONTAINER',(case when (D.NO_INVOICE is not null) THEN '200' ELSE '100' END) as INVOICE,
				CONCAT(IFNULL(C.NAMA,'-'),'<BR>TGL KONFIRM : ',IFNULL(DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y'),'-'),'<BR>TGL BUAT : ',
				IFNULL(DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y'),'-'),'<BR>PETUGAS : ',B.NM_LENGKAP) AS 'STATUS',A.CAR,A.KD_STATUS
				FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='ORDERCFS' 
				JOIN t_billing_cfshdr D on A.NO_ORDER=D.NO_ORDER JOIN t_order_cont E ON A.ID=E.ID
				WHERE A.KD_STATUS IN ('300','400') AND A.NO_ORDER LIKE 'CONT%'".$addsql;// and D.NO_INVOICE is null
		$proses = array('PRINT' => array('PRINT', site_url() . "/order/proses_print/order/proforma_invoice2", '1', '100', 'icon-printer'));
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG",$sgudang);
    	$arrnamaTPS = $this->get_combobox("TPS");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. PEMBAYARAN PETIKEMAS'),array('A.NO_BL_AWB','NO. BL'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('E.NO_CONT','NO CONTAINER'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_GUDANG_ASAL', 'TERMINAL', 'OPTION', $arrnamaTPS)));
    	}else{
    		$this->newtable->search(array(array('A.NO_ORDER','NO. PEMBAYARAN PETIKEMAS'),array('A.NO_BL_AWB','NO. BL'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('E.NO_CONT','NO CONTAINER')));
    	}
		
		$this->newtable->action(site_url() . "/order/approval_clearing");
		//if($check) $this->newtable->detail(array('POPUP',"approval_clearing/listdata/detail"));
		$this->newtable->detail(array('POPUP',"order/approval_clearing/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("CAR","ID","NO_ORDER","KD_STATUS","NO CONTAINER","INVOICE"));
		$this->newtable->numberformat(array("TOTAL (Rp)"));
        $this->newtable->validasi(array("INVOICE"));
		$this->newtable->keys(array("NO_ORDER","ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("A.NO_ORDER"));
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

	public function approval_clearing_billing($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		$arrid = explode("~",$id);
		if($act=='sp2'){
			$title = "DAFTAR PETIKEMAS";
			$SQL = "SELECT B.NO_CONT AS 'NO KONTAINER', B.KD_CONT_UKURAN AS 'UKURAN', B.NO_POLISI_TRUCK AS 'NO POLISI TRUCK'
				FROM t_order_hdr A JOIN t_order_cont B ON A.ID=B.ID WHERE A.NO_ORDER =".$this->db->escape($id);
			$info = '';
		}else{
			$title = "DAFTAR TAGIHAN LAYANAN PETIKEMAS";
			$SQL = "select C.NO_ORDER,(case when (D.JENIS_BAYAR = 'A') THEN 'KREDIT' ELSE 'CASH' END) as JENIS_BAYAR,C.SUBTOTAL,C.PPN,C.TOTAL as TOTAL_BAYAR, 
					A.ID, A.NO_CONT, B.DESKRIPSI as 'NAMA ITEM', A.TARIF_DASAR as 'TARIF DASAR', A.QTY, A.TOTAL
					from t_billing_cfsdtl A left join reff_billing_cfs B on A.KODE_BILL=B.KODE_BILL 
					JOIN t_billing_cfshdr C ON C.ID=A.ID JOIN t_order_hdr D ON D.NO_ORDER=C.NO_ORDER
					WHERE A.NO_CONT = ".$this->db->escape($arrid[0])." and C.NO_ORDER=".$this->db->escape($arrid[1]);
			$check = $this->db->query("SELECT B.NO_CONT, func_name(B.KD_UK_CONT,'CONT_UKURAN') AS UKURAN_CONT, SUM(B.TOTAL) AS SUBTOTAL, B.WEIGHT, 
			B.MEASURE from t_billing_cfshdr A join t_billing_cfsdtl B on B.ID=A.ID
			where A.NO_ORDER=".$this->db->escape($arrid[1])." AND B.NO_CONT=".$this->db->escape($arrid[0]));
			$resulte = $check->row_array();
			$info = '<div class="table-responsive"><table class="table m-b-0"><tbody>
					<tr><th width="20%">NO CONTAINER</th><td width="25%">'.$resulte['NO_CONT'].'</td><td width="55%"></td></tr>
					<tr><th>UKURAN CONTAINER</th><td>'.$resulte['UKURAN_CONT'].'</td></tr>
					<tr><th>SUBTOTAL</th><td>Rp '.number_format($resulte['SUBTOTAL'], '0', ',', '.').',-</td></tr>
				  </tbody></table></div>';
		}
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(false);
		$this->newtable->action(site_url() . "/plp/approval_clearing_billing/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("NO_CONT","JENIS_BAYAR","SUBTOTAL","PPN","TOTAL_BAYAR","NO_ORDER","ID"));
		$this->newtable->keys(array("ID","NO_CONT"));
		$this->newtable->numberformat(array("TARIF DASAR","QTY","TOTAL"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldetail");
		$this->newtable->set_divid("divtbldetail");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => "<div class='text-center'><strong>".$title."</strong></div>", "info" => $info,"content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	function invoice_container($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('INVOICE CLEARING PLP', 'javascript:void(0)');
		$data['title'] = 'INVOICE CLEARING PLP';
		$title = "DATA INVOICE CLEARING PLP";
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
		$SQL = "SELECT A.ID,A.NO_ORDER AS 'NO PEMBAYARAN PETIKEMAS',D.TOTAL AS 'TOTAL (Rp)',
				CONCAT('NAMA : ',A.NAMA_FORWARDER,'<BR>NPWP : ',func_npwp(A.NPWP_FORWARDER),'<BR>ALAMAT : ',A.ALAMAT_FORWARDER) AS COSTUMER,
				A.NO_ORDER, CONCAT('TERMINAL ASAL:<BR>',func_name(IFNULL(A.KD_GUDANG_ASAL,'-'),'GUDANG'),'<BR>GUDANG TUJUAN:<BR>',
				func_name(IFNULL(A.KD_GUDANG_TUJUAN,'-'),'GUDANG')) AS 'TEMPAT',
				CONCAT('NO BC 1.1 : ',A.NO_BC11,'<BR>TGL BC 1.1 : ',A.TGL_BC11) AS 'BC',
				CONCAT('NAMA KAPAL : ',A.NM_ANGKUT,'<BR>TGL TIBA :',IFNULL(DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y'),'-')) AS 'KAPAL',
				A.NO_CONT_ASAL AS 'NO CONTAINER',(case when (D.NO_INVOICE is not null) THEN '200' ELSE '100' END) as INVOICE,
				CONCAT(IFNULL(C.NAMA,'-'),'<BR>TGL KONFIRM : ',IFNULL(DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y'),'-'),'<BR>TGL BUAT : ',
				IFNULL(DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y'),'-'),'<BR>PETUGAS : ',B.NM_LENGKAP) AS 'STATUS',A.CAR,A.KD_STATUS
				FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='ORDERCFS' 
				JOIN t_billing_cfshdr D on A.NO_ORDER=D.NO_ORDER JOIN t_order_cont E ON A.ID=E.ID
				WHERE A.KD_STATUS IN ('300','400') AND A.NO_ORDER LIKE 'CONT%' and D.NO_INVOICE is not null".$addsql;
		$proses = array('PRINT' => array('PRINT', site_url() . "/order/proses_print/order/invoice2", '1', '', 'icon-printer'));
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG",$sgudang);
    	$arrnamaTPS = $this->get_combobox("TPS");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. PEMBAYARAN PETIKEMAS'),array('A.NO_BL_AWB','NO. BL'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('E.NO_CONT','NO CONTAINER'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_GUDANG_ASAL', 'TERMINAL', 'OPTION', $arrnamaTPS)));
    	}else{
    		$this->newtable->search(array(array('A.NO_ORDER','NO. PEMBAYARAN PETIKEMAS'),array('A.NO_BL_AWB','NO. BL'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('E.NO_CONT','NO CONTAINER')));
    	}
		
		$this->newtable->action(site_url() . "/order/invoice_container");
		$this->newtable->detail(array('POPUP',"order/invoice_container/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("CAR","ID","NO_ORDER","KD_STATUS","NO CONTAINER","INVOICE"));
		$this->newtable->numberformat(array("TOTAL (Rp)"));
		$this->newtable->keys(array("NO_ORDER","ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("A.NO_ORDER"));
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblinvoice_container");
		$this->newtable->set_divid("divtblinvoice_container");
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

	function sp2($act, $id) {
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('SP2', 'javascript:void(0)');
		$data['title'] = 'SP2';
		$judul = "DATA SP2";
		$addsql = '';
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$sgudang="";
		if($TIPE_ORGANISASI == 'TPS2'){
			$addsql = " AND A.KD_GUDANG_TUJUAN = ".$this->db->escape($KD_GUDANG);
			$sgudang =$KD_GUDANG;
		}
		$SQL = "SELECT CONCAT('NO ORDER : ',A.NO_ORDER,'<BR>NO SP2 : ',D.NO_SP2) AS NOMOR, A.KD_GUDANG_TUJUAN AS GUDANG, 
			CONCAT('NAMA : ',A.NAMA_FORWARDER,'<BR>NPWP : ',func_npwp(A.NPWP_FORWARDER),'<BR>ALAMAT : ',A.ALAMAT_FORWARDER) AS COSTUMER,A.ID,A.NO_ORDER
			FROM t_order_hdr A JOIN app_user B ON A.ID_USER=B.ID JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='ORDERCFS' 
			JOIN t_billing_cfshdr D on A.NO_ORDER=D.NO_ORDER
			WHERE A.KD_STATUS IN ('300','400') AND A.NO_ORDER LIKE 'CONT%' and D.NO_SP2 is not null" . $addsql;
		$proses = array(//'DETAIL' => array('MODAL',"order/surat_jalan/detail", '1','','icon-pencil'),
						'PRINT' => array('PRINT', site_url() . "/order/proses_print/order/cetaksp2", '1', '', 'icon-printer'));
		$check = (grant() == "W") ? true : false;
		$this->newtable->show_chk(true);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG",$sgudang);
    	$arrnamaTagihan = $this->get_combobox("TAGIHAN");
    	if($TIPE_ORGANISASI=="SPA"){
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('D.NO_SP2','NO. SP2'),array('A.NAMA_FORWARDER','NAMA COSTUMER'),array('A.KD_GUDANG_TUJUAN', 'KD GUDANG', 'OPTION', $arrnamaGudang)));
    	}else{
    		$this->newtable->search(array(array('A.NO_ORDER','NO. ORDER'),array('D.NO_SP2','NO. SP2'),array('A.NAMA_FORWARDER','NAMA COSTUMER')));
    	}
		//$this->newtable_edit->action(site_url() . "/order/sp2");
		$this->newtable->detail(array('POPUP',"order/sp2/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","NO_ORDER"));
		$this->newtable->keys(array("NO_ORDER","ID"));
		$this->newtable->validasi(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblsp2");
		$this->newtable->set_divid("divtblsp2");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
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
		$proses = array('DETAIL' => array('MODAL',"order/validasi_manual/detail", '1','','icon-magnifier-add'),
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

	function tarif_dasar($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('TARIF DASAR', 'javascript:void(0)');
		$data['title'] = 'TARIF DASAR';
		$title = "DATA TARIF DASAR";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.ID,A.KODE_BILL AS 'KODE TARIF',A.DESKRIPSI,IFNULL(A.TARIF_DASAR,0) AS 'TARIF DASAR (Rp)',IFNULL(A.KETERANGAN,'-') AS SATUAN,
				IFNULL(A.UKURAN,'-') AS LAYANAN
				FROM reff_billing_cfs A WHERE 1=1".$addsql;
		$proses = array(
			'ENTRY'	 => array('ADD_MODAL',"/order/tarif_dasar/add", '0','','icon-plus', '', 'menu'),
			'UPDATE' => array('EDIT_MODAL',"/order/tarif_dasar/edit", '1','','icon-pencil'),
			'DELETE' => array('DELETE', site_url() . "/order/execute/delete/tarif_dasar", 'ALL', '', 'icon-trash')
		);
		if(!$check) $proses = '';
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_combobox("GUDANG");
    	$arrnamaTPS = $this->get_combobox("TPS");
		$this->newtable->search(array(array('A.KODE_BILL','KODE BILLING'),array('A.DESKRIPSI','DESKRIPSI'),array('A.UKURAN', 'LAYANAN', 'OPTION', array(''=>'','KEMASAN'=>'KEMASAN','20" PETIKEMAS'=>'20" PETIKEMAS','40" PETIKEMAS'=>'40" PETIKEMAS'))));
    	$this->newtable->action(site_url() . "/order/tarif_dasar");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->numberformat(array("TARIF DASAR (Rp)"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbltarif_dasar");
		$this->newtable->set_divid("divtbltarif_dasar");
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

    function pbm($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('ORDER', 'javascript:void(0)');
        $this->newtable->breadcrumb('Perusahaan Bongkar Muat', 'javascript:void(0)');
        $judul = "DAFTAR PERUSAHAAN BONGKAR MUAT";
        $SQL = "SELECT A.ID, A.ID_ORGANISASI AS 'CUSTOMER NUMBER', func_npwp(A.NPWP) as NPWP, A.NAMA AS ORGANISASI, A.ALAMAT, A.NOTELP AS 'NO TELP', A.NOFAX  AS 'NO FAX',
                A.EMAIL, A.JENIS_ORGANISASI FROM t_organisasi A WHERE A.KD_TIPE_ORGANISASI IN('FWD','CONS')";
        $proses = array('ADD' => array('ADD_MODAL', "order/pbm/add", '0', '', 'icon-plus', '', '1'),
            'EDIT' => array('EDIT_MODAL', "order/pbm/edit", '1', '', 'icon-pencil', '', '1'),
            'DELETE' => array('DELETE', site_url() . "/order/execute/delete/pbm", 'ALL', '', 'icon-trash', '', '1'));
		$check = (grant()=="W")?true:false;
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
        $this->newtable->search(array(array('A.NAMA', 'NAMA PBM'),array('A.NPWP', 'NPWP')));
        $this->newtable->action(site_url() . "/order/pbm");
        $this->newtable->hiddens(array("ID"));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblpbm");
        $this->newtable->set_divid("divtblpbm");
        $this->newtable->rowcount(10);
        $this->newtable->clear();
        $this->newtable->menu($proses);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $judul, "content" => $tabel);
        if ($this->input->post("ajax") || $act == "post")
            return $tabel;
        else
            return $arrdata;
    }

	function proses_print($type, $act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        if ($act == "proforma_invoice" || $act == "invoice") {
            $data = array();
            $datadtl = array();
            $arrid = explode("~", $id);
			//CONCAT(D.ADDRESS,IFNULL(CONCAT(', ',D.KELURAHAN),''),IFNULL(CONCAT(', ',D.KECAMATAN),''), IFNULL(CONCAT(', ',D.CITY),''), IFNULL(CONCAT(', ',D.PROVINCE),'')) AS ALAMAT_FORWARDER,
   		    $SQL = "SELECT 	B.NO_FAKTUR, B.NO_INVOICE, A.EX_NOTA, B.NO_PROFORMA_INVOICE,
			D.ADDRESS AS ALAMAT_FORWARDER,D.ALT_NAME as NAMA_FORWARDER,D.NPWP as NPWP_FORWARDER,
			DATE_FORMAT(A.TGL_STRIPPING, '%d-%m-%Y') AS TGL_STRIPPING,A.CONSIGNEE,A.NPWP_CONSIGNEE, A.ALAMAT_CONSIGNEE,
			-- A.NAMA_FORWARDER,A.NPWP_FORWARDER, A.ALAMAT_FORWARDER, D.JENIS_ORGANISASI,
			A.NO_DO,A.NO_BL_AWB, DATE_FORMAT(A.TGL_TIBA, '%d-%m-%Y') AS TGL_TIBA,A.NM_ANGKUT,A.NO_CONT_ASAL,
			A.JENIS_BILLING, (CASE WHEN A.JENIS_TRANSAKSI = 'B' THEN 'BARU' WHEN A.JENIS_TRANSAKSI = 'P' THEN 'PERPANJANGAN' ELSE '' END) as 'JENIS_TRANSAKSI',
			func_name(A.KD_GUDANG_TUJUAN,'GUDANG') as GUDANG, C.WEIGHT, C.MEASURE, C.SATUAN, B.NO_NOTA,C.JNS_KMS, C.JML_KMS,DATE_FORMAT(A.TGL_KELUAR_LAMA, '%d-%m-%Y') AS TGL_KELUAR_LAMA,
			A.NO_ORDER, B.SUBTOTAL, B.PPN, B.TOTAL, DATE_FORMAT(A.TGL_KELUAR, '%d-%m-%Y') AS TGL_KELUAR,
			(CASE WHEN A.JENIS_BAYAR = 'A'THEN 'CASH' WHEN A.JENIS_BAYAR = 'A'THEN 'KREDIT' ELSE '' END) AS 'JENIS_PEMBAYARAN'
			FROM t_order_hdr A JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER JOIN t_billing_cfsdtl C ON B.ID=C.ID
			-- LEFT JOIN t_organisasi D ON D.NPWP=A.NPWP_FORWARDER
			JOIN mst_customer D ON (D.NPWP=ifnull(A.NPWP_FORWARDER,A.NPWP_CONSIGNEE) or D.PASSPORT=ifnull(A.NPWP_FORWARDER,A.NPWP_CONSIGNEE)) and D.STATUS_CUSTOMER='A' and D.STATUS_APPROVAL='A'
			WHERE A.NO_ORDER=".$this->db->escape($arrid[0])." AND A.ID=".$this->db->escape($arrid[1])." AND B.ID=".$this->db->escape($arrid[2])." LIMIT 1";
	
			$SQL2 = "select C.DESKRIPSI, B.QTY, B.SATUAN, B.TARIF_DASAR, B.HARI, B.TOTAL from t_billing_cfshdr A 
					join t_billing_cfsdtl B on A.ID=B.ID left JOIN reff_billing_cfs C on C.KODE_BILL=B.KODE_BILL
					WHERE A.ID=".$this->db->escape($arrid[2]);
            $hasil = $func->main->get_result($SQL);
            if ($hasil) {
                foreach ($SQL->result_array() as $row => $value) {
                    $data = $value;
                }
            }
		
			$SQLDTL = "SELECT * FROM t_billing_hdr A WHERE A.ID = " . $this->db->escape($arrid[1]);
            $hasil = $func->main->get_result($SQL2);
            if ($hasil) {
                foreach ($SQL2->result_array() as $row => $value) {
                    $datadtl1[] = $value;
                }
				$datadtl2=$SQL2->result_array();
            }
            $returnArray = array('data' => $data,
                'datadtl' => $datadtl1
            );
            return $returnArray;
        } else if ($act == "proforma_invoice2" || $act == "invoice2") {
            $data = array();
            $datadtl = array();
            $arrid = explode("~", $id);
           
   		    $SQL = "SELECT 	B.NO_FAKTUR, B.NO_INVOICE, B.NO_NOTA, B.NO_PROFORMA_INVOICE,func_name(A.KD_GUDANG_ASAL,'GUDANG') as TERMINAL_ASAL,
						A.CONSIGNEE,func_npwp(A.NPWP_CONSIGNEE) as NPWP_CONSIGNEE, A.ALAMAT_CONSIGNEE,
 						A.NAMA_FORWARDER,func_npwp(A.NPWP_FORWARDER) as NPWP_FORWARDER, A.ALAMAT_FORWARDER,D.JENIS_ORGANISASI,
						A.NO_DO,A.NO_BL_AWB, DATE_FORMAT(A.TGL_TIBA, '%d-%m-%Y') AS TGL_TIBA,A.NM_ANGKUT,A.NO_CONT_ASAL,A.JENIS_BILLING, 
						func_name(A.KD_GUDANG_TUJUAN,'GUDANG') as GUDANG, C.WEIGHT, C.MEASURE, 
						A.NO_ORDER, B.SUBTOTAL, B.PPN, B.TOTAL,DATE_FORMAT(A.TGL_KELUAR, '%d-%m-%Y') AS TGL_KELUAR,
						(CASE WHEN A.JENIS_BAYAR = 'A'THEN 'CASH' WHEN A.JENIS_BAYAR = 'A'THEN 'KREDIT' ELSE '' END) AS 'JENIS_PEMBAYARAN'
					FROM t_order_hdr A JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER JOIN t_billing_cfsdtl C ON B.ID=C.ID
					LEFT JOIN t_organisasi D ON D.NPWP=A.NPWP_FORWARDER
					WHERE A.NO_ORDER=".$this->db->escape($arrid[0])." AND A.ID=".$this->db->escape($arrid[1])."LIMIT 1";
			
			$SQLdtl = "select distinct B.NO_CONT from t_billing_cfshdr A 
					join t_billing_cfsdtl B on A.ID=B.ID
					WHERE A.NO_ORDER=".$this->db->escape($arrid[0]);
            $hasil = $func->main->get_result($SQL);
            if ($hasil) {
                foreach ($SQL->result_array() as $row => $value) {
                    $data = $value;
                }
            }
		
			$SQL2 = "SELECT C.DESKRIPSI, A.KD_UK_CONT as SIZE, COUNT(A.KODE_BILL) AS QTY, A.SATUAN, A.TARIF_DASAR, 
			(A.TARIF_DASAR * COUNT(A.KODE_BILL)) AS TOT	FROM t_billing_cfsdtl A left JOIN t_billing_cfshdr B ON A.ID=B.ID 
			left JOIN reff_billing_cfs C on C.KODE_BILL=A.KODE_BILL WHERE B.NO_ORDER = " . $this->db->escape($arrid[0])."
			GROUP BY A.KODE_BILL, A.KD_UK_CONT order by A.KD_UK_CONT, C.DESKRIPSI";
            $hasil = $func->main->get_result($SQL2);
            if ($hasil) {
                foreach ($SQL2->result_array() as $row => $value) {
                    $datadtl1[] = $value;
                }
				$datadtl2=$SQL2->result_array();
            }
            $returnArray = array('data' => $data,
                'datadtl' => $datadtl1
            );
            return $returnArray;
        } elseif ($act == "cetaksuratjalan") {
            $data = array();
            $datadtl = array();
            $arrid = explode("~", $id);
   		    $SQL = "SELECT 	B.NO_FAKTUR, B.NO_INVOICE, B.NO_NOTA, B.NO_PROFORMA_INVOICE,DATE_FORMAT(A.TGL_KELUAR,'%d-%m-%Y') AS TGL_KELUAR,
						A.CONSIGNEE,func_npwp(A.NPWP_CONSIGNEE) as NPWP_CONSIGNEE, A.ALAMAT_CONSIGNEE,
						A.NAMA_FORWARDER,func_npwp(A.NPWP_FORWARDER) as NPWP_FORWARDER, A.ALAMAT_FORWARDER,
						A.NO_DO,A.NO_BL_AWB, DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA,A.NM_ANGKUT,A.NO_CONT_ASAL,A.JENIS_BILLING, 
						func_name(A.KD_GUDANG_TUJUAN,'GUDANG') as GUDANG, C.WEIGHT, C.MEASURE, B.NO_SP2,
						A.NO_ORDER, B.SUBTOTAL, B.PPN, B.TOTAL,D.NO_POLISI_TRUCK, A.NO_VOYAGE,
						(CASE WHEN A.JENIS_BAYAR = 'A'THEN 'KREDIT' WHEN A.JENIS_BAYAR = 'A'THEN 'CASH' ELSE '' END) AS 'JENIS_PEMBAYARAN'
					FROM t_order_hdr A JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER JOIN t_billing_cfsdtl C ON B.ID=C.ID JOIN t_order_kms D ON A.ID=D.ID
					WHERE A.NO_ORDER=".$this->db->escape($arrid[0])." AND A.ID=".$this->db->escape($arrid[2])." LIMIT 1";
			$SQL2 = "select B.MRK_KMS, B.JNS_KMS, B.JML_KMS, B.WEIGHT, B.MEASURE from t_billing_cfshdr A 
					join t_billing_cfsdtl B on A.ID=B.ID left JOIN reff_billing_cfs C on C.KODE_BILL=B.KODE_BILL
					WHERE A.NO_ORDER=".$this->db->escape($arrid[0])." GROUP BY B.MRK_KMS";
			//print_r($SQL);die();
            $hasil = $func->main->get_result($SQL);
            if ($hasil) {
                foreach ($SQL->result_array() as $row => $value) {
                    $data = $value;
                }
            }
		
			$SQLDTL = "SELECT * FROM t_billing_hdr A WHERE A.ID = " . $this->db->escape($arrid[1]);
            $hasil = $func->main->get_result($SQL2);
            if ($hasil) {
                foreach ($SQL2->result_array() as $row => $value) {
                    $datadtl1[] = $value;
                }
				$datadtl2=$SQL2->result_array();
            }
            $returnArray = array('data' => $data,
                'datadtl' => $datadtl1
            );
            return $returnArray;
        } elseif ($act == "cetaksp2") {
            $data = array();
            $datadtl = array();
            $arrid = explode("~", $id);
   		    $SQL2 = "select B.NO_CONT, func_name(B.KD_CONT_UKURAN,'CONT_UKURAN') as UK_CONT, A.NM_ANGKUT, A.NAMA_AGEN,A.NO_VOYAGE,
					A.CONSIGNEE,func_npwp(A.NPWP_CONSIGNEE) as NPWP_CONSIGNEE, A.ALAMAT_CONSIGNEE,DATE_FORMAT(A.TGL_KELUAR,'%d-%m-%Y') AS TGL_KELUAR,
					func_name(A.KD_GUDANG_TUJUAN,'GUDANG') as GUDANG, A.NAMA_FORWARDER, A.ALAMAT_FORWARDER, B.NO_POLISI_TRUCK,A.NO_ORDER,
					C.NO_SP2, DATE_FORMAT(A.TGL_TIBA, '%d-%m-%y') AS TGL_TIBA, A.NO_BL_AWB, A.NO_DO
					from t_order_hdr A join t_order_cont B on A.ID=B.ID join t_billing_cfshdr C on C.NO_ORDER=A.NO_ORDER
					WHERE A.NO_ORDER=".$this->db->escape($arrid[0])." AND A.ID=".$this->db->escape($arrid[1]);
            $hasil = $func->main->get_result($SQL2);
            if ($hasil) {
                foreach ($SQL2->result_array() as $row => $value) {
                    $datadtl1[] = $value;
                }
            }
            $returnArray = array(
                'datadtl' => $datadtl1
            );
            return $returnArray;
        }
    }

    function input_manual($act, $id) {
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Order', 'javascript:void(0)');
		$this->newtable->breadcrumb('INPUT PEMBAYARAN MANUAL', 'javascript:void(0)');
		$data['title'] = 'INPUT PEMBAYARAN MANUAL';
		$judul = "DATA INPUT PEMBAYARAN MANUAL";
		$addsql = '';
		$SQL = "SELECT A.ID,A.NO_ORDER AS NO_ORDER,	CONCAT('NAMA_PEMILIK : ',A.NAMA_PEMILIK,'<BR>NPWP PEMILIK : ',A.NPWP_PEMILIK) AS 'PEMILIK',
			A.NO_INVOICE AS 'NOMOR FAKTUR',A.NO_PROFORMA_INVOICE AS 'NOMOR PROFORMA INVOICE', A.AMOUNT AS 'TOTAL TAGIHAN'
			FROM t_edc_payment_bank A WHERE A.FL_EDC='N'" . $addsql;
			//var_dump($SQL);die();
		$proses = array('INSERT' => array('MODAL', "order/input_manual/insert", '0', '', 'icon-plus', '', 'menu'));
		$check = (grant() == "W") ? true : false;
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('A.NAMA_PEMILIK','NAMA PEMILIK'),array('A.NPWP_PEMILIK','NPWP PEMILIK'),array('A.TGL_TERIMA','TANGGAL','DATERANGE2')));
		$this->newtable->action(site_url() . "/order/input_manual");
		// $this->newtable->detail(array('POPUP',"order/input_manual/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->numberformat(array("TOTAL TAGIHAN"));
		$this->newtable->keys(array("ID"));
		$this->newtable->validasi(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbledc");
		$this->newtable->set_divid("divtbledc");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
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
					A.NPWP_CONSIGNEE, A.CONSIGNEE, A.NO_BL_AWB, A.NM_ANGKUT, A.KD_GUDANG_TUJUAN,A.EX_NOTA,
					(CASE A.JENIS_TRANSAKSI WHEN 'B' THEN 'BARU' WHEN 'P' THEN 'PERPANJANGAN' ELSE '' END) AS JENIS_T, 
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
				
				if($this->input->post('KD_GUDANG_TUJUAN')=='BAND'){
					$kod='02';
				}elseif($this->input->post('KD_GUDANG_TUJUAN')=='RAYA'){
					$kod='01';
				}elseif($this->input->post('KD_GUDANG_TUJUAN')=='PSKA'){
					$kod='03';
				}else{
					$error += 1;
					$message .= "Kode Gudang tidak dikenali";
				}
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
				  'KD_KPBC'				=> ($this->input->post('KD_KPBC') == '')?'040300':trim(validate($this->input->post('KD_KPBC'))),
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
				if ($DATA['TGL_TIBA']<'2017-11-20') {
					$error += 1;
					$message .= "Tidak menerima order dengan ETA Kapal dibawah tanggal 20 November 2017.";
				}
				if ($DATA['CUSTOMER_NUMBER']==null) {
					$check = $this->db->query("select A.CUSTOMER_ID from mst_customer A WHERE A.STATUS_CUSTOMER='A' AND A.STATUS_APPROVAL='A' AND (A.NPWP='".$DATA['NPWP_CONSIGNEE']."' or A.PASSPORT='".$DATA['NPWP_CONSIGNEE']."')");
					$resulte = $check->row_array();
					if($resulte['CUSTOMER_ID']==""){
						$error += 1;
						$message .= "Customer tidak aktif atau belum terdaftar di sistem CDM. Silahkan hubungi CS Cabang Tanjung Priok.";
					}else{
						$DATA['CUSTOMER_NUMBER']=$resulte['CUSTOMER_ID'];
					}
				}
				$TGL_BL_AWB= ($DATA['TGL_BL_AWB']==null)?"":" AND A.TGL_BL_AWB='".$DATA['TGL_BL_AWB']."'";
				$check = $this->db->query("select A.TGL_KELUAR from t_order_hdr A WHERE A.NO_BL_AWB='".$DATA['NO_BL_AWB']."'".$TGL_BL_AWB." AND A.KD_STATUS not in ('600','700','800') order by A.ID desc limit 1");
				if($check->num_rows()>0){
					$error += 1;
					$message .= "Tidak dapat menambah order.";
				}
				if ($error < 1) {
					$check = $this->db->query("select A.TGL_KELUAR from t_order_hdr A JOIN t_billing_cfshdr B on B.NO_ORDER=A.NO_ORDER WHERE A.NO_BL_AWB='".$DATA['NO_BL_AWB']."'".$TGL_BL_AWB." AND A.KD_STATUS <> '600' and B.IS_VOID is null order by A.ID desc limit 1");
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
					$check = $this->db->query("select B.* from t_permit_hdr A LEFT JOIN t_permit_kms B on B.ID=A.ID WHERE A.NO_BL_AWB='".$DATA['NO_BL_AWB']."'".$TGL_BL_AWB);
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
			}elseif($act == 'restitusi'){
				if($this->input->post('KD_GUDANG_TUJUAN')=='BAND'){
					$kod='02';
				}elseif($this->input->post('KD_GUDANG_TUJUAN')=='RAYA'){
					$kod='01';
				}else{
					$error += 1;
					$message .= "Kode Gudang tidak dikenali";
				}
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
				  'EX_NOTA'				=> $this->input->post('EX_NOTA'),
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
				  'KD_KPBC'				=> ($this->input->post('KD_KPBC') == '')?'040300':trim(validate($this->input->post('KD_KPBC'))),
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
				if ($DATA['TGL_TIBA']<'2017-11-20') {
					$error += 1;
					$message .= "Tidak menerima order dengan ETA Kapal dibawah tanggal 20 November 2017.";
				}
				if ($DATA['CUSTOMER_NUMBER']==null) {
					$check = $this->db->query("select A.CUSTOMER_ID from mst_customer A WHERE A.STATUS_CUSTOMER='A' AND A.STATUS_APPROVAL='A' AND (A.NPWP='".$DATA['NPWP_CONSIGNEE']."' or A.PASSPORT='".$DATA['NPWP_CONSIGNEE']."')");
					$resulte = $check->row_array();
					if($resulte['CUSTOMER_ID']==""){
						$error += 1;
						$message .= "Consignee belum terdaftar di sistem CDM. Silahkan daftarkan melalui CS Cabang Tanjung Priok.";
					}else{
						$DATA['CUSTOMER_NUMBER']=$resulte['CUSTOMER_ID'];
					}
				}
				if ($error < 1) {
					$result = $this->db->insert('t_order_hdr', $DATA);
					$id_permit = $this->db->insert_id();
					$check = $this->db->query("select B.* from t_order_hdr A LEFT JOIN t_order_kms B on B.ID=A.ID WHERE A.ID=".$this->input->post('ID_PERMIT'));
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
						echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/restitusi/post";
				} else {
						echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'edc'){
				$NO_ORDER = trim(validate($this->input->post('NO_ORDER')));
				$SQL = $this->db->query("SELECT ID, TOTAL, NO_PROFORMA_INVOICE FROM t_billing_cfshdr WHERE NO_ORDER = '". $NO_ORDER ."' and FLAG_APPROVE='Y' and KD_ALASAN_BILLING='ACCEPT'");
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
				  'ID_USER'				=> $this->newsession->userdata('ID'),
				  'BUNDLED_INVOICE_KEY'	=> ($this->input->post('BUNDLED_INVOICE_KEY') == '')?null:trim(validate($this->input->post('BUNDLED_INVOICE_KEY'))),
				  'BANK'				=> trim(validate($this->input->post('BANK'))),
				  'NO_ORDER'			=> trim(validate($this->input->post('NO_ORDER'))),
				  'NAMA_PEMILIK'		=> trim(validate($this->input->post('NAMA_PEMILIK'))),
				  'NPWP_PEMILIK'		=> trim(validate($this->input->post('NPWP_PEMILIK'))),
				  'AMOUNT'				=> $arrdata['TOTAL'],//ini  
				  'TGL_TERIMA'			=> date('Y-m-d H:i:s'),
				  'REFF_NO'				=> ($this->input->post('REFF_NO') == '')?null:trim(validate($this->input->post('REFF_NO'))),
				  'TRACE_NO'			=> ($this->input->post('TRACE_NO') == '')?null:trim(validate($this->input->post('TRACE_NO'))),
				  'APPR_CODE'			=> ($this->input->post('APPROVAL_CODE') == '')?null:trim(validate($this->input->post('APPROVAL_CODE'))),
				  'NO_PROFORMA_INVOICE'	=> $arrdata['NO_PROFORMA_INVOICE'],
				  // 'NO_INVOICE'		=> '000.000-17.'.substr(trim(validate($this->input->post('NO_ORDER'))), 12)
				  'NO_INVOICE'			=> $NOINV  
				);
				$DATAUPDATE= array(
				  'STATUS_BAYAR'		=> 'SETTLED', 
				  // 'NO_INVOICE'		=> '000.000-17.'.substr(trim(validate($this->input->post('NO_ORDER'))), 12),
				  'NO_INVOICE'			=> $NOINV,
				  'NO_SP2'				=> substr($DATA['NO_ORDER'], 12)  
				);
				// print_r($DATA);die();
				$result1 = $this->db->insert('t_edc_payment_bank', $DATA);

				if ($result1) {
					$cekgudang = substr($DATA['NO_ORDER'], 2, 2);
					if($cekgudang=="01"){
						$xml = '<?xml version="1.0" encoding="UTF-8"?>';
						$xml .= '<DOCUMENT>';
						$xml .= '<RESPONPEMBAYARANCFS>';
						$xml .= '<NO_ORDER>' . $DATA['NO_ORDER'] . '</NO_ORDER>';
						$xml .= '<NO_INVOICE>' . $DATA['NO_INVOICE'] . '</NO_INVOICE>';
						$xml .= '<TGL_BAYAR>' . $DATA['TGL_TERIMA'] . '</TGL_BAYAR>';
						$xml .= '<TOTAL_BAYAR>' . $DATA['AMOUNT'] . '</TOTAL_BAYAR>';
						$xml .= '</RESPONPEMBAYARANCFS>';
						$xml .= '</DOCUMENT>';
						$WSDLSOAPAPW = 'Https://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
						//$WSDLSOAPAPW = 'Http://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
						$Send = $this->SendCurl($xml, $WSDLSOAPAPW, '');
						if ($Send['response'] != '') {
							$response = $Send['response'];
							$this->db->where(array('NO_ORDER' => $DATA['NO_ORDER'],
							'NO_PROFORMA_INVOICE' => $DATA['NO_PROFORMA_INVOICE']));
							$this->db->update('t_billing_cfshdr', array('FL_SEND'=>'200'));
						} else {
							$response = 'Cannot get response; '.implode("; ",$Send['info']);
						}
						$DATAlog= array(
							'USERNAME'=>'RAYA','PASSWORD'=>'RAYA','URL'=>$WSDLSOAPAPW,'METHOD'=>'SendResponPembayaranCFS',
							'REQUEST'=>$xml,'RESPONSE'=>$response,'IP_ADDRESS'=>$this->getIP(),'WK_REKAM'=>date('Y-m-d H:i:s')
						);
						$this->db->insert('app_log_services', $DATAlog);
					}else if($cekgudang=="03"){
						/* $xml = '<?xml version="1.0" encoding="UTF-8"?>';
						$xml .= '<DOCUMENT>';
						$xml .= '<RESPONPEMBAYARANCFS>';
						$xml .= '<NO_ORDER>' . $DATA['NO_ORDER'] . '</NO_ORDER>';
						$xml .= '<NO_INVOICE>' . $DATA['NO_INVOICE'] . '</NO_INVOICE>';
						$xml .= '<TGL_BAYAR>' . $DATA['TGL_TERIMA'] . '</TGL_BAYAR>';
						$xml .= '<TOTAL_BAYAR>' . $DATA['AMOUNT'] . '</TOTAL_BAYAR>';
						$xml .= '</RESPONPEMBAYARANCFS>';
						$xml .= '</DOCUMENT>';
						$WSDLSOAPAPW = 'Https://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
						//$WSDLSOAPAPW = 'Http://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
						$Send = $this->SendCurl($xml, $WSDLSOAPAPW, '');
						if ($Send['response'] != '') {
							$response = $Send['response'];
							$this->db->where(array('NO_ORDER' => $DATA['NO_ORDER'],
							'NO_PROFORMA_INVOICE' => $DATA['NO_PROFORMA_INVOICE']));
							$this->db->update('t_billing_cfshdr', array('FL_SEND'=>'200'));
						} else {
							$response = 'Cannot get response; '.implode("; ",$Send['info']);
						}
						$DATAlog= array(
							'USERNAME'=>'RAYA','PASSWORD'=>'RAYA','URL'=>$WSDLSOAPAPW,'METHOD'=>'SendResponPembayaranCFS',
							'REQUEST'=>$xml,'RESPONSE'=>$response,'IP_ADDRESS'=>$this->getIP(),'WK_REKAM'=>date('Y-m-d H:i:s')
						);
						$this->db->insert('app_log_services', $DATAlog); */
					}
					$this->db->where(array('NO_ORDER' => $DATA['NO_ORDER'],'NO_PROFORMA_INVOICE' => $DATA['NO_PROFORMA_INVOICE']));
					$result2 = $this->db->update('t_billing_cfshdr', $DATAUPDATE);
					$this->db->where(array('NO_ORDER' => $DATA['NO_ORDER']));
					$result2 = $this->db->update('t_order_hdr', array('KD_STATUS'=>'700'));
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
				$TGL_BL_AWB= ($DATA['TGL_BL_AWB']==null)?"":" AND A.TGL_BL_AWB='".$DATA['TGL_BL_AWB']."'";
				if($DATA['NO_BL_AWB']!=trim(validate($this->input->post('NO_BL_AWB1')))){
					$check = $this->db->query("select A.TGL_KELUAR from t_order_hdr A WHERE A.NO_BL_AWB='".$DATA['NO_BL_AWB']."'".$TGL_BL_AWB." AND A.KD_STATUS not in ('600','700') order by A.ID desc limit 1");
					$resulte = $check->row_array();
					if($resulte['TGL_KELUAR']!=""){
						$DATA['TGL_KELUAR_LAMA']=$resulte['TGL_KELUAR'];
						$DATA['JENIS_TRANSAKSI']='P';
					}else{
						$DATA['TGL_KELUAR_LAMA']=null;
						$DATA['JENIS_TRANSAKSI']='B';
					}
				}
				if ($DATA['TGL_DO']!=null) {
					if ($DATA['TGL_KELUAR'] < $DATA['TGL_DO']) {
						$error += 1;
						$message .= "Tanggal keluar tidak boleh kurang dari tanggal DO";
					} else if ($DATA['TGL_KELUAR'] > $DATA['TGL_EXPIRED_DO']) {
						$error += 1;
						$message .= "Tanggal keluar tidak boleh melebihi dari tanggal expired DO";
					}
				}
				if ($DATA['TGL_TIBA']<'2017-11-20') {
					$error += 1;
					$message .= "Tidak menerima order dengan ETA Kapal dibawah tanggal 20 November 2017.";
				}
				if ($DATA['CUSTOMER_NUMBER']==null) {
					$check = $this->db->query("select A.CUSTOMER_ID from mst_customer A WHERE A.STATUS_CUSTOMER='A' AND A.STATUS_APPROVAL='A' AND (A.NPWP='".$DATA['NPWP_CONSIGNEE']."' or A.PASSPORT='".$DATA['NPWP_CONSIGNEE']."')");
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
			}elseif($act == 'restitusi'){
				foreach ($this->input->post('tb_chktblrestitusi') as $chkitem) {
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
				  echo "MSG#OK#Successfully to be processed#". site_url() . "/order/restitusi/post";
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
				$SQLHeader = "SELECT A.ID, A.NO_ORDER, A.JENIS_BILLING, A.JENIS_BAYAR, DATE_FORMAT(A.TGL_KELUAR,'%Y%m%d') AS TGL_KELUAR, A.NO_MASTER_BL_AWB, 
				DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%Y%m%d') AS TGL_MASTER_BL_AWB, A.NO_BL_AWB, DATE_FORMAT(A.TGL_BL_AWB,'%Y%m%d') AS TGL_BL_AWB, A.NO_DO, 
				DATE_FORMAT(A.TGL_DO,'%Y%m%d') AS TGL_DO, DATE_FORMAT(A.TGL_EXPIRED_DO,'%Y%m%d') AS TGL_EXPIRED_DO, A.NAMA_FORWARDER, A.NPWP_FORWARDER, A.ALAMAT_FORWARDER, 
				A.NO_PERMOHONAN_CFS, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_ASAL, A.KD_GUDANG_TUJUAN, A.NO_BC11, DATE_FORMAT(A.TGL_BC11,'%Y%m%d') AS TGL_BC11, A.NO_CONT_ASAL, 
				IFNULL(A.KD_DOK_INOUT,A.KODE_DOK) AS KD_DOK_INOUT, IFNULL(A.NO_DOK_INOUT,A.NO_SPPB) AS NO_DOK_INOUT, IFNULL(DATE_FORMAT(A.TGL_DOK_INOUT,'%Y%m%d'),DATE_FORMAT(A.TGL_SPPB,'%Y%m%d')) AS TGL_DOK_INOUT, A.CONSIGNEE, A.NPWP_CONSIGNEE, A.NM_ANGKUT, A.NO_VOYAGE,A.JENIS_TRANSAKSI,A.TGL_KELUAR_LAMA , B.NO_POLISI_TRUCK 
				FROM t_order_hdr A INNER JOIN t_order_kms B ON A.ID = B.ID WHERE A.ID = '" . $arrchk[1] . "'";
				$result = $func->main->get_result($SQLHeader);
				foreach ($SQLHeader->result_array() as $row => $value) {
					$arrdata = $value;
				}
				$ID = $arrdata['ID'];
				$NO_ORDER = $arrdata['NO_ORDER'];
				$JENIS_BILLING = $arrdata['JENIS_BILLING'];
				$JENIS_BAYAR = $arrdata['JENIS_BAYAR'];
				$TGL_KELUAR = $arrdata['TGL_KELUAR'];
				$NO_MASTER_BL_AWB = $arrdata['NO_MASTER_BL_AWB'];
				$TGL_MASTER_BL_AWB = $arrdata['TGL_MASTER_BL_AWB'];
				$NO_BL_AWB = $arrdata['NO_BL_AWB'];
				$TGL_BL_AWB = $arrdata['TGL_BL_AWB'];
				$NO_DO = $arrdata['NO_DO'];
				$TGL_DO = $arrdata['TGL_DO'];
				$TGL_EXPIRED_DO = $arrdata['TGL_EXPIRED_DO'];
				$NAMA_FORWARDER = str_replace("'", '', str_replace('&', '&amp;', $arrdata['NAMA_FORWARDER']));
				$NPWP_FORWARDER = $arrdata['NPWP_FORWARDER'];
				$ALAMAT_FORWARDER = str_replace("'", '', str_replace('&', '&amp;', $arrdata['ALAMAT_FORWARDER']));
				$NO_PERMOHONAN_CFS = $arrdata['NO_PERMOHONAN_CFS'];
				$KD_TPS_ASAL = $arrdata['KD_TPS_ASAL'];
				$KD_TPS_TUJUAN = $arrdata['KD_TPS_TUJUAN'];
				$KD_GUDANG_ASAL = $arrdata['KD_GUDANG_ASAL'];
				$KD_GUDANG_TUJUAN = $arrdata['KD_GUDANG_TUJUAN'];
				$NO_BC11 = $arrdata['NO_BC11'];
				$TGL_BC11 = $arrdata['TGL_BC11'];
				$NO_CONT_ASAL = $arrdata['NO_CONT_ASAL'];
				$KD_DOK_INOUT = $arrdata['KD_DOK_INOUT'];
				$NO_DOK = $arrdata['NO_DOK_INOUT'];
				$TGL_DOK = $arrdata['TGL_DOK_INOUT'];
				$CONSIGNEE = str_replace("'", '', str_replace('&', '&amp;', $arrdata['CONSIGNEE']));
				$NPWP_CONSIGNEE = $arrdata['NPWP_CONSIGNEE'];
				$NM_ANGKUT = $arrdata['NM_ANGKUT'];
				$NO_VOYAGE = $arrdata['NO_VOYAGE'];
				$TGL_TIBA = $arrdata['TGL_TIBA'];
				$JENIS_TRANSAKSI = $arrdata['JENIS_TRANSAKSI'];
				$TGL_KELUAR_LAMA = $arrdata['TGL_KELUAR_LAMA'];
				$NO_POLISI_TRUCK = $arrdata['NO_POLISI_TRUCK'];

				//create xml
				$message = '<?xml version="1.0" encoding="UTF-8"?>';
				$message .= '<DOCUMENT>';
				$message .= '<ORDERPENGELUARANBARANG>';
				$message .= '<HEADER>';
				$message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
				$message .= '<JENIS_BILLING>' . $JENIS_BILLING . '</JENIS_BILLING>';
				$message .= '<JENIS_BAYAR>' . $JENIS_BAYAR . '</JENIS_BAYAR>';
				$message .= '<JENIS_TRANSAKSI>' . $JENIS_TRANSAKSI . '</JENIS_TRANSAKSI>';
				$message .= '<TGL_KELUAR_LAMA>' . $TGL_KELUAR_LAMA . '</TGL_KELUAR_LAMA>';
				$message .= '<TGL_KELUAR>' . $TGL_KELUAR . '</TGL_KELUAR>';
				$message .= '<NO_MASTER_BL_AWB>' . $NO_MASTER_BL_AWB . '</NO_MASTER_BL_AWB>';
				$message .= '<TGL_MASTER_BL_AWB>' . $TGL_MASTER_BL_AWB . '</TGL_MASTER_BL_AWB>';
				$message .= '<NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>';
				$message .= '<TGL_BL_AWB>' . $TGL_BL_AWB . '</TGL_BL_AWB>';
				$message .= '<NO_DO>' . $NO_DO . '</NO_DO>';
				$message .= '<TGL_DO>' . $TGL_DO . '</TGL_DO>';
				$message .= '<TGL_EXPIRED_DO>' . $TGL_EXPIRED_DO . '</TGL_EXPIRED_DO>';
				$message .= '<NAMA_FORWARDER>' . $NAMA_FORWARDER . '</NAMA_FORWARDER>';
				$message .= '<NPWP_FORWARDER>' . $NPWP_FORWARDER . '</NPWP_FORWARDER>';
				$message .= '<ALAMAT_FORWARDER>' . $ALAMAT_FORWARDER . '</ALAMAT_FORWARDER>';
				$message .= '<KD_GUDANG_TUJUAN>' . $KD_GUDANG_TUJUAN . '</KD_GUDANG_TUJUAN>';
				$message .= '<NO_BC11>' . $NO_BC11 . '</NO_BC11>';
				$message .= '<TGL_BC11>' . $TGL_BC11 . '</TGL_BC11>';
				$message .= '<NO_CONT_ASAL>' . $NO_CONT_ASAL . '</NO_CONT_ASAL>';
				$message .= '<KD_DOK_INOUT>' . $KD_DOK_INOUT . '</KD_DOK_INOUT>';
				$message .= '<NO_DOK>' . $NO_DOK . '</NO_DOK>';
				$message .= '<TGL_DOK>' . $TGL_DOK . '</TGL_DOK>';
				$message .= '<CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>';
				$message .= '<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>';
				$message .= '<NM_ANGKUT>' . $NM_ANGKUT . '</NM_ANGKUT>';
				$message .= '<NO_VOYAGE>' . $NO_VOYAGE . '</NO_VOYAGE>';
				$message .= '<TGL_TIBA>' . $TGL_TIBA . '</TGL_TIBA>';
				$message .= '<NO_POLISI_TRUCK>' . $NO_POLISI_TRUCK . '</NO_POLISI_TRUCK>';
				$message .= '</HEADER>';
				
				$SQLDetilKms = "SELECT A.JNS_KMS, A.MERK_KMS, A.JML_KMS FROM t_order_kms A WHERE A.ID = '" . $arrchk[1] . "'";
				$resultKms = $func->main->get_result($SQLDetilKms);
				if ($resultKms) {
					$message .= '<DETIL>';
					foreach ($SQLDetilKms->result_array() as $row) {
						$JNS_KMS = $row['JNS_KMS'];
						$MERK_KMS = str_replace('&', '&amp;', $row['MERK_KMS']);
						$JML_KMS = $row['JML_KMS'];
						$message .= '<KEMASAN>';
						$message .= '<JNS_KMS>' . $JNS_KMS . '</JNS_KMS>';
						$message .= '<MERK_KMS>' . $MERK_KMS . '</MERK_KMS>';
						$message .= '<JML_KMS>' . $JML_KMS . '</JML_KMS>';
						$message .= '</KEMASAN>';
					}
					$message .= '</DETIL>';
				} else {
					$message .= '<DETIL>';
					$message .= '<KEMASAN>';
					$message .= '<JNS_KMS></JNS_KMS>';
					$message .= '<MERK_KMS></MERK_KMS>';
					$message .= '<JML_KMS></JML_KMS>';
					$message .= '</KEMASAN>';
					$message .= '</DETIL>';
				}

				$message .= '</ORDERPENGELUARANBARANG>';
				$message .= '</DOCUMENT>';

				if($KD_GUDANG_TUJUAN=='PSKA'){
					$WSDLSOAP = 'http://aade160f.ngrok.io/soap/OrderPengeluaranBarang';
					$Send = $this->SendCurl($message, $WSDLSOAP, '');
					if ($Send['return'] != FALSE) {
						if($Send['response'] != ''){
							$response = $Send['response'];
						}else{
							$response = 'Response is empty';
						}
					} else {
						$response = 'Tidak berhasil mengirim order; Error No '.implode("; ",$Send['errno']).'; '.implode("; ",$Send['info']);
					}
					$DATA= array(
						'USERNAME'=>'PESAKA','PASSWORD'=>'PESAKA','URL'=>$WSDLSOAP,'METHOD'=>'OrderPengeluaranBarang',
						'REQUEST'=>$message,'RESPONSE'=>$response,'IP_ADDRESS'=>$this->getIP(),'WK_REKAM'=>date('Y-m-d H:i:s')
					);
					$this->db->insert('app_log_services', $DATA);
				}
				$DATA= array(
				  'KD_STATUS'	=> '200',
				  'TGL_STATUS'	=> date('Y-m-d H:i:s')
				);
				$this->db->where(array('ID' => $arrchk[1]));
				$result = $this->db->update('t_order_hdr', $DATA);
				if ($result) {
					$func->main->get_log("send", "t_order_hdr");
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/ppbarang/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'restitusi'){
				$arrchk = explode("~", $id);
				$DATA= array(
				  'KD_STATUS'		=> '200',
				  'TGL_STATUS'	=> date('Y-m-d H:i:s')
				);
                $this->db->where(array('ID' => $arrchk[1]));
                $result = $this->db->update('t_order_hdr', $DATA);
				if ($result) {
					$func->main->get_log("send", "t_order_hdr");
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/restitusi/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
			}elseif($act == 'clearing'){
				$arrchk = explode("~", $id);
				$DATA= array(
				  'KD_STATUS'		=> '200',
				  'TGL_STATUS'	=> date('Y-m-d H:i:s')
				);
                $this->db->where(array('ID' => $arrchk[1]));
                $result = $this->db->update('t_order_hdr', $DATA);
				if ($result) {
					$func->main->get_log("send", "t_order_hdr");
					echo "MSG#OK#Data berhasil diproses#" . site_url() . "/order/clearing/post";
				} else {
					echo "MSG#ERR#" . $message . "#";
				}
            } else if ($act == "cancel_order") {
				$oke = $this->input->post('id');
				$arrchk = explode("~", $oke);
                $this->db->where(array('ID' => $arrchk[1]));
                $result = $this->db->update('t_order_hdr', array('KD_STATUS'=>600));
                if ($result) {
                    $func->main->get_log("update", "t_order_hdr");
                    echo "MSG#OK#Cancel order berhasil diproses#" . site_url() . "/order/approval/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "send_respon") {
				$oke = $this->input->post('id');
				$SQL = "SELECT B.NO_ORDER,B.TGL_TERIMA,B.NO_INVOICE,B.AMOUNT FROM t_billing_cfshdr A 
					JOIN t_edc_payment_bank B ON A.NO_INVOICE=B.NO_INVOICE
					WHERE A.IS_VOID IS NULL AND B.IS_VOID IS NULL AND A.ID = " . $this->db->escape($oke);
				$func->main->get_result($SQL);
				$arrdata = $SQL->row_array();
				$cekgudang = substr($arrdata['NO_ORDER'],2,2);
				if($cekgudang=='01'){
					$xml = '<?xml version="1.0" encoding="UTF-8"?>';
					$xml .= '<DOCUMENT>';
					$xml .= '<RESPONPEMBAYARANCFS>';
					$xml .= '<NO_ORDER>' . $arrdata['NO_ORDER'] . '</NO_ORDER>';
					$xml .= '<NO_INVOICE>' . $arrdata['NO_INVOICE'] . '</NO_INVOICE>';
					$xml .= '<TGL_BAYAR>' . $arrdata['TGL_TERIMA'] . '</TGL_BAYAR>';
					$xml .= '<TOTAL_BAYAR>' . $arrdata['AMOUNT'] . '</TOTAL_BAYAR>';
					$xml .= '</RESPONPEMBAYARANCFS>';
					$xml .= '</DOCUMENT>';
					$WSDLSOAPAPW = 'Https://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
					//$WSDLSOAPAPW = 'Http://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
					$Send = $this->SendCurl($xml, $WSDLSOAPAPW, '');
					if ($Send['return'] != FALSE) {
						if($Send['response'] != ''){
							$response = $Send['response'];
						}else{
							$response = 'Response is empty';
						}
						$this->db->where(array('ID' => $oke));
						$result = $this->db->update('t_billing_cfshdr', array('FL_SEND'=>'200'));
					} else {
						$response = 'Tidak berhasil mengirim respon pembayaran; Error No '.implode("; ",$Send['errno']).'; '.implode("; ",$Send['info']);
					}
					$DATA= array(
						'USERNAME'=>'RAYA','PASSWORD'=>'RAYA','URL'=>$WSDLSOAPAPW,'METHOD'=>'SendResponPembayaranCFS',
						'REQUEST'=>$xml,'RESPONSE'=>$response,'IP_ADDRESS'=>$this->getIP(),'WK_REKAM'=>date('Y-m-d H:i:s')
					);
					$this->db->insert('app_log_services', $DATA);
				}elseif($cekgudang=='03'){
					$xml = '<?xml version="1.0" encoding="UTF-8"?>';
					$xml .= '<DOCUMENT>';
					$xml .= '<RESPONPEMBAYARANCFS>';
					$xml .= '<NO_ORDER>' . $arrdata['NO_ORDER'] . '</NO_ORDER>';
					$xml .= '<NO_INVOICE>' . $arrdata['NO_INVOICE'] . '</NO_INVOICE>';
					$xml .= '<TGL_BAYAR>' . $arrdata['TGL_TERIMA'] . '</TGL_BAYAR>';
					$xml .= '<TOTAL_BAYAR>' . $arrdata['AMOUNT'] . '</TOTAL_BAYAR>';
					$xml .= '</RESPONPEMBAYARANCFS>';
					$xml .= '</DOCUMENT>';
					$WSDLSOAP = 'http://aade160f.ngrok.io/soap/SendResponPembayaranCFS';
					$Send = $this->SendCurl($xml, $WSDLSOAP, '');
					if ($Send['return'] != FALSE) {
						if($Send['response'] != ''){
							$response = $Send['response'];
						}else{
							$response = 'Response is empty';
						}
						$this->db->where(array('ID' => $oke));
						$result = $this->db->update('t_billing_cfshdr', array('FL_SEND'=>'200'));
					} else {
						$response = 'Tidak berhasil mengirim respon pembayaran; Error No '.implode("; ",$Send['errno']).'; '.implode("; ",$Send['info']);
					}
					$DATA= array(
						'USERNAME'=>'RAYA','PASSWORD'=>'RAYA','URL'=>$WSDLSOAP,'METHOD'=>'SendResponPembayaranCFS',
						'REQUEST'=>$xml,'RESPONSE'=>$response,'IP_ADDRESS'=>$this->getIP(),'WK_REKAM'=>date('Y-m-d H:i:s')
					);
					$this->db->insert('app_log_services', $DATA);
				}elseif($cekgudang=='02'){
					$this->db->where(array('ID' => $oke));
					$result = $this->db->update('t_billing_cfshdr', array('FL_SEND'=>'100'));
				}else{
					$result=false;
					$response="cannot get INVOICE";
				}
                if ($result) {
                    $func->main->get_log("update", "t_billing_cfshdr");
                    echo "MSG#OK#" . $response . "#" . site_url() . "/order/invoice_kemasan/post";
                } else {
                    echo "MSG#ERR#" . $response . "#";
                }
			}
		}
		// for detail
	}
	
	function getIP($type = 0) {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else {
			$ip = "unknown";
			return $ip;
		}
		if ($type == 1) {
			return md5($ip);
		}
		if ($type == 0) {
			return $ip;
		}
	}

	function SendCurl($xml, $url, $SOAPAction) {
		$header[] = 'Content-Type: text/xml';
		$header[] = 'SOAPAction: "' . $SOAPAction . '"';
		$header[] = 'Content-length: ' . strlen($xml);
		$header[] = 'Connection: close';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		$response = curl_exec($ch);
		if (!curl_errno($ch)) {
			$return['return'] = TRUE;
			$return['info'] = curl_getinfo($ch);
			$return['response'] = $response;
		} else {
			$return['return'] = FALSE;
			$return['errno'] = curl_errno($ch);
			$return['info'] = curl_error($ch);
			$return['response'] = '';
		}
		return $return;
	}

	function coba(){
		echo 'oke';
	}
}
