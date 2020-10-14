<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_management extends Model {

	function autocomplete($type,$act,$get){
		$post = $this->input->post('term');
		if($type=="reff_tipe_organisasi"){
			if($act=="nama"){
			  if (!$post) return;
			  $SQL = "SELECT ID,NAMA
			  FROM reff_tipe_organisasi
			  WHERE NAMA LIKE '%".$post."%' LIMIT 5";
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $KODE = strtoupper($row->ID);
				  $NAMA = strtoupper($row->NAMA);
				  $arrayDataTemp[] = array("value"=>$NAMA,"NAMANYA"=>$KODE);
				}
			  }
			}
			echo json_encode($arrayDataTemp);
		}elseif($type=="app_group"){
			if($act=="nama"){
			  if (!$post) return;
			  $SQL = "SELECT ID,NAMA
			  FROM app_group
			  WHERE NAMA LIKE '%".$post."%' LIMIT 5";
			  $result = $this->db->query($SQL);
			  $banyakData = $result->num_rows();
			  $arrayDataTemp = array();
			  if($banyakData > 0){
				foreach($result->result() as $row){
				  $KODE = strtoupper($row->ID);
				  $NAMA = strtoupper($row->NAMA);
				  $arrayDataTemp[] = array("value"=>$NAMA,"NAMANYA"=>$KODE);
				}
			  }
			}
			echo json_encode($arrayDataTemp);
		}
	}

    function get_data($act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main");
        $arrdata = array();
        if ($act == "group") {
            $SQL = "SELECT ID, NAMA FROM app_group WHERE ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "menu") {
            $SQL = "SELECT A.ID, A.ID_PARENT , A.JUDUL_MENU , A.URL , A.URL_CI , A.URUTAN, A.TIPE , A.TARGET , A.ACTION, A.CLS_ICON
                    FROM app_menu A WHERE A.ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "groupmenu") {
            $arrhdr = explode("~", $id);
            $SQL = "SELECT  A.KD_TIPE_ORGANISASI AS ID, D.NAMA, A.KD_GROUP AS 'GROUP', B.NAMA AS 'NAMA GROUP',C.JUDUL_MENU,A.HAK_AKSES, C.URUTAN
                FROM app_group_menu A
                INNER JOIN app_group B ON A.KD_GROUP=B.ID
                INNER JOIN app_menu C ON C.ID = A.KD_MENU
                INNER JOIN reff_tipe_organisasi D ON A.KD_TIPE_ORGANISASI=D.ID
                WHERE A.KD_GROUP=" . $this->db->escape($arrhdr[0]). "AND A.KD_TIPE_ORGANISASI=" . $this->db->escape($arrhdr[1]);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        }else if ($act == "privilege") {
            $arrid = explode("~", $id);
            $SQL = "SELECT A.KD_USER, A.KD_MENU, A.HAK_AKSES, B.JUDUL_MENU AS MENU, C.NM_LENGKAP AS USER
                    FROM app_user_menu A
                    INNER JOIN app_menu B ON B.ID=A.KD_MENU
                    INNER JOIN app_user C ON C.ID=A.KD_USER
                    WHERE A.KD_USER = " . $this->db->escape($arrid[0]);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "privilege_skema") {
            $arrid = explode("~", $id);
            $SQL = "SELECT A.KD_USER, A.KD_SKEMA, A.HAK_AKSES, B.NAMA AS MENU, C.NM_LENGKAP AS USER
                    FROM app_user_skema A
                    INNER JOIN reff_skema_tarif B ON B.ID=A.KD_SKEMA
                    INNER JOIN app_user C ON C.ID=A.KD_USER
                    WHERE A.KD_USER = " . $this->db->escape($arrid[0]);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "profile") {
            $SQL = "SELECT A.*
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
        } else if ($act == "user_profile") {
            $SQL = "SELECT A.*
                    FROM app_user A WHERE A.ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "user") {
            $SQL = "SELECT A.ID, A.KD_ORGANISASI ,B.NAMA AS NAMA_ORGANISASI,  A.USERLOGIN ,A.PASSWORD ,A.NM_LENGKAP ,A.HANDPHONE,
                    A.EMAIL, A.KD_GROUP ,C.NAMA AS NAMA_GROUP, A.KD_TPS , A.KD_GUDANG, D.NAMA_GUDANG ,A.KD_STATUS
                    FROM app_user A
                    LEFT JOIN t_organisasi B ON B.ID = A.KD_ORGANISASI
                    LEFT JOIN app_group C ON C.ID = A.KD_GROUP
                    LEFT JOIN reff_gudang D ON D.KD_GUDANG = A.KD_GUDANG
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
        } else if ($act == "organisasi") {
            $SQL = "SELECT A.ID, A.KD_KAPAL, A.NPWP, A.NAMA, A.ALAMAT, A.NOTELP, A.NOFAX, A.EMAIL, A.KD_TIPE_ORGANISASI, A.KD_TPS
                    FROM t_organisasi A
                    INNER JOIN reff_tipe_organisasi B ON B.ID = A.KD_TIPE_ORGANISASI
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
        } else if ($act == "access_menu") {
            if ($this->newsession->userdata('TIPE_ORGANISASI') == "SPA") {
                $SQL = "SELECT B.ID, B.ID_PARENT, B.JUDUL_MENU, B.URL_CI, B.URUTAN, B.TIPE, B.TARGET,
						B.ACTION, B.CLS_ICON AS ICON, C.KD_MENU AS MENU_ACT, C.HAK_AKSES AS AKSES_ACT
						FROM app_menu B
						LEFT JOIN (SELECT KD_MENU, HAK_AKSES FROM app_user_menu
						WHERE KD_USER = '" . $id . "') C ON C.KD_MENU=B.ID
						WHERE B.URUTAN != 0
						ORDER BY B.ID_PARENT, B.URUTAN ASC";
            } else {
                $SQL = "SELECT B.ID, B.ID_PARENT, B.JUDUL_MENU, B.URL_CI, B.URUTAN, B.TIPE, B.TARGET,
						B.ACTION, B.CLS_ICON AS ICON, C.KD_MENU AS MENU_ACT, C.HAK_AKSES AS AKSES_ACT
						FROM app_user_menu A
						INNER JOIN app_menu B ON A.KD_MENU = B.ID
						LEFT JOIN (SELECT KD_MENU, HAK_AKSES FROM app_user_menu
						WHERE KD_USER = '" . $id . "') C ON C.KD_MENU=B.ID
						WHERE A.KD_USER = '" . $this->newsession->userdata('ID') . "' AND B.URUTAN != 0
						ORDER BY B.ID_PARENT, B.URUTAN ASC";
                                //print_r($SQL);die();
            }
            $result = $this->db->query($SQL);
            if ($result->num_rows() > 0) {
                foreach ($result->result_array() as $row) {
                    if ($row['ID_PARENT'] == "")
                        $parent_id = 0;
                    else
                        $parent_id = $row['ID_PARENT'];
                    $data[$parent_id][] = array("ID" => $row['ID'],
                        "ID_PARENT" => $row['ID_PARENT'],
                        "JUDUL_MENU" => $row['JUDUL_MENU'],
                        "URL" => $row['URL_CI'],
                        "URUTAN" => $row['URUTAN'],
                        "TIPE" => $row['TIPE'],
                        "TARGET" => $row['TARGET'],
                        "ACTION" => $row['ACTION'],
                        "ICON" => $row['ICON'],
                        "MENU_ACT" => $row['MENU_ACT'],
                        "AKSES_ACT" => $row['AKSES_ACT']
                    );
                }
                $data = $this->draw_menu($data);
            }
            return $data;
        } else if ($act == "access_groupmenu") {
            $arrhdr = explode("~", $id);
			$SQL = "SELECT B.ID, B.ID_PARENT, B.JUDUL_MENU, B.URL_CI, B.URUTAN, B.TIPE, B.TARGET,
					B.ACTION, B.CLS_ICON AS ICON, C.KD_MENU AS MENU_ACT, C.HAK_AKSES AS AKSES_ACT
					FROM app_menu B
					LEFT JOIN (SELECT KD_MENU, HAK_AKSES FROM app_group_menu
					WHERE KD_GROUP = '" . $arrhdr[0] . "' AND KD_TIPE_ORGANISASI = '" . $arrhdr[1] . "') C ON C.KD_MENU=B.ID
					WHERE B.URUTAN != 0
					ORDER BY B.ID_PARENT, B.URUTAN ASC";
            $result = $this->db->query($SQL);
            if ($result->num_rows() > 0) {
                foreach ($result->result_array() as $row) {
                    if ($row['ID_PARENT'] == "")
                        $parent_id = 0;
                    else
                        $parent_id = $row['ID_PARENT'];
                    $data[$parent_id][] = array("ID" => $row['ID'],
                        "ID_PARENT" => $row['ID_PARENT'],
                        "JUDUL_MENU" => $row['JUDUL_MENU'],
                        "URL" => $row['URL_CI'],
                        "URUTAN" => $row['URUTAN'],
                        "TIPE" => $row['TIPE'],
                        "TARGET" => $row['TARGET'],
                        "ACTION" => $row['ACTION'],
                        "ICON" => $row['ICON'],
                        "MENU_ACT" => $row['MENU_ACT'],
                        "AKSES_ACT" => $row['AKSES_ACT']
                    );
                }
                $data = $this->draw_menu($data);
            }
            return $data;
        }else if ($act == "access_skema") {
            //if ($this->newsession->userdata('TIPE_ORGANISASI') == "SPA") {
                $SQL = "SELECT A.ID, A.NAMA, B.KD_SKEMA AS MENU_ACT, B.HAK_AKSES AS AKSES_ACT
                        FROM reff_skema_tarif A
                        LEFT JOIN (SELECT KD_SKEMA, HAK_AKSES FROM app_user_skema WHERE KD_USER = '" . $id . "') B ON B.KD_SKEMA=A.ID";
                                //print_r($SQL);die();
            /*} else {
                $SQL = "SELECT A.NAMA, B.KD_MENU AS MENU_ACT, B.HAK_AKSES AS AKSES_ACT
                        FROM reff_skema_tarif A
                        LEFT JOIN (SELECT KD_SKEMA, HAK_AKSES FROM app_user_skema WHERE KD_USER = '" . $id . "') B ON B.KD_SKEMA=A.ID
                        WHERE A.KD_USER = '" . $this->newsession->userdata('ID') . "'
                        ORDER BY B.ID_PARENT, B.URUTAN ASC";
                                print_r($SQL);die();
            }*/
            $result = $this->db->query($SQL);
            if ($result->num_rows() > 0) {
                foreach ($result->result_array() as $row) {
                    if ($row['ID_PARENT'] == "")
                        $parent_id = 0;
                    else
                        $parent_id = $row['ID_PARENT'];
                    $data[$parent_id][] = array("ID" => $row['ID'],
                        "NAMA" => $row['NAMA'],
                        "MENU_ACT" => $row['MENU_ACT'],
                        "AKSES_ACT" => $row['AKSES_ACT']
                    );
                }
                $data = $this->draw_skema($data);
            }
            return $data;
        }
    }

    function draw_menu($data, $parent=0) {
        $html = "";
        $child = "";
        if ($data[$parent] != 0) {
            $html .= '<ol>';
            for ($c = 0; $c < count($data[$parent]); $c++) {
                $checked = ($data[$parent][$c]['MENU_ACT'] != "") ? "checked" : "";
                $W = ($data[$parent][$c]['AKSES_ACT'] == "W") ? "selected" : "";
                $R = ($data[$parent][$c]['AKSES_ACT'] == "R") ? "selected" : "";
                $child = $this->draw_menu($data, $data[$parent][$c]['ID']);
                $html .= "<li>";
                $html .= '<input type="checkbox" name="KD_MENU[]" ' . $checked . ' id="KD_MENU_' . $data[$parent][$c]["ID"] . '" value="' . $data[$parent][$c]["ID"] . '" class="KD_MENU">&nbsp;' . $data[$parent][$c]["JUDUL_MENU"];
                $html .= '&nbsp;&nbsp;&nbsp;';
                $html .= '<select name="HAK_AKSES[]" id="HAK_AKSES_' . $data[$parent][$c]["ID"] . '">';
                $html .= '<option value="W" ' . $W . '>W</option>';
                $html .= '<option value="R" ' . $R . '>R</option>';
                $html .= '</select>';
                if ($child) {
                    $html .= '<ol>' . $child . '</ol>';
                }
                $html .= '</li>';
            }
            $html .= '</ol>';
            return $html;
        }
    }

    function draw_skema($data, $parent=0) {
                //print_r($data);die();
        $html = "";
        $child = "";
        if ($data[$parent] != 0) {
            $html .= '<ol>';
            for ($c = 0; $c < count($data[$parent]); $c++) {
                $checked = ($data[$parent][$c]['MENU_ACT'] != "") ? "checked" : "";
                $Y = ($data[$parent][$c]['AKSES_ACT'] == "Y") ? "selected" : "";
                $N = ($data[$parent][$c]['AKSES_ACT'] == "N") ? "selected" : "";
                $child = $this->draw_skema($data, $data[$parent][$c]['ID']);
                $html .= "<li>";
                $html .= '<input type="checkbox" name="KD_SKEMA[]" ' . $checked . ' id="KD_SKEMA_' . $data[$parent][$c]["ID"] . '" value="' . $data[$parent][$c]["ID"] . '" class="KD_SKEMA">&nbsp;' . $data[$parent][$c]["NAMA"];
                $html .= '&nbsp;&nbsp;&nbsp;';
                $html .= '<select name="HAK_AKSES[]" id="HAK_AKSES_' . $data[$parent][$c]["ID"] . '">';
                $html .= '<option value="Y" ' . $Y . '>Y</option>';
                $html .= '<option value="N" ' . $N . '>N</option>';
                $html .= '</select>';
                if ($child) {
                    $html .= '<ol>' . $child . '</ol>';
                }
                $html .= '</li>';
            }
            $html .= '</ol>';
            return $html;
        }
    }

    function get_combobox($act) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $ID_ORG = $this->newsession->userdata('KD_ORGANISASI');
        $KD_GROUP = $this->newsession->userdata('KD_GROUP');
        if ($act == "parent") {
            $sql = "SELECT ID, UPPER(JUDUL_MENU) AS JUDUL_MENU FROM app_menu ORDER BY JUDUL_MENU ASC"; //print_r($sql);die();
            $arrdata = $func->main->get_combobox($sql, "ID", "JUDUL_MENU", TRUE); //print_r($arrdata);die();
            return $arrdata;
        } else if ($act == "fl_mandatory") {
            $sql = "SELECT ID,NAMA , MAXLENGTH , FL_MANDATORY , FL_REFERENCE FROM reff_edifact ORDER BY NAMA"; //print_r($sql);die();
            $arrdata = $func->main->get_combobox($sql, "ID", "FL_MANDATORY", TRUE);
            return $arrdata;
        } else if ($act == "group") {
            if ($KD_GROUP != "SPA") {
                $addsql .= " AND ID = 'USR'";
            }
            $sql = "SELECT ID, NAMA FROM app_group WHERE 1=1" . $addsql;
            $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
            return $arrdata;
        } else if ($act == "tipe") {
            $sql = "SELECT ID, NAMA FROM reff_tipe_organisasi";
            $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
            return $arrdata;
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
            if ($act == "group") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $result = $this->db->insert('app_group', $DATA);
                if ($result) {
                    $func->main->get_log("add", "app_group");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/group/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "groupmenu") {
                $KD_TIPE_ORGANISASI = $this->input->post('ID');
                $KD_GROUP = $this->input->post('GROUP');
                $KD_MENU = $this->input->post('KD_MENU');
                $HAK_AKSES = $this->input->post('HAK_AKSES');
                $SQL = "";
                if (count($KD_MENU) > 0) {

                        for ($a = 0; $a < count($KD_MENU); $a++) {
                            $SQL .= "(" . $this->db->escape($KD_TIPE_ORGANISASI) . ", " . $this->db->escape($KD_GROUP) . ", " . $this->db->escape($KD_MENU[$a]) . ", " . $this->db->escape($HAK_AKSES[$a]) . "),";
                        }
                        $SQL = "INSERT INTO app_group_menu (KD_TIPE_ORGANISASI, KD_GROUP, KD_MENU, HAK_AKSES) VALUES " . substr($SQL, 0, -1);
                        if (!$this->db->simple_query($SQL)) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        }

                }
                if ($error == 0) {
                    $func->main->get_log("add", "app_group_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/groupmenu/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }

            }else if ($act == "menu") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $result = $this->db->insert('app_menu', $DATA);
                if ($result) {
                    $func->main->get_log("add", "app_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/menu/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "hak_akses") {
                $KD_USER = $this->input->post('KD_USER');
                $KD_MENU = $this->input->post('KD_MENU');
                $HAK_AKSES = $this->input->post('HAK_AKSES');
                $SQL = "";
                if (count($KD_MENU) > 0) {
                    for ($a = 0; $a < count($KD_MENU); $a++) {
                        $SQL .= "(" . $this->db->escape($KD_USER) . ", " . $this->db->escape($KD_MENU[$a]) . ", " . $this->db->escape($HAK_AKSES[$a]) . "),";
                    }
                    $SQL = "INSERT INTO app_user_menu (KD_USER, KD_MENU, HAK_AKSES) VALUES " . substr($SQL, 0, -1);
                    if (!$this->db->simple_query($SQL)) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "app_user_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/hak_akses/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "privilege_skema") {
                $KD_USER = $this->input->post('KD_USER');
                $KD_SKEMA = $this->input->post('KD_SKEMA');
                $HAK_AKSES = $this->input->post('HAK_AKSES');
                $SQL = "";
                if (count($KD_SKEMA) > 0) {
                    for ($a = 0; $a < count($KD_SKEMA); $a++) {
                        $SQL .= "(" . $this->db->escape($KD_USER) . ", " . $this->db->escape($KD_SKEMA[$a]) . ", " . $this->db->escape($HAK_AKSES[$a]) . "),";
                    }
                    $SQL = "INSERT INTO app_user_skema (KD_USER, KD_SKEMA, HAK_AKSES) VALUES " . substr($SQL, 0, -1);
                    if (!$this->db->simple_query($SQL)) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "app_user_skema");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/privilege_skema/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "user") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $DATA['USERLOGIN'] = $this->input->post('USERLOGIN');
                $DATA['EMAIL'] = $this->input->post('EMAIL');
                $DATA['PASSWORD'] = md5($DATA['PASSWORD']);
                $DATA['WK_REKAM'] = date("Y-m-d H:i:s");
                $DATA['CHILD_USER'] = $this->newsession->userdata('ID');
                $result = $this->db->insert('app_user', $DATA);
                if ($result) {
                    $func->main->get_log("add", "app_user");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/user/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "organisasi") {
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
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/organisasi/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "update") {
            if ($act == "group") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('app_group', $DATA);
                if ($result) {
                    $func->main->get_log("update", "app_group");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/group/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "menu") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('app_menu', $DATA);
                if ($result) {
                    $func->main->get_log("update", "app_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/menu/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "groupmenu") {
                $KD_TIPE_ORGANISASI = $this->input->post('ID');
                $KD_GROUP = $this->input->post('GROUP');
                $KD_MENU = $this->input->post('KD_MENU');
                $HAK_AKSES = $this->input->post('HAK_AKSES');
                $SQL = "";
                if (count($KD_MENU) > 0) {
                    $result = $this->db->delete('app_group_menu', array('KD_TIPE_ORGANISASI' => $KD_TIPE_ORGANISASI,'KD_GROUP' => $KD_GROUP));
                    if ($result) {
                        for ($a = 0; $a < count($KD_MENU); $a++) {
                            $SQL .= "(" . $this->db->escape($KD_TIPE_ORGANISASI) . ", " . $this->db->escape($KD_GROUP) . ", " . $this->db->escape($KD_MENU[$a]) . ", " . $this->db->escape($HAK_AKSES[$a]) . "),";
                        }
                        $SQL = "INSERT INTO app_group_menu (KD_TIPE_ORGANISASI, KD_GROUP, KD_MENU, HAK_AKSES) VALUES " . substr($SQL, 0, -1);
                        if (!$this->db->simple_query($SQL)) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        }
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "app_group_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/groupmenu/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }else if ($act == "hak_akses") {
                $KD_USER = $this->input->post('KD_USER');
                $KD_MENU = $this->input->post('KD_MENU');
                $HAK_AKSES = $this->input->post('HAK_AKSES');
                $SQL = "";
                if (count($KD_MENU) > 0) {
                    $result = $this->db->delete('app_user_menu', array('KD_USER' => $KD_USER));
                    if ($result) {
                        for ($a = 0; $a < count($KD_MENU); $a++) {
                            $SQL .= "(" . $this->db->escape($KD_USER) . ", " . $this->db->escape($KD_MENU[$a]) . ", " . $this->db->escape($HAK_AKSES[$a]) . "),";
                        }
                        $SQL = "INSERT INTO app_user_menu (KD_USER, KD_MENU, HAK_AKSES) VALUES " . substr($SQL, 0, -1);
                        if (!$this->db->simple_query($SQL)) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        }
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "app_user_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/hak_akses/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }  else if ($act == "privilege_skema") {
                $KD_USER = $this->input->post('KD_USER');
                $KD_SKEMA = $this->input->post('KD_SKEMA');
                $HAK_AKSES = $this->input->post('HAK_AKSES');
                $SQL = "";
                if (count($KD_SKEMA) > 0) {
                    $result = $this->db->delete('app_user_skema', array('KD_USER' => $KD_USER));
                    if ($result) {
                        for ($a = 0; $a < count($KD_SKEMA); $a++) {
                            $SQL .= "(" . $this->db->escape($KD_USER) . ", " . $this->db->escape($KD_SKEMA[$a]) . ", " . $this->db->escape($HAK_AKSES[$a]) . "),";
                        }
                        $SQL = "INSERT INTO app_user_skema (KD_USER, KD_SKEMA, HAK_AKSES) VALUES " . substr($SQL, 0, -1);
                        if (!$this->db->simple_query($SQL)) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        }
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "app_user_skema");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/privilege_skema/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "user") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $DATA['USERLOGIN'] = $this->input->post('USERLOGIN');
                $DATA['EMAIL'] = $this->input->post('EMAIL');
                if ($DATA['PASSWORD'] == "")
                    unset($DATA['PASSWORD']);
                else
                    $DATA['PASSWORD'] = md5($DATA['PASSWORD']);
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('app_user', $DATA);
                if ($result) {
                    $func->main->get_log("update", "app_user");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/user/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "organisasi") {
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
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/organisasi/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "reset_password") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper($b);
                }
                $query = "SELECT A.ID AS USERID
						  FROM app_user A
						  INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
						  INNER JOIN app_group C ON A.KD_GROUP = C.ID
						  LEFT JOIN reff_gudang D ON A.KD_GUDANG = D.KD_GUDANG
						  LEFT JOIN reff_tps E ON E.KD_TPS=A.KD_TPS
						  WHERE A.USERLOGIN = " . $this->db->escape($USERLOGIN) . " AND A.PASSWORD = " . $this->db->escape(md5($DATA['PASS_OLD']));
                $data = $this->db->query($query);
                if ($data->num_rows() > 0) {
                    $rs = $data->row();
                    if ($DATA['PASS_NEW'] == $DATA['PASS_CONFIRM']) {
                        $ARRDATA['PASSWORD'] = md5($DATA['PASS_NEW']);
                        $ARRDATA['WK_REKAM'] = date('Y-m-d H:i:s');
                        $this->db->where(array('ID' => $rs->USERID));
                        $this->db->update('app_user', $ARRDATA);
                    } else {
                        $error += 1;
                        $message .= "Data gagal diproses, Konfirmasi password tidak sesuai";
                    }
                } else {
                    $error += 1;
                    $message .= "Data gagal diproses, Password lama tidak sesuai";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "app_user");
                    $this->newsession->sess_destroy();
                    echo "MSG#OK#Data berhasil diproses#" . base_url();
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "user_profile") {
                $ID_USR = $this->newsession->userdata('ID');
                $ID_ORG = $this->newsession->userdata('KD_ORGANISASI');
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper($b);
                }
                $this->db->where(array('ID' => $ID_ORG));
                $exec_profile = $this->db->update('t_organisasi', $DATA);
                if (!$exec_profile) {
                    $error += 1;
                    $message .= "Data gagal diproses, Periksa data profile";
                }
                foreach ($this->input->post('USER') as $a => $b) {
                    if ($b == "")
                        $USER[$a] = NULL;
                    else
                        $USER[$a] = strtoupper($b);
                }
				$USER['EMAIL'] = $this->input->post('EMAIL');
                $this->db->where(array('ID' => $ID_USR));
                $exec_user = $this->db->update('app_user', $USER);
                if (!$exec_user) {
                    $error += 1;
                    $message .= "Data gagal diproses, Periksa data user";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_organisasi,app_user");
                    $this->newsession->sess_destroy();
                    echo "MSG#OK#Data berhasil diproses#" . base_url();
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "delete") {
            if ($act == "group") {
                foreach ($this->input->post('tb_chktblgroup') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $result = $this->db->delete('app_group', array('ID' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "app_group");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/management/group/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "menu") {
                foreach ($this->input->post('tb_chktblmenu') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $result = $this->db->delete('app_menu', array('ID' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "app_menu");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/management/menu/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "user") {
                foreach ($this->input->post('tb_chktbluser') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
					$data = array(
               'KD_STATUS' => 'BLOCKED'
            );
					$this->db->where(array('ID' => $ID));
                    $result = $this->db->update('app_user',$data);
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "app_user");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/management/user/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "groupmenu") {
                foreach ($this->input->post('tb_chktblgroupmenu') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[1];
                    $GROUP = $arrchk[0];
                    $result = $this->db->delete('app_group_menu', array('KD_TIPE_ORGANISASI' => $ID,'KD_GROUP' => $GROUP));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "app_group_menu");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/management/groupmenu/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }else if ($act == "hak_akses") {
                foreach ($this->input->post('tb_chktblprivilege') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID_USR = $arrchk[0];
                    $ID_MENU = $arrchk[1];
                    $result = $this->db->delete('app_user_menu', array('KD_USER' => $ID_USR));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "app_user_menu");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/management/hak_akses/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "privilege_skema") {
                foreach ($this->input->post('tb_chktblprivilegeskema') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID_USR = $arrchk[0];
                    $ID_MENU = $arrchk[1];
                    $result = $this->db->delete('app_user_skema', array('KD_USER' => $chkitem));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "app_user_skema");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/management/privilege_skema/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "organisasi") {
                foreach ($this->input->post('tb_chktblorganisasi') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $result = $this->db->delete('t_organisasi', array('ID' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "t_organisasi");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/management/organisasi/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "approve") {
            if ($act == "user") {
                $error = 0;
				foreach($this->input->post('tb_chktblnewuser') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$id_stat = $arrchk[0];
					$this->db->where(array('ID'=>$id_stat));
					$result = $this->db->update('app_user',array('KD_STATUS'=>'ACTIVE','WK_REKAM'=>date('Y-m-d H:i:s')));
					$q = $this->db->get_where('app_user', array('ID' => $id_stat), 1);
					if($this->db->affected_rows() > 0){
						$row = $q->row();
					}
					$url = base_url().'index.php/home';
					$link = '<a href="' . $url . '">CFS-Center</a>';
					$message_mail = '';
					$message_mail .= '<strong>Selamat '.$row->USERLOGIN.',</strong><br>';
					$message_mail .= '<strong>Admin kami telah menyetujui akun Anda. Silakan masuk ke link '.$link.'.</strong>';
					$toemail = $row->EMAIL;
					$fromemail="cfs@edi-indonesia.co.id";
					$fromname="Admin CFS Center";
					$subject="Approve User CFS Center";
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
					$this->email->subject($subject);
					$this->email->message($message_mail);
					if(!$this->email->send()){
						$error += 1;
						$message .= "Could not sending mail";
					}
				}
				if (!$result) {
					$error += 1;
					$message .= "Could not be processed data";
				}

				if($error == 0){
				  $func->main->get_log("ApproveUser", "app_user");
				  echo "MSG#OK#Successfully to be approved#".site_url()."/management/newuser";
				}else{
				  echo "MSG#ERR#".$message."#";
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
        } else if ($type == "reject") {
            if ($act == "user") {
				$error = 0;
				$id = $this->input->post('ID');
				$this->db->where(array('ID'=>$id));
				$result = $this->db->update('app_user',array('KD_STATUS'=>'BLOCKED','KETERANGAN'=>$this->input->post('alasan')));
				$q = $this->db->get_where('app_user', array('ID' => $id), 1);
				if($this->db->affected_rows() > 0){
					$row = $q->row();
				}
				$url = base_url().'index.php/home/signup';
				$link = '<a href="' . $url . '">'.$url.'</a>';
				$message_mail = '';
				$message_mail .= '<strong>Mohon maaf '.$row->USERLOGIN.',</strong><br>';
				$message_mail .= '<strong>Kami menolak permohonan akun Anda dengan alasan :</strong><br><br>';
				$message_mail .= '<strong>'.$this->input->post('alasan').'</strong><br><br>';
				$message_mail .= '<strong>Silahkan klik link dibawah untuk permohonan ulang</strong><br>';
				$message_mail .= $link;
				$toemail = $row->EMAIL;
				$fromemail="cfs@edi-indonesia.co.id";
				$fromname="Admin CFS Center";
				$subject="Rejected User CFS Center";
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
				$this->email->subject($subject);
				$this->email->message($message_mail);
				if(!$this->email->send()){
					$error += 1;
					$message .= "Could not sending mail";
				}
				if (!$result) {
					$error += 1;
					$message .= "Could not be processed data";
				}

				if($error == 0){
				  $func->main->get_log("reject", "Berhasil <b>Reject User</b> dengan ID = ".$id." dengan keterangan sebagai berikut:<br>".$this->input->post('alasan'));
				  echo "MSG#OK#Successfully to be rejected#".site_url()."/management/newuser";
				}else{
				  echo "MSG#ERR#".$message."#";
				}
            }
        }
    }

	function group($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('Group', 'javascript:void(0)');
        $judul = "GROUP";
        $SQL = "SELECT ID, NAMA FROM app_group";
        $proses = array('ADD' => array('ADD_MODAL', "management/group/add", '0', '', 'icon-plus', '', 'menu'),
            'EDIT' => array('EDIT_MODAL', "management/group/edit", '1', '', 'icon-pencil', '', 'menu'),
            'DELETE' => array('DELETE', site_url() . "/management/execute/delete/group", 'ALL', '', 'icon-trash', '', 'menu'));
        $this->newtable->search(array(array('ID', 'ID'), array('NAMA', 'NAMA')));
        $this->newtable->action(site_url() . "/management/group");
        $this->newtable->hiddens(array(""));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_chk(true);
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblgroup");
        $this->newtable->set_divid("divtblgroup");
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

    function menu($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Managament', 'javascript:void(0)');
        $this->newtable->breadcrumb('Menu', 'javascript:void(0)');
        $judul = "MENU";
        $SQL = "SELECT ID ,JUDUL_MENU AS 'JUDUL MENU', URL , URUTAN , TIPE , TARGET , ACTION , CLS_ICON AS 'ICON' FROM app_menu";
        $proses = array('ADD' => array('ADD_MODAL', "management/menu/add", '0', '', 'icon-plus', '', 'menu'),
            'EDIT' => array('EDIT_MODAL', "management/menu/edit", '1', '', 'icon-pencil', '', 'menu'),
            'DELETE' => array('DELETE', site_url() . "/management/execute/delete/menu", 'ALL', '', 'icon-trash', '', 'menu'));
        $this->newtable->search(array(array('JUDUL_MENU', 'JUDUL MENU')));
        $this->newtable->action(site_url() . "/management/menu");
        $this->newtable->hiddens(array("ID"));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_chk(true);
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblmenu");
        $this->newtable->set_divid("divtblmenu");
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

    function hak_akses($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url(), '');
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)', '');
        $this->newtable->breadcrumb('Privilege', 'javascript:void(0)', '');
        $judul = "DAFTAR HAK AKSES";
        $KD_GROUP = $this->newsession->userdata('KD_GROUP');
        $KD_ORGANISASI = $this->newsession->userdata('KD_ORGANISASI');
        $KD_USER = $this->newsession->userdata('ID');
        if ($KD_GROUP != "SPA") {
            $addsql .= " AND B.KD_ORGANISASI = " . $this->db->escape($KD_ORGANISASI);
        }
        if ($KD_GROUP == "ADM") {
            $addsql .= " AND B.KD_GROUP IN ('USR')";
        }
        $SQL = "SELECT A.KD_USER, B.USERLOGIN,
				GROUP_CONCAT(IFNULL(C.JUDUL_MENU,'-'),' [ ',A.HAK_AKSES,' ] ' ORDER BY C.URUTAN SEPARATOR '<BR>') AS URL
				FROM app_user_menu A
                INNER JOIN app_user B ON B.ID = A.KD_USER
                INNER JOIN app_menu C ON C.ID = A.KD_MENU
				WHERE 1=1" . $addsql . " GROUP BY A.KD_USER";
        #echo $SQL; die();
        $proses = array('ADD' => array('ADD_MODAL', "management/hak_akses/add", '0', '', 'icon-plus', '', 'menu'),
            'EDIT' => array('EDIT_MODAL', "management/hak_akses/edit", '1', '', 'icon-pencil', '', 'menu'),
            'DELETE' => array('DELETE', site_url() . "/management/execute/delete/hak_akses", 'ALL', '', 'icon-trash', '', 'menu'));
        $this->newtable->search(array(array('B.USERLOGIN', 'USERLOGIN'), array('C.JUDUL_MENU', 'JUDUL MENU'), array('A.HAK_AKSES', 'HAK AKSES')));
        $this->newtable->action(site_url() . "/management/hak_akses");
        $this->newtable->hiddens(array("KD_USER"));
        $this->newtable->keys(array("KD_USER"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_chk(true);
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblprivilege");
        $this->newtable->set_divid("divtblprivilege");
        $this->newtable->rowcount(10);
        $this->newtable->clear();
        if ($KD_GROUP != "USR")
            $this->newtable->menu($proses);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $judul, "content" => $tabel);
        if ($this->input->post("ajax") || $act == "post")
            return $tabel;
        else
            return $arrdata;
    }

	function groupmenu($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url(), '');
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)', '');
        $this->newtable->breadcrumb('Group Menu', 'javascript:void(0)', '');
        $judul = "DAFTAR HAK AKSES";
        $KD_GROUP = $this->newsession->userdata('KD_GROUP');
        $KD_ORGANISASI = $this->newsession->userdata('KD_ORGANISASI');
        $KD_USER = $this->newsession->userdata('ID');
        if ($KD_GROUP != "SPA") {
            $addsql .= " AND B.KD_ORGANISASI = " . $this->db->escape($KD_ORGANISASI);
        }
        if ($KD_GROUP == "ADM") {
            $addsql .= " AND B.KD_GROUP IN ('USR')";
        }
		$SQL = "SELECT A.KD_GROUP, A.KD_TIPE_ORGANISASI, B.NAMA AS 'TIPE ORGANISASI', D.NAMA AS 'NAMA GROUP', 
                GROUP_CONCAT(IFNULL(C.JUDUL_MENU,'-'),' [ ',A.HAK_AKSES,' ] ' ORDER BY C.URUTAN SEPARATOR '<BR>') AS URL
                FROM app_group_menu A
                INNER JOIN app_menu C ON C.ID = A.KD_MENU
                INNER JOIN app_group D ON D.ID = A.KD_GROUP
                INNER JOIN reff_tipe_organisasi B ON B.ID = A.KD_TIPE_ORGANISASI
                WHERE 1=1" . $addsql;

        #echo $SQL; die();
        $proses = array('ADD' => array('ADD_MODAL', "management/groupmenu/add", '0', '', 'icon-plus', '', 'menu'),
            'EDIT' => array('EDIT_MODAL', "management/groupmenu/edit", '1', '', 'icon-pencil', '', 'menu'),
            'DELETE' => array('DELETE', site_url() . "/management/execute/delete/groupmenu", 'ALL', '', 'icon-trash', '', 'menu'));
    	$arrTipe = $this->get_combobox("tipe");
        $arrGroup = $this->get_combobox("group");
        $this->newtable->search(array(array('A.KD_TIPE_ORGANISASI', 'TIPE ORGANISASI', 'OPTION', $arrTipe),array('A.KD_GROUP', 'NAMA GROUP', 'OPTION', $arrGroup)));
        $this->newtable->action(site_url() . "/management/groupmenu");
        $this->newtable->hiddens(array("KD_GROUP","KD_TIPE_ORGANISASI"));
        $this->newtable->keys(array("KD_GROUP","KD_TIPE_ORGANISASI"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
		$this->newtable->groupby(array("A.KD_TIPE_ORGANISASI","A.KD_GROUP"));
        $this->newtable->show_chk(true);
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblgroupmenu");
        $this->newtable->set_divid("divtblgroupmenu");
        $this->newtable->rowcount(10);
        $this->newtable->clear();
        if ($KD_GROUP != "USR")
            $this->newtable->menu($proses);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $judul, "content" => $tabel);
        if ($this->input->post("ajax") || $act == "post")
            return $tabel;
        else
            return $arrdata;
    }

    function privilege_skema($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url(), '');
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)', '');
        $this->newtable->breadcrumb('Privilege Skema', 'javascript:void(0)', '');
        $judul = "DAFTAR HAK AKSES";
        $KD_GROUP = $this->newsession->userdata('KD_GROUP');
        $KD_ORGANISASI = $this->newsession->userdata('KD_ORGANISASI');
        $KD_USER = $this->newsession->userdata('ID');
        if ($KD_GROUP != "SPA") {
            $addsql .= " AND B.KD_ORGANISASI = " . $this->db->escape($KD_ORGANISASI);
        }
        if ($KD_GROUP == "ADM") {
            $addsql .= " AND B.KD_GROUP IN ('USR')";
        }
        $SQL = "SELECT A.KD_USER, B.USERLOGIN,
				GROUP_CONCAT(IFNULL(C.NAMA,'-'),' [ ',A.HAK_AKSES,' ] ' ORDER BY C.ID SEPARATOR '<BR>') AS URL
				FROM app_user_skema A
                INNER JOIN app_user B ON B.ID = A.KD_USER
                INNER JOIN reff_skema_tarif C ON C.ID = A.KD_SKEMA
				WHERE 1=1" . $addsql . " GROUP BY A.KD_USER";
        #echo $SQL; die();
        $proses = array('ADD' => array('ADD_MODAL', "management/privilege_skema/add", '0', '', 'icon-plus', '', 'menu'),
            'EDIT' => array('EDIT_MODAL', "management/privilege_skema/edit", '1', '', 'icon-pencil', '', 'menu'),
            'DELETE' => array('DELETE', site_url() . "/management/execute/delete/privilege_skema", 'ALL', '', 'icon-trash', '', 'menu'));
        $this->newtable->search(array(array('B.USERLOGIN', 'USERLOGIN'), array('C.JUDUL_MENU', 'JUDUL MENU'), array('A.HAK_AKSES', 'HAK AKSES')));
        $this->newtable->action(site_url() . "/management/privilege_skema");
        $this->newtable->hiddens(array("KD_USER"));
        $this->newtable->keys(array("KD_USER"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_chk(true);
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblprivilegeskema");
        $this->newtable->set_divid("divtblprivilegeskema");
        $this->newtable->rowcount(10);
        $this->newtable->clear();
        if ($KD_GROUP != "USR")
            $this->newtable->menu($proses);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $judul, "content" => $tabel);
        if ($this->input->post("ajax") || $act == "post")
            return $tabel;
        else
            return $arrdata;
    }

    function user($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('User', 'javascript:void(0)');
        $judul = "DAFTAR USER";
        $KD_GROUP = $this->newsession->userdata('KD_GROUP');
        $KD_ORGANISASI = $this->newsession->userdata('KD_ORGANISASI');
        $TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
        $ID = $this->newsession->userdata('ID');
        if ($TIPE_ORGANISASI != "SPA") {
            $addsql = " AND A.CHILD_USER = " . $this->db->escape($ID);
		}
		$proses = array(
			'ADD' => array('ADD_MODAL', "management/user/add", '0', '', 'icon-plus', '', 'menu'),
			'EDIT' => array('EDIT_MODAL', "management/user/edit", '1', '', 'icon-pencil', '', 'menu'),
			'DELETE' => array('DELETE', site_url() . "/management/execute/delete/user", 'ALL', '', 'icon-trash', '', 'menu')
		);
        $SQL = "SELECT B.NAMA AS 'ORGANISASI', A.USERLOGIN ,A.NM_LENGKAP AS 'NAMA LENGKAP' ,A.HANDPHONE ,A.EMAIL ,C.NAMA AS 'NAMA GROUP', A.KD_STATUS AS STATUS, A.ID
			  FROM app_user A
			  INNER JOIN T_ORGANISASI B ON B.ID = A.KD_ORGANISASI
			  INNER JOIN APP_GROUP C ON C.ID = A.KD_GROUP
			  WHERE 1=1 AND A.KD_STATUS!='BLOCKED' AND A.ID!=1" . $addsql;
		$check = (grant()=="W")?true:false;
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
        $this->newtable->search(array(array('A.USERLOGIN', 'USERLOGIN'), array('A.NM_LENGKAP', 'NAMA')));
        $this->newtable->action(site_url() . "/management/user");
        $this->newtable->hiddens(array("ID"));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tbluser");
        $this->newtable->set_divid("divtbluser");
        $this->newtable->rowcount('ALL');
        $this->newtable->clear();
        $this->newtable->menu($proses);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $judul, "content" => $tabel);
        if ($this->input->post("ajax") || $act == "post")
            return $tabel;
        else
            return $arrdata;
    }

    function user1($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('New User', 'javascript:void(0)');
        $judul = "DAFTAR USER BARU";
        $KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
        /* if ($TIPE_ORGANISASI != "SPA") {
            redirect(base_url('index.php'), 'refresh');
        } */
		#CONCAT('KODE TPS : ',A.KD_TPS,'<BR>KODE GUDANG : ',A.KD_GUDANG) AS 'GUDANG TPS',
        $SQL = "SELECT B.NAMA AS 'ORGANISASI', A.USERLOGIN ,A.NM_LENGKAP AS 'NAMA LENGKAP' ,A.HANDPHONE ,A.EMAIL ,C.NAMA AS 'NAMA GROUP',
              A.KD_STATUS AS STATUS, A.ID
              FROM app_user A
              INNER JOIN T_ORGANISASI B ON B.ID = A.KD_ORGANISASI
              INNER JOIN APP_GROUP C ON C.ID = A.KD_GROUP
              WHERE 1=1 AND A.KD_STATUS = 'INACTIVE' AND A.WK_REKAM IS NULL";
        $proses = array('APPROVE' => array('GET_POST',site_url()."/management/execute/approve/user", 'ALL','','icon-share-alt'),
                        'REJECT' => array('EDIT_MODAL',"management/newuser/reject", '1', '', 'icon-pencil', '', ''));
        $this->newtable->search(array(array('A.USERLOGIN', 'USERLOGIN'), array('A.NM_LENGKAP', 'NAMA')));
        $this->newtable->action(site_url() . "/management/newuser");
        $this->newtable->detail(array('POPUP', "management/newuser/detail"));
        $this->newtable->hiddens(array("ID"));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_chk(true);
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblnewuser");
        $this->newtable->set_divid("divtblnewuser");
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

    function newuser($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('New User', 'javascript:void(0)');
        $judul = "DAFTAR USER BARU";
        $KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
        /* if ($TIPE_ORGANISASI != "SPA") {
            redirect(base_url('index.php'), 'refresh');
        } */
		#CONCAT('KODE TPS : ',A.KD_TPS,'<BR>KODE GUDANG : ',A.KD_GUDANG) AS 'GUDANG TPS',
        $SQL = "SELECT B.NAMA AS 'ORGANISASI', A.USERLOGIN ,A.NM_LENGKAP AS 'NAMA LENGKAP' ,A.HANDPHONE ,A.EMAIL ,C.NAMA AS 'NAMA GROUP',
              A.KD_STATUS AS STATUS, A.ID
              FROM app_user A
              INNER JOIN T_ORGANISASI B ON B.ID = A.KD_ORGANISASI
              INNER JOIN APP_GROUP C ON C.ID = A.KD_GROUP
              WHERE 1=1 AND A.KD_STATUS = 'INACTIVE' AND A.WK_REKAM IS NULL";
        $proses = array('APPROVE' => array('GET_POST',site_url()."/management/execute/approve/user", 'ALL','','icon-share-alt'),
                        'REJECT' => array('EDIT_MODAL',"management/newuser/reject", '1', '', 'icon-pencil', '', ''));
        $this->newtable->search(array(array('A.USERLOGIN', 'USERLOGIN'), array('A.NM_LENGKAP', 'NAMA')));
        $this->newtable->action(site_url() . "/management/newuser");
        $this->newtable->detail(array('POPUP', "management/newuser/detail"));
        $this->newtable->hiddens(array("ID"));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_chk(true);
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblnewuser");
        $this->newtable->set_divid("divtblnewuser");
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

    function organisasi($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('Organisasi', 'javascript:void(0)');
        $judul = "DAFTAR ORGANISASI";
        $SQL = "SELECT A.ID, B.NAMA AS 'TIPE', A.ID_ORGANISASI AS 'CUSTOMER NUMBER',A.NPWP, A.NAMA AS ORGANISASI, A.ALAMAT, A.NOTELP AS 'NO TELP', A.NOFAX  AS 'NO FAX',
                A.EMAIL FROM t_organisasi A
                INNER JOIN REFF_TIPE_ORGANISASI B ON B.ID = A.KD_TIPE_ORGANISASI";
        $proses = array('ADD' => array('ADD_MODAL', "management/organisasi/add", '0', '', 'icon-plus', '', 'menu'),
            'EDIT' => array('EDIT_MODAL', "management/organisasi/edit", '1', '', 'icon-pencil', '', 'menu'),
            'DELETE' => array('DELETE', site_url() . "/management/execute/delete/organisasi", 'ALL', '', 'icon-trash', '', 'menu'));
		$check = (grant()=="W")?true:false;
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
        $this->newtable->search(array(array('A.NAMA', 'ORGANISASI')));
        $this->newtable->action(site_url() . "/management/organisasi");
        $this->newtable->hiddens(array("ID"));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblorganisasi");
        $this->newtable->set_divid("divtblorganisasi");
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

    function log_act($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('Log Activity ', 'javascript:void(0)');
        $judul = "DAFTAR ORGANISASI";
        $KD_GROUP = $this->newsession->userdata('KD_GROUP');
        $KD_USER = $this->newsession->userdata('ID');
        /*if ($KD_GROUP != "SPA") {
            $addsql = " AND A.KD_USER = " . $this->db->escape($KD_USER);
        }*/
        $SQL = "SELECT B.NM_LENGKAP AS USER, A.DESKRIPSI AS LOG, A.WK_REKAM AS 'WAKTU REKAM', A.ID
                FROM app_log A
                LEFT JOIN app_user B ON B.ID=A.KD_USER
                WHERE 1=1" . $addsql;
        $this->newtable->search(array(array('B.NM_LENGKAP', 'USER'), array('A.DESKRIPSI', 'LOG')));
        $this->newtable->action(site_url() . "/management/log_act");
        $this->newtable->hiddens(array("ID"));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_chk(false);
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->set_formid("tblorganisasi");
        $this->newtable->set_divid("divtblorganisasi");
        $this->newtable->rowcount(10);
        $this->newtable->orderby(3);
        $this->newtable->sortby('DESC');
        $this->newtable->clear();
        $this->newtable->menu($proses);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $judul, "content" => $tabel);
        if ($this->input->post("ajax") || $act == "post")
            return $tabel;
        else
            return $arrdata;
    }

}

?>
