<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_truck extends Model {
	function M_truck() {
		parent::Model();
	} 

    function get_data($act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main");
        $arrdata = array();
        if ($act == "trucker") {
            $SQL = "SELECT ID, NM_TRUCKER as NAMA FROM t_trucker WHERE ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "truck") {
            $SQL = "SELECT * FROM t_truck WHERE NO_TRUCK = " . $this->db->escape($id);
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

    function execute($type, $act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $success = 0;
        $error = 0;
        $USERLOGIN = $this->newsession->userdata('USERLOGIN');
        $KD_TPS = $this->newsession->userdata('KD_TPS');
        $KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
        if ($type == "save") {
            if ($act == "trucker") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $result = $this->db->query("select ID from t_trucker where ID =".$this->db->escape($DATA['ID']));
                if ($result->num_rows() == 0) {
					$this->db->insert('t_trucker', $DATA);
                    $func->main->get_log("add", "t_trucker");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/truck/listdata/post";
                } else {
                    echo "MSG#ERR#Data gagal diproses#";
                }
            } else if ($act == "truck") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $result = $this->db->query("select ID, NO_TRUCK from t_truck where ID =".$this->db->escape($DATA['ID'])." AND NO_TRUCK=".$this->db->escape($DATA['NO_TRUCK']));
                if ($result->num_rows() == 0) {
					$this->db->insert('t_truck', $DATA);
                    $func->main->get_log("add", "t_truck");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/truck/table_truck/post/".$DATA['ID']."#". site_url() . "/truck/listdata/post";
                } else {
                    echo "MSG#ERR#Data gagal diproses#";
                }
            } 
        } else if ($type == "update") {
            if ($act == "trucker") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('t_trucker', $DATA);
                if ($result) {
                    $func->main->get_log("update", "t_trucker");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/truck/listdata/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "truck") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $this->db->where(array('NO_TRUCK' => $id,'ID' => $DATA['ID']));
                $result = $this->db->update('t_truck', $DATA);
                if ($result) {
                    $func->main->get_log("update", "t_truck");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/truck/table_truck/post/".$DATA['ID']."#". site_url() . "/truck/listdata/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "delete") {
            if ($act == "trucker") {
                foreach ($this->input->post('tb_chktbltrucker') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
					$query = $this->db->query("select * from t_truck where ID = '".$ID."'");
					if($query->num_rows() > 0){
						$error += 1;
                        $message .= "Trucker tidak bisa dihapus. Masih terdapat data truck";
					}else{
						$result = $this->db->delete('t_trucker', array('ID' => $ID));
						if (!$result) {
							$error += 1;
							$message .= "Could not be processed data";
						} 
					}
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "t_trucker");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/truck/listdata/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "truck") {
                foreach ($this->input->post('tb_chktbldetail') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[1];$IDx = $arrchk[0];
                    $result = $this->db->delete('t_truck', array('NO_TRUCK' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "t_truck");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/truck/table_truck/post/".$IDx."#". site_url() . "/truck/listdata/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        }else if ($type == "detail") {
            if ($act == "user") {
                $SQL = "SELECT A.NM_LENGKAP, A.EMAIL, A.HANDPHONE, C.NAMA AS KD_GROUP, B.NAMA AS NAMAPERS, B.ALAMAT AS ALAMATPERS, B.NOTELP,B.NOFAX,B.EMAIL AS EMAILPERS,FUNC_NPWP(B.NPWP) AS NPWP
                        FROM app_user A
                        LEFT JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
                        LEFT JOIN app_group C ON C.ID = A.KD_GROUP
                        WHERE A.ID =".$this->db->escape($id);

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
        }else if ($type == "get") {
			if ($act == "t_trucker") {
				$SQL = "SELECT A.ID, A.NM_TRUCKER FROM t_trucker A WHERE A.ID = " . $this->db->escape($id);
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

	function listdata($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('Data Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('Daftar Truck', 'javascript:void(0)');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
        $TIPE_ORGANISASI = $this->newsession->userdata('KD_ORGANISASI');
		$judul = "Truck";
        if ($TIPE_ORGANISASI != "SPA") {
		  $addsql .= " AND A.KD_ORGANISASI = " . $this->db->escape($TIPE_ORGANISASI);
		}
		$SQL = "SELECT A.ID AS 'ID TRUCKER', A.NM_TRUCKER AS 'NAMA TRUCKER', (SELECT COUNT(B.ID) FROM t_truck B WHERE B.ID = A.ID AND B.STATUS = 'Y') AS 'AVAILABLE', (SELECT COUNT(B.ID) FROM t_truck B WHERE B.ID = A.ID AND B.STATUS = 'N') AS 'UNAVAILABLE', A.ID FROM t_trucker A WHERE 1=1" . $addsql;
        $proses = array('ADD' => array('ADD_MODAL', "truck/listdata/add", '0', '', 'icon-plus', '', '1'),
            'EDIT' => array('EDIT_MODAL', "truck/listdata/edit", '1', '', 'icon-pencil', '', '1'),
            'DELETE' => array('DELETE', site_url() . "/truck/execute/delete/trucker", 'ALL', '', 'icon-trash', '', '1'));
        $this->newtable->search(array(array('ID', 'ID TRUCKER'), array('NM_TRUCKER', 'NAMA TRUCKER')));
        $this->newtable->action(site_url() . "/truck/listdata");
		$this->newtable->detail(array('POPUP', "truck/listdata/detail"));
        $this->newtable->hiddens(array("ID"));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_chk(true);
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tbltrucker");
        $this->newtable->set_divid("divtbltrucker");
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

	public function table_truck($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "";
		$check = (grant()=="W")?true:false;
		$arrid = explode("~",$id);
		$SQL = "SELECT ID, NO_TRUCK AS 'NO TRUCK', NO_POLISI AS 'NO POLISI', TIPE_TRUCK AS 'TIPE TRUCK', DRIVER, IF(STATUS = 'Y','AVAILABLE','UNAVAILABLE') AS STATUS FROM t_truck A WHERE A.ID = ".$this->db->escape($id);
        $proses = array('ADD' => array('ADD_MODAL2', "truck/table_truck/add/".$id, '0', '', 'icon-plus', '', '1'),
            'EDIT' => array('EDIT_MODAL2', "truck/table_truck/edit", '1', '', 'icon-pencil', '', '1'),
            'DELETE' => array('DELETE2', site_url() . "/truck/execute/delete/truck", 'ALL', '', 'icon-trash', '', '1'));
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(TRUE);
		$this->newtable->show_menu(TRUE);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_TRUCK','NO TRUCK'),array('A.NO_POLISI','NO POLISI'),array('A.DRIVER','NAMA DRIVER')));
		$this->newtable->action(site_url() . "/truck/table_truck/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID","NO TRUCK"));
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
}

?>
