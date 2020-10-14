<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class M_billing extends Model {
  function M_billing() {
    parent::Model();
  }

  function get_combobox($find){
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        if($find=="GUDANG"){
          $sql = "SELECT KD_GUDANG FROM reff_gudang WHERE TIPE = '2' and KD_GUDANG in ('BAND','RAYA') ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "KD_GUDANG", TRUE);
        }else if($find == "TPS"){
          $sql = "SELECT KD_GUDANG FROM reff_gudang WHERE TIPE = '1' and KD_GUDANG <> 'CART' ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "KD_GUDANG", TRUE);
        }
        
    return $arrdata;
  }
  function get_comboboxnama($find){
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        if($find=="GUDANG"){
          $sql = "SELECT KD_GUDANG,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '2'  and KD_GUDANG in ('BAND','RAYA') ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "NAMA_GUDANG", TRUE);
        }else if($find == "TPS"){
          $sql = "SELECT KD_GUDANG,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '1' and KD_GUDANG <> 'CART' ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "NAMA_GUDANG", TRUE);
        }
        
    return $arrdata;
  }

  function listdata($act, $id) {
    $this->newtable->breadcrumb('Home', site_url());
    $this->newtable->breadcrumb('Billing1', 'javascript:void(0)');
    $data['title'] = 'DATA BILLING';
    $judul = "BILLING";
    $addsql = '';
    $KD_GROUP = $this->newsession->userdata('KD_GROUP');
	if($KD_GROUP != "SPA"){
      $addsql .= "";
    }
    $SQL = "select A.ID, A.NO_NOTA AS 'NO NOTA', A.TGL_NOTA AS 'TGL NOTA', A.PEMILIK AS 'PEMILIK BARANG', A.NO_FAKTUR AS 'NO FAKTUR', A.TOT_TAGIHAN AS 'TOTAL TAGIHAN' from t_billing_hdr A WHERE 1=1" . $addsql;
    //var_dump($SQL);die();
	$proses = '';#array('DETAIL' => array('MODAL',"tracking/cek/detail", '1','','icon-pencil'));
	$this->newtable->show_chk(false);
    $this->newtable->multiple_search(true);
    $this->newtable->show_search(true);
    $arrGudang = $this->get_combobox("GUDANG");
    $arrTPS = $this->get_combobox("TPS");
    $arrnamaGudang = $this->get_comboboxnama("GUDANG");
    $arrnamaTPS = $this->get_comboboxnama("TPS");
    if($KD_GROUP=="SPA"){
        $this->newtable->search(array(array('A.NO_NOTA','NO. NOTA'),array('A.NO_FAKTUR','NO. FAKTUR'),array('A.KD_GUDANG','KD GUDANG', 'OPTION', $arrnamaGudang),array('A.KD_GUDANG','KD TERMINAL', 'OPTION', $arrnamaTPS)));
    }else{
      $this->newtable->search(array(array('A.NO_NOTA','NO. NOTA'),array('A.NO_FAKTUR','NO. FAKTUR')));
    }
    
    $this->newtable->action(site_url() . "/billing/listdata");
	$this->newtable->tipe_proses('button');
    $this->newtable->hiddens(array("ID"));
    $this->newtable->keys(array("ID"));
    $this->newtable->cidb($this->db);
    $this->newtable->orderby(1);
    $this->newtable->sortby("DESC");
    $this->newtable->set_formid("tblbilling");
    $this->newtable->set_divid("divtblbilling");
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
}
