<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class M_tracking extends Model {
  function M_tracking() {
    parent::Model();
  }

  function cek($act, $id) {
    $this->newtable->breadcrumb('Home', site_url());
    $this->newtable->breadcrumb('Tracking', 'javascript:void(0)');
    $data['title'] = 'DATA TRACKING CONTAINER';
    $judul = "TRACKING";
    //$KD_TPS = $this->newsession->userdata('KD_TPS');
    $KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
    $KD_GROUP = $this->newsession->userdata('KD_GROUP');
    $KD_KPBC = $this->newsession->userdata('KD_KPBC');
	$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
    $addsql = '';
    /*if ($KD_GROUP == "USER") {
      $addsql .= " AND A.KD_GUDANG_ASAL = " . $this->db->escape($KD_GUDANG);
    }else */if($TIPE_ORGANISASI != "SPA"){
      #$addsql .= " AND A.KD_ORG_CONSIGNEE = '".$this->newsession->userdata('KD_ORGANISASI')."' ";
    }#if(!empty($_POST['form'])){
		$select="A.NO_BL_AWB AS 'NO BL/AWB', /* A.JUMLAH AS 'JUMLAH KEMASAN', func_name(IFNULL(A.KD_KEMASAN,'-'),'KEMASAN') AS 'JENIS KEMASAN' */
			CONCAT('JUMLAH : ',A.JUMLAH,'<BR>JENIS : ',IFNULL(func_name(A.KD_KEMASAN,'KEMASAN'),'-')) AS 'KEMASAN',
	CASE WHEN C.ID IS NOT NULL 
		THEN CONCAT('NAMA : ',C.CONSIGNEE,'<BR>NPWP : ',func_npwp(C.ID_CONSIGNEE),'<BR>ALAMAT : ',C.ALAMAT_CONSIGNEE) 
		ELSE CONCAT('NAMA : ',IFNULL(A.CONSIGNEE,'-'),'<BR>NPWP : ',IFNULL(func_npwp(A.KD_ORG_CONSIGNEE),'-'))
	END AS 'PEMILIK BARANG',A.NO_CONT_ASAL AS 'CONTAINER ASAL', CONCAT('NAMA KAPAL : ',B.NM_ANGKUT,'<BR>CALL SIGN : ',IFNULL(B.CALL_SIGN,'-')) AS 'NAMA KAPAL', B.NO_VOY_FLIGHT AS 'NO VOYAGE', /* CASE WHEN A.WK_OUT IS NOT NULL THEN CONCAT('DELIVERY : ',DATE_FORMAT(IFNULL(A.WK_OUT,'-'),'%d-%m-%Y %H:%i:%s')) ELSE CONCAT('RECEIVING : ',DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s'),'<BR>TGL TIBA : ',DATE_FORMAT(IFNULL(B.TGL_TIBA,'-'),'%d-%m-%Y')) END AS 'STATUS' */ 
		CONCAT(
		'TGL TIBA : ',IFNULL(DATE_FORMAT(B.TGL_TIBA,'%d-%m-%Y'),'-'),
		'<BR>STRIPPING : ',IFNULL(DATE_FORMAT(A.WK_IN,'%d-%m-%Y %H:%i:%s'),'-'),
		'<BR>DELIVERY : ',IFNULL(DATE_FORMAT(A.WK_OUT,'%d-%m-%Y %H:%i:%s'),'-')
		) AS 'STATUS',";
	/* }elseif(!empty($_POST['form'][1][0])){
		$select="C.NO_CONT AS 'NO KONTAINER', DATE_FORMAT(IFNULL(C.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE IN', DATE_FORMAT(IFNULL(C.WK_OUT,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE OUT', B.NO_BC11 AS 'NO BC11',B.TGL_BC11 AS 'TGL BC 11',B.NM_ANGKUT AS 'NAMA KAPAL',B.NO_VOY_FLIGHT AS 'NO VOYAGE', DATE_FORMAT(B.TGL_TIBA,'%d-%m-%Y') AS 'TGL TIBA',";
	} */
    $SQL = "SELECT ".$select."A.ID,A.NO_BL_AWB FROM t_cocostskms A	INNER JOIN t_cocostshdr B ON A.ID=B.ID LEFT JOIN t_permit_hdr C ON A.NO_BL_AWB=C.NO_BL_AWB /* INNER JOIN t_cocostscont C ON C.ID=B.ID and C.ID=A.ID_CONT_ASAL and C.NO_CONT=A.NO_CONT_ASAL */ WHERE 1=1" . $addsql;
	$proses = array('DETAIL' => array('MODAL',"tracking/cek/detail", '1','','icon-magnifier-add'));
     /*$proses = array('ENTRY' => array('ADD_MODAL', "status/listdata/add", '0', '', 'icon-plus', '80'),
          'UPDATE' => array('GET',site_url()."/status/listdata/update", '1','','icon-refresh'),
          'DELETE' => array('DELETE', site_url() . "/status/execute/delete/ubahstatus", 'ALL', '', 'icon-trash'),
          'KIRIM' => array('GET_POST',site_url()."/status/execute/send_ubah_stat", 'ALL','','icon-share-alt')
          #'PRINT PERNYATAAN' => array('EXCEL', site_url() . "/plp/execute/cetak/word", '1', '100', 'icon-share-alt'),
          #'PRINT SURAT' => array('EXCEL', site_url() . "/plp/execute/cetak/excel", '1', '100', 'icon-share-alt'),
          //'PRINT' => array('PRINT', site_url() . "/status/proses_print/ubahstatus", '1', '', 'icon-printer'),
        );*/
    $check = (grant() == "W") ? true : false;
    $this->newtable_edit->show_chk(true);
    #if(!$check) $proses = '';
    $this->newtable_edit->multiple_search(true);
    $this->newtable_edit->show_search(true);
    $this->newtable_edit->search(array(array('A.NO_BL_AWB','NO. BL/AWB'),array('A.NO_CONT_ASAL','NO. KONTAINER')));
    $this->newtable_edit->action(site_url() . "/tracking/cek");
	$this->newtable_edit->detail(array('POPUP',"tracking/cek/detail"));
    $this->newtable_edit->tipe_proses('button');
    $this->newtable_edit->hiddens(array("ID","NO_BL_AWB"));
    $this->newtable_edit->keys(array("ID","NO_BL_AWB"));
    $this->newtable_edit->validasi(array("ID"));
    $this->newtable_edit->cidb($this->db);
    $this->newtable_edit->orderby(1);
    $this->newtable_edit->sortby("DESC");
    $this->newtable_edit->set_formid("tbltracking");
    $this->newtable_edit->set_divid("divtbltracking");
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

    if ($type == "get") {
      if ($act == "t_cocostskms") {
		$arrid = explode("~",$id);
        $SQL = "SELECT A.NO_BL_AWB AS 'NO BL/AWB', A.JUMLAH AS 'JUMLAH KEMASAN', func_name(IFNULL(A.KD_KEMASAN,'-'),'KEMASAN') AS 'JENIS KEMASAN',
                A.NO_CONT_ASAL AS 'CONTAINER ASAL', B.NM_ANGKUT AS 'NAMA KAPAL', IFNULL(B.CALL_SIGN,'-') AS 'CALL SIGN', B.NO_VOY_FLIGHT AS 'NO VOYAGE',
                DATE_FORMAT(B.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', DATE_FORMAT(IFNULL(A.WK_OUT,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE OUT',
                DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE IN'
                FROM t_cocostskms A	INNER JOIN t_cocostshdr B ON A.ID=B.ID
                WHERE A.ID = " . $this->db->escape($arrid[0]) . "and A.NO_BL_AWB = ".$this->db->escape($arrid[1]);
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
    }
  }
}
