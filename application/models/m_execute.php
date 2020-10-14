<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_execute extends Model {

    public function __construct() {
        parent::__construct();
    }

    function get_referensi($type, $kode, $uraian) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $return = NULL;
        switch ($type) {
            case 'port' :
                if ($kode != "") {
                    $SQL = "SELECT ID, NAMA FROM reff_pelabuhan
							WHERE ID = " . $this->db->escape(trim($kode));
                    $result = $func->main->get_result($SQL);
                    if (!$result) {
                        $arrdata['ID'] = $kode;
                        $arrdata['NAMA'] = $uraian;
                        $this->db->insert('reff_pelabuhan', $arrdata);
                    }
                }
                $return = $kode;
                break;
            case 'kapal' :
                if ($uraian != "") {
                    $SQL = "SELECT ID, NAMA FROM reff_kapal
							WHERE NAMA = " . $this->db->escape(trim($uraian));
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                        foreach ($SQL->result_array() as $row => $value) {
                            $arrdata = $value;
                        }
                        $kode_angkut = $arrdata['ID'];
                    } else {
                        $arrdata['NAMA'] = $uraian;
                        $arrdata['CALL_SIGN'] = $kode;
                        $this->db->insert('reff_kapal', $arrdata);
                        $kode_angkut = $this->db->insert_id();
                    }
                    if ($kode != "") {
                        $data['NAMA'] = $uraian;
                        $data['CALL_SIGN'] = $kode;
                        $this->db->where(array('ID' => $arrdata['ID']));
                        $this->db->update('reff_kapal', $data);
                        $kode_angkut = $arrdata['ID'];
                    }
                }
                $return = $kode_angkut;
                break;
            case 'cons' :
                if ($uraian != "") {
                    $SQL = "SELECT ID, NAMA FROM t_organisasi
							WHERE NPWP = " . $this->db->escape(trim($kode)) . " OR NAMA = " . $this->db->escape(trim($uraian));
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                        foreach ($SQL->result_array() as $row => $value) {
                            $arrdata = $value;
                        }
                        if ($kode != "") {
                            $this->db->where(array('ID' => $arrdata['ID']));
                            $this->db->update('t_organisasi', array('NPWP' => trim($kode)));
                        }
                        $kode = $arrdata['ID'];
                    } else {
                        $arrdata['NPWP'] = strtoupper(trim($kode));
                        $arrdata['NAMA'] = strtoupper(trim($uraian));
                        $arrdata['KD_TIPE_ORGANISASI'] = 'CONS';
                        $this->db->insert('t_organisasi', $arrdata);
                        $kode = $this->db->insert_id();
                    }
                }
                $return = $kode;
                break;
            case 'cont_jenis' :
                if ($kode != "") {
                    $SQL = "SELECT ID, NAMA FROM reff_cont_jenis
							WHERE ID = " . $this->db->escape(trim($kode));
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                        foreach ($SQL->result_array() as $row => $value) {
                            $arrdata = $value;
                        }
                        $kode = $arrdata['ID'];
                    } else {
                        $kode = NULL;
                    }
                }
                $return = $kode;
                break;
            case 'cont_status' :
                if ($kode != "") {
                    $SQL = "SELECT ID, NAMA FROM reff_cont_status
							WHERE ID = " . $this->db->escape(trim($kode));
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                        foreach ($SQL->result_array() as $row => $value) {
                            $arrdata = $value;
                        }
                        $kode = $arrdata['ID'];
                    } else {
                        $kode = NULL;
                    }
                }
                $return = $kode;
                break;
            case 'cont_tipe' :
                if ($kode != "") {
                    $SQL = "SELECT ID, NAMA FROM reff_cont_tipe
							WHERE ID = " . $this->db->escape(trim($kode));
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                        foreach ($SQL->result_array() as $row => $value) {
                            $arrdata = $value;
                        }
                        $kode = $arrdata['ID'];
                    } else {
                        $kode = NULL;
                    }
                }
                $return = $kode;
                break;
            case 'cont_ukuran' :
                if ($kode != "") {
                    $SQL = "SELECT ID, NAMA FROM reff_cont_ukuran
							WHERE ID = " . $this->db->escape(trim($kode));
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                        foreach ($SQL->result_array() as $row => $value) {
                            $arrdata = $value;
                        }
                        $kode = $arrdata['ID'];
                    } else {
                        $kode = NULL;
                    }
                }
                $return = $kode;
                break;
        }
        return $return;
    }

    function set_id($table, $id, $no_cont) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        if ($table == "t_cocostskms") {
            $SQL = "SELECT IFNULL(MAX(SERI)+1,1) AS ID
					FROM $table 
					WHERE ID = " . $this->db->escape($id);
        } else if ($table == "t_cocostscont") {
            $SQL = "SELECT NO_CONT AS ID
					FROM $table
					WHERE NO_CONT = " . $this->db->escape(trim($no_cont)) . "
					AND ID = " . $this->db->escape($id);
        }
        $result = $func->main->get_result($SQL);
        if ($result) {
            $ID = $SQL->row()->ID;
        }
        return $ID;
    }

    function process($type, $act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $KD_TPS = $this->newsession->userdata('KD_TPS');
        $KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
        $KD_KPBC = $this->newsession->userdata('KD_KPBC');
        $error = 0;
        if ($type == "save") {
            if ($act == "kapal") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['KD_KAPAL'] = $this->get_referensi('kapal', '', $DATA['NM_ANGKUT']);
                $DATA['KD_TPS'] = $KD_TPS;
                $DATA['KD_GUDANG'] = $KD_GUDANG;
                $DATA['TGL_TIBA'] = validate($DATA['TGL_TIBA'], 'DATE');
                $DATA['TGL_BC11'] = validate($DATA['TGL_BC11'], 'DATE');
                $DATA['KD_PEL_MUAT'] = $this->get_referensi('port', $DATA['KD_PEL_MUAT'], $this->input->post('PELABUHAN_MUAT'));
                $DATA['KD_PEL_TRANSIT'] = $this->get_referensi('port', $DATA['KD_PEL_TRANSIT'], $this->input->post('PELABUHAN_TRANSIT'));
                $DATA['KD_PEL_BONGKAR'] = $this->get_referensi('port', $DATA['KD_PEL_BONGKAR'], $this->input->post('PELABUHAN_BONGKAR'));
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                if ($id != "") {
                    $error += 1;
                    $message = "Data gagal diproses";
                } else {
                    $QUERY = "SELECT ID FROM t_cocostshdr 
							  WHERE KD_ASAL_BRG  = " . $this->db->escape(trim($DATA['KD_ASAL_BRG'])) . "
							  AND NO_BC11 = " . $this->db->escape(trim($DATA['NO_BC11'])) . "
							  AND NO_VOY_FLIGHT = " . $this->db->escape(trim($DATA['NO_VOY_FLIGHT'])) . "
							  AND TGL_TIBA = " . $this->db->escape(trim($DATA['TGL_TIBA']));
                    $result = $this->db->query($QUERY);
                    if ($result->num_rows() > 0) {
                        $error += 1;
                        $message = "Data gagal diproses, sudah terdapat data";
                    } else {
                        $result = $this->db->insert('t_cocostshdr', $DATA);
                        $ID = $this->db->insert_id();
                        if (!$result) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        }
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_cocostshdr");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }else if ($act == "request_dokumen") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['KD_TPS'] = $KD_TPS;
                $DATA['KD_GUDANG'] = $KD_GUDANG;
                $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                $DATA['TGL_DOK_INOUT'] = validate($DATA['TGL_DOK_INOUT'], 'DATE');
                $exec = $this->db->insert('t_request_custimp_hdr', $DATA);
                if (!$exec) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_request_custimp_hdr");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kapal_repo") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['KD_KAPAL'] = $this->get_referensi('kapal', '', $DATA['NM_ANGKUT']);
                $DATA['KD_TPS'] = $KD_TPS;
                $DATA['KD_GUDANG'] = $KD_GUDANG;
                $DATA['TGL_TIBA'] = validate($DATA['TGL_TIBA'], 'DATE');
                $DATA['TGL_BC11'] = validate($DATA['TGL_BC11'], 'DATE');
                $DATA['KD_PEL_MUAT'] = $this->get_referensi('port', $DATA['KD_PEL_MUAT'], $this->input->post('PELABUHAN_MUAT'));
                $DATA['KD_PEL_TRANSIT'] = $this->get_referensi('port', $DATA['KD_PEL_TRANSIT'], $this->input->post('PELABUHAN_TRANSIT'));
                $DATA['KD_PEL_BONGKAR'] = $this->get_referensi('port', $DATA['KD_PEL_BONGKAR'], $this->input->post('PELABUHAN_BONGKAR'));
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                if ($id != "") {
                    $error += 1;
                    $message = "Data gagal diproses";
                } else {
                    $QUERY = "SELECT ID FROM t_repohdr 
							  WHERE KD_ASAL_BRG  = " . $this->db->escape(trim($DATA['KD_ASAL_BRG'])) . "
							  AND NO_VOY_FLIGHT = " . $this->db->escape(trim($DATA['NO_VOY_FLIGHT'])) . "
							  AND CALL_SIGN = " . $this->db->escape(trim($DATA['CALL_SIGN'])) . "
							  AND TGL_TIBA = " . $this->db->escape(trim($DATA['TGL_TIBA']));
                    $result = $this->db->query($QUERY);
                    if ($result->num_rows() > 0) {
                        $error += 1;
                        $message = "Data gagal diproses, sudah terdapat data";
                    } else {
                        $result = $this->db->insert('t_repohdr', $DATA);
                        $ID = $this->db->insert_id();
                        if (!$result) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        }
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_repohdr");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kontainer_in") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper($b);
                }
                $NO_CONT = $this->set_id('t_cocostscont', $id, $DATA['NO_CONT']);
                if ($NO_CONT != "") {
                    $error += 1;
                    $message = "Data gagal diproses, sudah terdapat data";
                } else {
                    $DATA['KD_PEL_MUAT'] = $this->get_referensi('port', $DATA['KD_PEL_MUAT'], $this->input->post('PELABUHAN_MUAT'));
                    $DATA['KD_PEL_TRANSIT'] = $this->get_referensi('port', $DATA['KD_PEL_TRANSIT'], $this->input->post('PELABUHAN_TRANSIT'));
                    $DATA['KD_PEL_BONGKAR'] = $this->get_referensi('port', $DATA['KD_PEL_BONGKAR'], $this->input->post('PELABUHAN_BONGKAR'));
                    $DATA['KD_ORG_CONSIGNEE'] = $this->get_referensi('cons', $DATA['KD_ORG_CONSIGNEE'], $this->input->post('CONSIGNEE'));
                    $DATA['TGL_MASTER_BL_AWB'] = validate($DATA['TGL_MASTER_BL_AWB'], 'DATE');
                    $DATA['TGL_BL_AWB'] = validate($DATA['TGL_BL_AWB'], 'DATE');
                    $DATA['TGL_DOK_IN'] = validate($DATA['TGL_DOK_IN'], 'DATE');
                    $DATA['TGL_DAFTAR_PABEAN'] = validate($DATA['TGL_DAFTAR_PABEAN'], 'DATE');
                    $DATA['TGL_IJIN_TPS'] = validate($DATA['TGL_IJIN_TPS'], 'DATE');
                    $DATA['WK_IN'] = validate($DATA['WK_IN'], 'DATETIME');
                    $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                    $DATA['ID'] = $id;
                    $exec = $this->db->insert('t_cocostscont', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_cocostscont");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kemasan_in") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $SQL = "SELECT ID FROM t_cocostskms 
						WHERE ID = " . $this->db->escape($id) . "
						AND NO_MASTER_BL_AWB = " . $this->db->escape($DATA['NO_MASTER_BL_AWB']) . "
						AND NO_BL_AWB = " . $this->db->escape($DATA['NO_BL_AWB']);
                $result = $func->main->get_result($SQL);
                if (!$result) {
                    $DATA['KD_PEL_MUAT'] = $this->get_referensi('port', $DATA['KD_PEL_MUAT'], $this->input->post('PELABUHAN_MUAT'));
                    $DATA['KD_PEL_TRANSIT'] = $this->get_referensi('port', $DATA['KD_PEL_TRANSIT'], $this->input->post('PELABUHAN_TRANSIT'));
                    $DATA['KD_PEL_BONGKAR'] = $this->get_referensi('port', $DATA['KD_PEL_BONGKAR'], $this->input->post('PELABUHAN_BONGKAR'));
                    $DATA['KD_ORG_CONSIGNEE'] = $this->get_referensi('cons', $DATA['KD_ORG_CONSIGNEE'], $this->input->post('CONSIGNEE'));
                    $DATA['TGL_MASTER_BL_AWB'] = validate($DATA['TGL_MASTER_BL_AWB'], 'DATE');
                    $DATA['TGL_BL_AWB'] = validate($DATA['TGL_BL_AWB'], 'DATE');
                    $DATA['TGL_DOK_IN'] = validate($DATA['TGL_DOK_IN'], 'DATE');
                    $DATA['TGL_DAFTAR_PABEAN'] = validate($DATA['TGL_DAFTAR_PABEAN'], 'DATE');
                    $DATA['TGL_IJIN_TPS'] = validate($DATA['TGL_IJIN_TPS'], 'DATE');
                    $DATA['WK_IN'] = validate($DATA['WK_IN'], 'DATETIME');
                    $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                    $DATA['ID'] = $id;
                    $DATA['SERI'] = $this->set_id('t_cocostskms', $id);
                    $exec = $this->db->insert('t_cocostskms', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                } else {
                    $error += 1;
                    $message = "Data gagal diproses, sudah terdapat data";
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_cocostskms");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "request_dokumen") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['KD_TPS'] = $KD_TPS;
                $DATA['KD_GUDANG'] = $KD_GUDANG;
                $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                $DATA['TGL_DOK_INOUT'] = validate($DATA['TGL_DOK_INOUT'], 'DATE');
                $exec = $this->db->insert('t_request_custimp_hdr', $DATA);
                if (!$exec) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_request_custimp_hdr");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "pengajuan_plp") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper($b);
                }
                $SQL = "SELECT ID FROM t_request_plp_hdr
						WHERE NO_SURAT = " . $this->db->escape(trim($DATA['NO_SURAT'])) . "
						AND TGL_SURAT = " . $this->db->escape(trim(validate($DATA['TGL_SURAT'], 'DATE')));
                $result = $func->main->get_result($SQL);
                if ($result) {
                    $error += 1;
                    $message = "Data gagal diproses, sudah terdapat data plp";
                } else {
                    $id_cont = $this->input->post('tmpchktblkontainer');
                    $arr_cont = explode("*", $id_cont);
                    $insertCont = true;
                    $arr_cont = array_filter($arr_cont);
                    if (count($arr_cont) > 0) {
                        for ($a = 0; $a < count($arr_cont); $a++) {
                            $cont = explode("~", $arr_cont[$a]);
                            $SQL_CONT = "SELECT A.ID, A.NO_CONT, A.KD_CONT_UKURAN, B.KD_KAPAL, B.NM_ANGKUT, B.NO_VOY_FLIGHT, B.TGL_TIBA,
										 B.NO_BC11, B.TGL_BC11
										 FROM t_cocostscont A
										 INNER JOIN t_cocostshdr B ON B.ID=A.ID
										 WHERE A.ID = " . $this->db->escape($cont[0]) . "
										 AND A.NO_CONT = " . $this->db->escape($cont[1]);
                            $result_cont = $func->main->get_result($SQL_CONT);
                            if ($result_cont) {
                                foreach ($SQL_CONT->result_array() as $row => $value) {
                                    $arrcont = $value;
                                }
                            } else {
                                $insertCont = false;
                            }
                        }
                    } else {
                        $insertCont = false;
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                    if ($insertCont) {
                        $DATA['KD_COCOSTSHDR'] = $arrcont['ID'];
                        $DATA['KD_KAPAL'] = $arrcont['KD_KAPAL'];
                        $DATA['NM_ANGKUT'] = $arrcont['NM_ANGKUT'];
                        $DATA['NO_VOY_FLIGHT'] = $arrcont['NO_VOY_FLIGHT'];
                        $DATA['TGL_TIBA'] = $arrcont['TGL_TIBA'];
                        $DATA['NO_BC11'] = $arrcont['NO_BC11'];
                        $DATA['TGL_BC11'] = $arrcont['TGL_BC11'];
                        $DATA['KD_TPS_ASAL'] = $KD_TPS;
                        $DATA['KD_GUDANG_ASAL'] = $KD_GUDANG;
                        $DATA['KD_KPBC'] = $KD_KPBC;
                        $DATA['YOR_ASAL'] = intval($DATA['YOR_ASAL']);
                        $DATA['YOR_TUJUAN'] = intval($DATA['YOR_TUJUAN']);
                        $DATA['TGL_SURAT'] = validate($DATA['TGL_SURAT'], 'DATE');
                        $DATA['KD_STATUS'] = '100';
                        $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                        #print_r($DATA); die();
                        $this->db->insert('t_request_plp_hdr', $DATA);
                        $ID_PLP = $this->db->insert_id();
                        if (count($arr_cont) > 0) {
                            for ($a = 0; $a < count($arr_cont); $a++) {
                                $cont = explode("~", $arr_cont[$a]);
                                $SQL_CONT = "SELECT ID, NO_CONT, KD_CONT_UKURAN FROM t_cocostscont
											 WHERE ID = " . $this->db->escape($cont[0]) . "
											 AND NO_CONT = " . $this->db->escape($cont[1]);
                                $result_cont = $func->main->get_result($SQL_CONT);
                                if ($result_cont) {
                                    foreach ($SQL_CONT->result_array() as $row => $value) {
                                        $arrcont = $value;
                                    }
                                    $arrcont['ID'] = $ID_PLP;
                                    $arrcont['NO_CONT'] = $arrcont['NO_CONT'];
                                    $arrcont['KD_CONT_UKURAN'] = $arrcont['KD_CONT_UKURAN'];
                                    $this->db->insert('t_request_plp_cont', $arrcont);
                                }
                            }
                        }
                    } else {
                        $error += 1;
                        $message = "Data gagal diproses, periksa data kontainer";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_request_plp_hdr,t_request_plp_cont");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "pembatalan_plp") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper($b);
                }
                $SQL = "SELECT ID FROM t_request_batal_plp_hdr
						WHERE NO_SURAT = " . $this->db->escape(trim($DATA['NO_SURAT'])) . "
						AND TGL_SURAT = " . $this->db->escape(trim(validate($DATA['TGL_SURAT'], 'DATE')));
                $result = $func->main->get_result($SQL);
                if ($result) {
                    $error += 1;
                    $message = "Data gagal diproses, sudah terdapat data pembatalan plp";
                } else {
                    $id_cont = $this->input->post('tmpchktblresponplpkontainer');
                    $arr_cont = explode("*", $id_cont);
                    $insertCont = true;
                    $arr_cont = array_filter($arr_cont);
                    if (count($arr_cont) > 0) {
                        for ($a = 0; $a < count($arr_cont); $a++) {
                            $cont = explode("~", $arr_cont[$a]);
                            $SQL_CONT = "SELECT A.ID, A.NO_CONT, A.KD_CONT_UKURAN, A.KD_CONT_JENIS
										 FROM t_respon_plp_asal_cont A
										 INNER JOIN t_respon_plp_asal_hdr B ON B.ID=A.ID
										 WHERE A.ID = " . $this->db->escape($cont[0]) . "
										 AND A.NO_CONT = " . $this->db->escape($cont[1]);
                            $result_cont = $func->main->get_result($SQL_CONT);
                            if ($result_cont) {
                                foreach ($SQL_CONT->result_array() as $row => $value) {
                                    $arrcont = $value;
                                }
                            } else {
                                $insertCont = false;
                            }
                        }
                    } else {
                        $error += 1;
                        $message = "Data gagal diproses";
                        $insertCont = false;
                    }
                    if ($insertCont) {
                        $DATA['KD_RESPON_PLP_ASAL'] = $arrcont['ID'];
                        $DATA['KD_TPS'] = $KD_TPS;
                        $DATA['KD_GUDANG'] = $KD_GUDANG;
                        $DATA['KD_KPBC'] = $KD_KPBC;
                        $DATA['TGL_SURAT'] = validate($DATA['TGL_SURAT'], 'DATE');
                        $DATA['KD_STATUS'] = '100';
                        $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                        $this->db->insert('t_request_batal_plp_hdr', $DATA);
                        $ID_BATAL = $this->db->insert_id();
                        if (count($arr_cont) > 0) {
                            for ($a = 0; $a < count($arr_cont); $a++) {
                                $cont = explode("~", $arr_cont[$a]);
                                $SQL_CONT = "SELECT ID, NO_CONT, KD_CONT_UKURAN FROM t_respon_plp_asal_cont
											 WHERE ID = " . $this->db->escape($cont[0]) . "
											 AND NO_CONT = " . $this->db->escape($cont[1]);
                                $result_cont = $func->main->get_result($SQL_CONT);
                                if ($result_cont) {
                                    foreach ($SQL_CONT->result_array() as $row => $value) {
                                        $arrcont = $value;
                                    }
                                    $arrcont['ID'] = $ID_BATAL;
                                    $arrcont['NO_CONT'] = $arrcont['NO_CONT'];
                                    $arrcont['KD_CONT_UKURAN'] = $arrcont['KD_CONT_UKURAN'];
                                    $this->db->insert('t_request_batal_plp_cont', $arrcont);
                                }
                            }
                        }
                    } else {
                        $error += 1;
                        $message = "Data gagal diproses, periksa data respons";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_request_batal_plp_hdr,t_request_batal_plp_cont");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "update") {
            if ($act == "kapal") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['KD_KAPAL'] = $this->get_referensi('kapal', '', $DATA['NM_ANGKUT']);
                $DATA['TGL_TIBA'] = validate(date_input($DATA['TGL_TIBA']));
                $DATA['TGL_BC11'] = validate(date_input($DATA['TGL_BC11']));
                $DATA['KD_PEL_MUAT'] = $this->get_referensi('port', $DATA['KD_PEL_MUAT'], $this->input->post('PELABUHAN_MUAT'));
                $DATA['KD_PEL_TRANSIT'] = $this->get_referensi('port', $DATA['KD_PEL_TRANSIT'], $this->input->post('PELABUHAN_TRANSIT'));
                $DATA['KD_PEL_BONGKAR'] = $this->get_referensi('port', $DATA['KD_PEL_BONGKAR'], $this->input->post('PELABUHAN_BONGKAR'));
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                $SQL = "SELECT ID FROM t_cocostshdr
						WHERE KD_ASAL_BRG  = " . $this->db->escape(trim($DATA['KD_ASAL_BRG'])) . "
						AND NO_BC11 = " . $this->db->escape(trim($DATA['NO_BC11'])) . "
						AND NO_VOY_FLIGHT = " . $this->db->escape(trim($DATA['NO_VOY_FLIGHT'])) . "
						AND TGL_TIBA = " . $this->db->escape(trim($DATA['TGL_TIBA'])) . "
						ORDER BY ID ASC LIMIT 1";
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    if ($arrdata['ID'] == $id) {
                        $this->db->where(array('ID' => $id));
                        $exec = $this->db->update('t_cocostshdr', $DATA);
                        if (!$exec) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        } else {
                            //update pelabuhan detail
                            /* $DTL = array('KD_PEL_MUAT'	=> $DATA['KD_PEL_MUAT'],
                              'KD_PEL_TRANSIT'	=> $DATA['KD_PEL_TRANSIT'],
                              'KD_PEL_BONGKAR'	=> $DATA['KD_PEL_BONGKAR']);
                              $this->db->where(array('ID' => $id));
                              $this->db->update('t_cocostskms', $DTL);
                              $this->db->where(array('ID' => $id));
                              $this->db->update('t_cocostskms', $DTL); */
                        }
                    } else {
                        $QUERY = "SELECT ID FROM t_cocostshdr
								  WHERE KD_ASAL_BRG  = " . $this->db->escape(trim($DATA['KD_ASAL_BRG'])) . "
								  AND NO_BC11 = " . $this->db->escape(trim($DATA['NO_BC11'])) . "
								  AND NO_VOY_FLIGHT = " . $this->db->escape(trim($DATA['NO_VOY_FLIGHT'])) . "
								  AND TGL_TIBA = " . $this->db->escape(trim($DATA['TGL_TIBA'])) . "
								  ORDER BY ID ASC LIMIT 1";
                        $exec = $func->main->get_result($QUERY);
                        if ($exec) {
                            $error += 1;
                            $message = "Data gagal diproses, sudah terdapat data";
                        } else {
                            $this->db->where(array('ID' => $id));
                            $exec = $this->db->update('t_cocostshdr', $DATA);
                            if (!$exec) {
                                $error += 1;
                                $message = "Data gagal diproses";
                            } else {
                                //update pelabuhan detail
                                /* $DTL = array('KD_PEL_MUAT'	=> $DATA['KD_PEL_MUAT'],
                                  'KD_PEL_TRANSIT'	=> $DATA['KD_PEL_TRANSIT'],
                                  'KD_PEL_BONGKAR'	=> $DATA['KD_PEL_BONGKAR']);
                                  $this->db->where(array('ID' => $id));
                                  $this->db->update('t_cocostskms', $DTL);
                                  $this->db->where(array('ID' => $id));
                                  $this->db->update('t_cocostskms', $DTL); */
                            }
                        }
                    }
                } else {
                    $this->db->where(array('ID' => $id));
                    $exec = $this->db->update('t_cocostshdr', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    } else {
                        //update pelabuhan detail
                        /* $DTL = array('KD_PEL_MUAT'	=> $DATA['KD_PEL_MUAT'],
                          'KD_PEL_TRANSIT'	=> $DATA['KD_PEL_TRANSIT'],
                          'KD_PEL_BONGKAR'	=> $DATA['KD_PEL_BONGKAR']);
                          $this->db->where(array('ID' => $id));
                          $this->db->update('t_cocostskms', $DTL);
                          $this->db->where(array('ID' => $id));
                          $this->db->update('t_cocostskms', $DTL); */
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_cocostshdr");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kapal_repo") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $arrayIMP = array('1', '2');
                $arrayEXP = array('3', '4');
                $DATA['KD_KAPAL'] = $this->get_referensi('kapal', '', $DATA['NM_ANGKUT']);
                $DATA['TGL_TIBA'] = validate($DATA['TGL_TIBA'], 'DATE');
                $DATA['TGL_BC11'] = validate($DATA['TGL_BC11'], 'DATE');
                $DATA['KD_PEL_MUAT'] = $this->get_referensi('port', $DATA['KD_PEL_MUAT'], $this->input->post('PELABUHAN_MUAT'));
                $DATA['KD_PEL_TRANSIT'] = $this->get_referensi('port', $DATA['KD_PEL_TRANSIT'], $this->input->post('PELABUHAN_TRANSIT'));
                $DATA['KD_PEL_BONGKAR'] = $this->get_referensi('port', $DATA['KD_PEL_BONGKAR'], $this->input->post('PELABUHAN_BONGKAR'));
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                $SQL = "SELECT ID FROM t_repohdr
						WHERE KD_ASAL_BRG  = " . $this->db->escape(trim($DATA['KD_ASAL_BRG'])) . "
						AND CALL_SIGN = " . $this->db->escape(trim($DATA['CALL_SIGN'])) . "
						AND NO_VOY_FLIGHT = " . $this->db->escape(trim($DATA['NO_VOY_FLIGHT'])) . "
						AND TGL_TIBA = " . $this->db->escape(trim($DATA['TGL_TIBA'])) . "
						ORDER BY ID ASC LIMIT 1";
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    if ($arrdata['ID'] == $id) {
                        $this->db->where(array('ID' => $id));
                        $exec = $this->db->update('t_repohdr', $DATA);
                        if (!$exec) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        } else {
                            if (in_array($DATA['KD_ASAL_BRG'], $arrayIMP)) {
                                $arrbc11 = array('NO_BC11' => trim($DATA['NO_BC11']),
                                    'TGL_BC11' => trim($DATA['TGL_BC11']));
                                $this->db->where(array('NO_VOY_FLIGHT' => trim($DATA['NO_VOY_FLIGHT']),
                                    'CALL_SIGN' => trim($DATA['CALL_SIGN']),
                                    'TGL_TIBA' => trim($DATA['TGL_TIBA'])));
                                $this->db->where_in('KD_ASAL_BRG', array('1', '2'));
                                $this->db->update('t_repohdr', $arrbc11);
                            } else if (in_array($DATA['KD_ASAL_BRG'], $arrayEXP)) {
                                $arrbc11 = array('NO_BC11' => trim($DATA['NO_BC11']),
                                    'TGL_BC11' => trim($DATA['TGL_BC11']));
                                $this->db->where(array('NO_VOY_FLIGHT' => trim($DATA['NO_VOY_FLIGHT']),
                                    'CALL_SIGN' => trim($DATA['CALL_SIGN']),
                                    'TGL_TIBA' => trim($DATA['TGL_TIBA'])));
                                $this->db->where_in('KD_ASAL_BRG', array('3', '4'));
                                $this->db->update('t_repohdr', $arrbc11);
                            }
                        }
                    } else {
                        $QUERY = "SELECT ID FROM t_repohdr
								  WHERE KD_ASAL_BRG  = " . $this->db->escape(trim($DATA['KD_ASAL_BRG'])) . "
								  AND CALL_SIGN = " . $this->db->escape(trim($DATA['CALL_SIGN'])) . "
								  AND NO_VOY_FLIGHT = " . $this->db->escape(trim($DATA['NO_VOY_FLIGHT'])) . "
								  AND TGL_TIBA = " . $this->db->escape(trim($DATA['TGL_TIBA'])) . "
								  ORDER BY ID ASC LIMIT 1";
                        $exec = $func->main->get_result($QUERY);
                        if ($exec) {
                            $error += 1;
                            $message = "Data gagal diproses, sudah terdapat data";
                        } else {
                            $this->db->where(array('ID' => $id));
                            $exec = $this->db->update('t_repohdr', $DATA);
                            if (!$exec) {
                                $error += 1;
                                $message = "Data gagal diproses";
                            } else {
                                if (in_array($DATA['KD_ASAL_BRG'], $arrayIMP)) {
                                    $arrbc11 = array('NO_BC11' => trim($DATA['NO_BC11']),
                                        'TGL_BC11' => trim($DATA['TGL_BC11']));
                                    $this->db->where(array('NO_VOY_FLIGHT' => trim($DATA['NO_VOY_FLIGHT']),
                                        'CALL_SIGN' => trim($DATA['CALL_SIGN']),
                                        'TGL_TIBA' => trim($DATA['TGL_TIBA'])));
                                    $this->db->where_in('KD_ASAL_BRG', array('1', '2'));
                                    $this->db->update('t_repohdr', $arrbc11);
                                } else if (in_array($DATA['KD_ASAL_BRG'], $arrayEXP)) {
                                    $arrbc11 = array('NO_BC11' => trim($DATA['NO_BC11']),
                                        'TGL_BC11' => trim($DATA['TGL_BC11']));
                                    $this->db->where(array('NO_VOY_FLIGHT' => trim($DATA['NO_VOY_FLIGHT']),
                                        'CALL_SIGN' => trim($DATA['CALL_SIGN']),
                                        'TGL_TIBA' => trim($DATA['TGL_TIBA'])));
                                    $this->db->where_in('KD_ASAL_BRG', array('3', '4'));
                                    $this->db->update('t_repohdr', $arrbc11);
                                }
                            }
                        }
                    }
                } else {
                    $this->db->where(array('ID' => $id));
                    $exec = $this->db->update('t_repohdr', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    } else {
                        if (in_array($DATA['KD_ASAL_BRG'], $arrayIMP)) {
                            $arrbc11 = array('NO_BC11' => trim($DATA['NO_BC11']),
                                'TGL_BC11' => trim($DATA['TGL_BC11']));
                            $this->db->where(array('NO_VOY_FLIGHT' => trim($DATA['NO_VOY_FLIGHT']),
                                'CALL_SIGN' => trim($DATA['CALL_SIGN']),
                                'TGL_TIBA' => trim($DATA['TGL_TIBA'])));
                            $this->db->where_in('KD_ASAL_BRG', array('1', '2'));
                            $this->db->update('t_repohdr', $arrbc11);
                        } else if (in_array($DATA['KD_ASAL_BRG'], $arrayEXP)) {
                            $arrbc11 = array('NO_BC11' => trim($DATA['NO_BC11']),
                                'TGL_BC11' => trim($DATA['TGL_BC11']));
                            $this->db->where(array('NO_VOY_FLIGHT' => trim($DATA['NO_VOY_FLIGHT']),
                                'CALL_SIGN' => trim($DATA['CALL_SIGN']),
                                'TGL_TIBA' => trim($DATA['TGL_TIBA'])));
                            $this->db->where_in('KD_ASAL_BRG', array('3', '4'));
                            $this->db->update('t_repohdr', $arrbc11);
                        }
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_repohdr");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kontainer_in") {
                $arrid = explode('~', $id);
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['TGL_MASTER_BL_AWB'] = validate($DATA['TGL_MASTER_BL_AWB'], 'DATE');
                $DATA['TGL_BL_AWB'] = validate($DATA['TGL_BL_AWB'], 'DATE');
                $DATA['KD_PEL_MUAT'] = $this->get_referensi('port', $DATA['KD_PEL_MUAT'], $this->input->post('PELABUHAN_MUAT'));
                $DATA['KD_PEL_TRANSIT'] = $this->get_referensi('port', $DATA['KD_PEL_TRANSIT'], $this->input->post('PELABUHAN_TRANSIT'));
                $DATA['KD_PEL_BONGKAR'] = $this->get_referensi('port', $DATA['KD_PEL_BONGKAR'], $this->input->post('PELABUHAN_BONGKAR'));
                $DATA['TGL_DOK_IN'] = validate($DATA['TGL_DOK_IN'], 'DATE');
                $DATA['TGL_DAFTAR_PABEAN'] = validate($DATA['TGL_DAFTAR_PABEAN'], 'DATE');
                $DATA['TGL_IJIN_TPS'] = validate($DATA['TGL_IJIN_TPS'], 'DATE');
                $DATA['WK_IN'] = validate($DATA['WK_IN'], 'DATETIME');
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                $SQL = "SELECT NO_CONT FROM t_cocostscont
						WHERE ID  = " . $this->db->escape(trim($arrid[0])) . "
						AND NO_CONT = " . $this->db->escape(trim($DATA['NO_CONT']));
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    if (trim($arrdata['NO_CONT']) == trim($arrid[1])) {
                        $this->db->where(array('ID' => $arrid[0], 'NO_CONT' => trim($arrid[1])));
                        $exec = $this->db->update('t_cocostscont', $DATA);
                        if (!$exec) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        }
                    } else {
                        $QUERY = "SELECT NO_CONT FROM t_cocostscont
								  WHERE ID  = " . $this->db->escape(trim($arrid[0])) . "
								  AND NO_CONT = " . $this->db->escape(trim($DATA['NO_CONT']));
                        $exec = $func->main->get_result($QUERY);
                        if ($exec) {
                            $error += 1;
                            $message = "Data gagal diproses, sudah terdapat data";
                        } else {
                            $this->db->where(array('ID' => $arrid[0], 'NO_CONT' => $arrid[1]));
                            $exec = $this->db->update('t_cocostscont', $DATA);
                            if (!$exec) {
                                $error += 1;
                                $message = "Data gagal diproses";
                            }
                        }
                    }
                } else {
                    $this->db->where(array('ID' => $arrid[0], 'NO_CONT' => $arrid[1]));
                    $exec = $this->db->update('t_cocostscont', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_cocostscont");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kontainer_in_repo") {
                $arrid = explode('~', $id);
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['TGL_MASTER_BL_AWB'] = validate($DATA['TGL_MASTER_BL_AWB'], 'DATE');
                $DATA['TGL_BL_AWB'] = validate($DATA['TGL_BL_AWB'], 'DATE');
                $DATA['KD_PEL_MUAT'] = $this->get_referensi('port', $DATA['KD_PEL_MUAT'], $this->input->post('PELABUHAN_MUAT'));
                $DATA['KD_PEL_TRANSIT'] = $this->get_referensi('port', $DATA['KD_PEL_TRANSIT'], $this->input->post('PELABUHAN_TRANSIT'));
                $DATA['KD_PEL_BONGKAR'] = $this->get_referensi('port', $DATA['KD_PEL_BONGKAR'], $this->input->post('PELABUHAN_BONGKAR'));
                $DATA['TGL_DOK_IN'] = validate($DATA['TGL_DOK_IN'], 'DATE');
                $DATA['TGL_DAFTAR_PABEAN'] = validate($DATA['TGL_DAFTAR_PABEAN'], 'DATE');
                $DATA['TGL_IJIN_TPS'] = validate($DATA['TGL_IJIN_TPS'], 'DATE');
                $DATA['WK_IN'] = validate($DATA['WK_IN'], 'DATETIME');
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                $SQL = "SELECT NO_CONT FROM t_repocont
						WHERE ID  = " . $this->db->escape(trim($arrid[0])) . "
						AND NO_CONT = " . $this->db->escape(trim($DATA['NO_CONT']));
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    if (trim($arrdata['NO_CONT']) == trim($arrid[1])) {
                        $this->db->where(array('ID' => $arrid[0], 'NO_CONT' => trim($arrid[1])));
                        $exec = $this->db->update('t_repocont', $DATA);
                        if (!$exec) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        }
                    } else {
                        $QUERY = "SELECT NO_CONT FROM t_repocont
								  WHERE ID  = " . $this->db->escape(trim($arrid[0])) . "
								  AND NO_CONT = " . $this->db->escape(trim($DATA['NO_CONT']));
                        $exec = $func->main->get_result($QUERY);
                        if ($exec) {
                            $error += 1;
                            $message = "Data gagal diproses, sudah terdapat data";
                        } else {
                            $this->db->where(array('ID' => $arrid[0], 'NO_CONT' => $arrid[1]));
                            $exec = $this->db->update('t_repocont', $DATA);
                            if (!$exec) {
                                $error += 1;
                                $message = "Data gagal diproses";
                            }
                        }
                    }
                } else {
                    $this->db->where(array('ID' => $arrid[0], 'NO_CONT' => $arrid[1]));
                    $exec = $this->db->update('t_repocont', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_repocont");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kontainer_out") {
                $arrid = explode('~', $id);
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['TGL_DOK_OUT'] = validate($DATA['TGL_DOK_OUT'], 'DATE');
                $DATA['TGL_DAFTAR_PABEAN'] = validate($DATA['TGL_DAFTAR_PABEAN'], 'DATE');
                $DATA['TGL_IJIN_TPS'] = validate($DATA['TGL_IJIN_TPS'], 'DATE');
                $DATA['TGL_SEGEL_BC'] = validate($DATA['TGL_SEGEL_BC'], 'DATE');
                $DATA['WK_OUT'] = validate($DATA['WK_OUT'], 'DATETIME');
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->where(array('ID' => $arrid[0], 'NO_CONT' => $arrid[1]));
                $exec = $this->db->update('t_cocostscont', $DATA);
                if (!$exec) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_cocostscont");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kontainer_out_repo") {
                $arrid = explode('~', $id);
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['TGL_DOK_OUT'] = validate($DATA['TGL_DOK_OUT'], 'DATE');
                $DATA['TGL_DAFTAR_PABEAN'] = validate($DATA['TGL_DAFTAR_PABEAN'], 'DATE');
                $DATA['TGL_IJIN_TPS'] = validate($DATA['TGL_IJIN_TPS'], 'DATE');
                $DATA['TGL_SEGEL_BC'] = validate($DATA['TGL_SEGEL_BC'], 'DATE');
                $DATA['WK_OUT'] = validate($DATA['WK_OUT'], 'DATETIME');
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->where(array('ID' => $arrid[0], 'NO_CONT' => $arrid[1]));
                $exec = $this->db->update('t_repocont', $DATA);
                if (!$exec) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_repocont");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kemasan_in") {
                $arrid = explode("~", $id);
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['KD_PEL_MUAT'] = $this->get_referensi('port', $DATA['KD_PEL_MUAT'], $this->input->post('PELABUHAN_MUAT'));
                $DATA['KD_PEL_TRANSIT'] = $this->get_referensi('port', $DATA['KD_PEL_TRANSIT'], $this->input->post('PELABUHAN_TRANSIT'));
                $DATA['KD_PEL_BONGKAR'] = $this->get_referensi('port', $DATA['KD_PEL_BONGKAR'], $this->input->post('PELABUHAN_BONGKAR'));
                $DATA['KD_ORG_CONSIGNEE'] = $this->get_referensi('cons', $DATA['KD_ORG_CONSIGNEE'], $this->input->post('CONSIGNEE'));
                $DATA['TGL_MASTER_BL_AWB'] = validate($DATA['TGL_MASTER_BL_AWB'], 'DATE');
                $DATA['TGL_BL_AWB'] = validate($DATA['TGL_BL_AWB'], 'DATE');
                $DATA['TGL_DOK_IN'] = validate($DATA['TGL_DOK_IN'], 'DATE');
                $DATA['TGL_DAFTAR_PABEAN'] = validate($DATA['TGL_DAFTAR_PABEAN'], 'DATE');
                $DATA['TGL_IJIN_TPS'] = validate($DATA['TGL_IJIN_TPS'], 'DATE');
                $DATA['WK_IN'] = validate($DATA['WK_IN'], 'DATETIME');
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                $DATA['ID'] = $id;
                $DATA['SERI'] = $this->set_id('t_cocostskms', $id);
                $SQL = "SELECT SERI FROM t_cocostskms
						WHERE ID  = " . $this->db->escape(trim($arrid[0])) . "
						AND NO_MASTER_BL_AWB = " . $this->db->escape(trim($DATA['NO_MASTER_BL_AWB'])) . "
						AND NO_BL_AWB = " . $this->db->escape(trim($DATA['NO_BL_AWB']));
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    if (trim($arrdata['SERI']) == trim($arrid[1])) {
                        $this->db->where(array('ID' => $arrid[0], 'SERI' => trim($arrid[1])));
                        $exec = $this->db->update('t_cocostskms', $DATA);
                        if (!$exec) {
                            $error += 1;
                            $message = "Data gagal diproses";
                        }
                    } else {
                        $QUERY = "SELECT SERI FROM t_cocostskms
								  WHERE ID  = " . $this->db->escape(trim($arrid[0])) . "
								  AND NO_MASTER_BL_AWB = " . $this->db->escape(trim($DATA['NO_MASTER_BL_AWB'])) . "
								  AND NO_BL_AWB = " . $this->db->escape(trim($DATA['NO_BL_AWB']));
                        $exec = $func->main->get_result($QUERY);
                        if ($exec) {
                            $error += 1;
                            $message = "Data gagal diproses, sudah terdapat data";
                        } else {
                            $this->db->where(array('ID' => $arrid[0], 'SERI' => $arrid[1]));
                            $exec = $this->db->update('t_cocostskms', $DATA);
                            if (!$exec) {
                                $error += 1;
                                $message = "Data gagal diproses";
                            }
                        }
                    }
                } else {
                    $this->db->where(array('ID' => $arrid[0], 'SERI' => $arrid[1]));
                    $exec = $this->db->update('t_cocostskms', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_cocostskms");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "kemasan_out") {
                $arrid = explode("~", $id);
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['TGL_DOK_OUT'] = validate($DATA['TGL_DOK_OUT'], 'DATE');
                $DATA['TGL_DAFTAR_PABEAN'] = validate($DATA['TGL_DAFTAR_PABEAN'], 'DATE');
                $DATA['TGL_IJIN_TPS'] = validate($DATA['TGL_IJIN_TPS'], 'DATE');
                $DATA['TGL_SEGEL_BC'] = validate($DATA['TGL_SEGEL_BC'], 'DATE');
                $DATA['WK_OUT'] = validate($DATA['WK_OUT'], 'DATETIME');
                $DATA['WK_REKAM'] = date('Y-m-d H:i:s');
                $DATA['ID'] = $id;
                $this->db->where(array('ID' => $arrid[0], 'SERI' => $arrid[1]));
                $exec = $this->db->update('t_cocostskms', $DATA);
                if (!$exec) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_cocostskms");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "request_dokumen") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                $DATA['TGL_DOK_INOUT'] = validate($DATA['TGL_DOK_INOUT'], 'DATE');
                $this->db->where(array('ID' => $id));
                $exec = $this->db->update('t_request_custimp_hdr', $DATA);
                if (!$exec) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_request_custimp_hdr");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "send_request_dokumen") {
                foreach ($this->input->post('tb_chktblrequestdokumen') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $ACTION = strtolower($arrchk[1]);
                    $DATA['KD_STATUS'] = '200';
                    $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                    $this->db->where(array('ID' => $ID));
                    $exec = $this->db->update('t_request_custimp_hdr', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_request_custimp_hdr");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/" . $ACTION . "/post";
                } else {
                    echo "MSG#ERR#Data gagal diproses#";
                }
            } else if ($act == "pengajuan_plp") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = trim(strtoupper($b));
                }
                $DATA['TGL_SURAT'] = validate($DATA['TGL_SURAT'], 'DATE');
                $DATA['KD_STATUS'] = '100';
                $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                $updateCont = false;
                $SQL = "SELECT ID FROM t_request_plp_hdr
						WHERE NO_SURAT = " . $this->db->escape(trim($DATA['NO_SURAT'])) . "
						AND TGL_SURAT = " . $this->db->escape(trim($DATA['TGL_SURAT']));
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    if ($arrdata['ID'] == $id) {
                        $QUERY = "SELECT B.KD_KAPAL, B.NM_ANGKUT, B.NO_VOY_FLIGHT, B.TGL_TIBA, B.NO_BC11, B.TGL_BC11
								  FROM t_request_plp_hdr A
								  INNER JOIN t_cocostshdr B ON B.ID=A.KD_COCOSTSHDR
								  WHERE A.ID = " . $this->db->escape($id);
                        $res = $func->main->get_result($QUERY);
                        if ($res) {
                            foreach ($QUERY->result_array() as $row => $value) {
                                $arrdisch = $value;
                            }
                            if ($arrdisch['KD_KAPAL'] != "")
                                $DATA['KD_KAPAL'] = trim($arrdisch['KD_KAPAL']);
                            else
                                unset($DATA['KD_KAPAL']);
                            if ($arrdisch['NM_ANGKUT'] != "")
                                $DATA['NM_ANGKUT'] = trim($arrdisch['NM_ANGKUT']);
                            else
                                unset($DATA['NM_ANGKUT']);
                            if ($arrdisch['NO_VOY_FLIGHT'] != "")
                                $DATA['NO_VOY_FLIGHT'] = trim($arrdisch['NO_VOY_FLIGHT']);
                            else
                                unset($DATA['NO_VOY_FLIGHT']);
                            if ($arrdisch['TGL_TIBA'] != "")
                                $DATA['TGL_TIBA'] = trim($arrdisch['TGL_TIBA']);
                            else
                                unset($DATA['TGL_TIBA']);
                            if ($arrdisch['NO_BC11'] != "")
                                $DATA['NO_BC11'] = trim($arrdisch['NO_BC11']);
                            else
                                unset($DATA['NO_BC11']);
                            if ($arrdisch['TGL_BC11'] != "")
                                $DATA['TGL_BC11'] = trim($arrdisch['TGL_BC11']);
                            else
                                unset($DATA['TGL_BC11']);
                        }
                        $this->db->where(array('ID' => $id));
                        $this->db->update('t_request_plp_hdr', $DATA);
                        $updateCont = true;
                    }else {
                        $QUERY = "SELECT ID FROM t_request_plp_hdr
								  WHERE NO_SURAT = " . $this->db->escape(trim($DATA['NO_SURAT'])) . "
								  AND TGL_SURAT = " . $this->db->escape(trim($DATA['TGL_SURAT']));
                        $res = $func->main->get_result($QUERY);
                        if ($res) {
                            $error += 1;
                            $message = "Data gagal diproses, sudah terdapat data plp";
                        } else {
                            $SQL = "SELECT B.KD_KAPAL, B.NM_ANGKUT, B.NO_VOY_FLIGHT, B.TGL_TIBA, B.NO_BC11, B.TGL_BC11
									FROM t_request_plp_hdr A
									INNER JOIN t_cocostshdr B ON B.ID=A.KD_COCOSTSHDR
									WHERE A.ID = " . $this->db->escape($id);
                            $result = $func->main->get_result($SQL);
                            if ($result) {
                                foreach ($SQL->result_array() as $row => $value) {
                                    $arrdisch = $value;
                                }
                                if ($arrdisch['KD_KAPAL'] != "")
                                    $DATA['KD_KAPAL'] = trim($arrdisch['KD_KAPAL']);
                                else
                                    unset($DATA['KD_KAPAL']);
                                if ($arrdisch['NM_ANGKUT'] != "")
                                    $DATA['NM_ANGKUT'] = trim($arrdisch['NM_ANGKUT']);
                                else
                                    unset($DATA['NM_ANGKUT']);
                                if ($arrdisch['NO_VOY_FLIGHT'] != "")
                                    $DATA['NO_VOY_FLIGHT'] = trim($arrdisch['NO_VOY_FLIGHT']);
                                else
                                    unset($DATA['NO_VOY_FLIGHT']);
                                if ($arrdisch['TGL_TIBA'] != "")
                                    $DATA['TGL_TIBA'] = trim($arrdisch['TGL_TIBA']);
                                else
                                    unset($DATA['TGL_TIBA']);
                                if ($arrdisch['NO_BC11'] != "")
                                    $DATA['NO_BC11'] = trim($arrdisch['NO_BC11']);
                                else
                                    unset($DATA['NO_BC11']);
                                if ($arrdisch['TGL_BC11'] != "")
                                    $DATA['TGL_BC11'] = trim($arrdisch['TGL_BC11']);
                                else
                                    unset($DATA['TGL_BC11']);
                            }
                            $this->db->where(array('ID' => $id));
                            $this->db->update('t_request_plp_hdr', $DATA);
                            $updateCont = true;
                        }
                    }
                }else {
                    $SQL = "SELECT B.KD_KAPAL, B.NM_ANGKUT, B.NO_VOY_FLIGHT, B.TGL_TIBA, B.NO_BC11, B.TGL_BC11
							FROM t_request_plp_hdr A
							INNER JOIN t_cocostshdr B ON B.ID=A.KD_COCOSTSHDR
							WHERE A.ID = " . $this->db->escape($id);
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                        foreach ($SQL->result_array() as $row => $value) {
                            $arrdisch = $value;
                        }
                        if ($arrdisch['KD_KAPAL'] != "")
                            $DATA['KD_KAPAL'] = trim($arrdisch['KD_KAPAL']);
                        else
                            unset($DATA['KD_KAPAL']);
                        if ($arrdisch['NM_ANGKUT'] != "")
                            $DATA['NM_ANGKUT'] = trim($arrdisch['NM_ANGKUT']);
                        else
                            unset($DATA['NM_ANGKUT']);
                        if ($arrdisch['NO_VOY_FLIGHT'] != "")
                            $DATA['NO_VOY_FLIGHT'] = trim($arrdisch['NO_VOY_FLIGHT']);
                        else
                            unset($DATA['NO_VOY_FLIGHT']);
                        if ($arrdisch['TGL_TIBA'] != "")
                            $DATA['TGL_TIBA'] = trim($arrdisch['TGL_TIBA']);
                        else
                            unset($DATA['TGL_TIBA']);
                        if ($arrdisch['NO_BC11'] != "")
                            $DATA['NO_BC11'] = trim($arrdisch['NO_BC11']);
                        else
                            unset($DATA['NO_BC11']);
                        if ($arrdisch['TGL_BC11'] != "")
                            $DATA['TGL_BC11'] = trim($arrdisch['TGL_BC11']);
                        else
                            unset($DATA['TGL_BC11']);
                    }
                    $this->db->where(array('ID' => $id));
                    $this->db->update('t_request_plp_hdr', $DATA);
                    $updateCont = true;
                }
                if ($updateCont) {
                    $id_cont = $this->input->post('tmpchktblkontainer');
                    //print_r($id_cont);die();
                    $arr_cont = explode("*", $id_cont);
                    $insertCont = true;
                    $arr_cont = array_filter($arr_cont);
                    //print_r($arr_cont);die();
                    if (count($arr_cont) > 0) {
                        for ($a = 0; $a < count($arr_cont); $a++) {
                            $cont = explode("~", $arr_cont[$a]);
                            $SQL_CONT = "SELECT A.ID, A.NO_CONT, A.KD_CONT_UKURAN
                                         FROM t_cocostscont A
                                         WHERE A.ID = " . $this->db->escape($cont[0]) . "
                                         AND A.NO_CONT = " . $this->db->escape($cont[1]);
                            $result_cont = $func->main->get_result($SQL_CONT);
                            if ($result_cont) {
                                foreach ($SQL_CONT->result_array() as $row => $value) {
                                    $arrcont = $value;
                                }
                            } else {
                                //echo "sini";die();
                                $insertCont = false;
                            }
                        }
                    } else {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                    if ($insertCont) {
                        //echo $id;die();
                        $exec = $this->db->delete('t_request_plp_cont', array('ID' => $id));
                        if ($exec) {
                            for ($a = 0; $a < count($arr_cont); $a++) {
                                $cont = explode("~", $arr_cont[$a]);
                                $SQL_CONT = "SELECT ID, NO_CONT, KD_CONT_UKURAN FROM t_cocostscont
                                             WHERE ID = " . $this->db->escape($cont[0]) . "
                                             AND NO_CONT = " . $this->db->escape($cont[1]);
                                $result_cont = $func->main->get_result($SQL_CONT);
                                if ($result_cont) {
                                    foreach ($SQL_CONT->result_array() as $row => $value) {
                                        $arrcont = $value;
                                    }
                                    $arrcont['ID'] = $id;
                                    $arrcont['NO_CONT'] = $arrcont['NO_CONT'];
                                    $arrcont['KD_CONT_UKURAN'] = $arrcont['KD_CONT_UKURAN'];
                                    $this->db->insert('t_request_plp_cont', $arrcont);
                                }
                            }
                        }
                    } else {
                        $error += 1;
                        $message = "Data gagal diproses, periksa data kontainer";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_request_plp_hdr,t_request_plp_cont");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "send_pengajuan_plp") {
                foreach ($this->input->post('tb_chktblrequestdokumen') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[1];
                    $DATA['KD_STATUS'] = '200';
                    $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                    $this->db->where(array('ID' => $ID));
                    $exec = $this->db->update('t_request_plp_hdr', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_request_plp_hdr");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/plp/pengajuan_plp/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "pembatalan_plp") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        unset($DATA[$a]);
                    else
                        $DATA[$a] = strtoupper($b);
                }
                $DATA['TGL_SURAT'] = validate($DATA['TGL_SURAT'], 'DATE');
                $DATA['KD_STATUS'] = '100';
                $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                $updateCont = false;
                $SQL = "SELECT ID FROM t_request_batal_plp_hdr
						WHERE NO_SURAT = " . $this->db->escape(trim($DATA['NO_SURAT'])) . "
						AND TGL_SURAT = " . $this->db->escape(trim($DATA['TGL_SURAT']));
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    if ($arrdata['ID'] == $id) {
                        $this->db->where(array('ID' => $id));
                        $this->db->update('t_request_batal_plp_hdr', $DATA);
                        $updateCont = true;
                    } else {
                        $QUERY = "SELECT ID FROM t_request_batal_plp_hdr
								  WHERE NO_SURAT = " . $this->db->escape(trim($DATA['NO_SURAT'])) . "
								  AND TGL_SURAT = " . $this->db->escape(trim($DATA['TGL_SURAT']));
                        $res = $func->main->get_result($QUERY);
                        if ($res) {
                            $error += 1;
                            $message = "Data gagal diproses, sudah terdapat data pembatalan plp";
                        } else {
                            $this->db->where(array('ID' => $id));
                            $this->db->update('t_request_batal_plp_hdr', $DATA);
                            $updateCont = true;
                        }
                    }
                } else {
                    $this->db->where(array('ID' => $id));
                    $this->db->update('t_request_batal_plp_hdr', $DATA);
                    $updateCont = true;
                }
                if ($updateCont) {
                    $id_cont = $this->input->post('tmpchktblresponplpkontainer');
                    $arr_cont = explode("*", $id_cont);
                    $insertCont = true;
                    $arr_cont = array_filter($arr_cont);
                    if (count($arr_cont) > 0) {
                        for ($a = 0; $a < count($arr_cont); $a++) {
                            $cont = explode("~", $arr_cont[$a]);
                            $SQL_CONT = "SELECT A.ID, A.NO_CONT, A.KD_CONT_UKURAN, A.KD_CONT_JENIS
										 FROM t_respon_plp_asal_cont A
										 WHERE A.ID = " . $this->db->escape($cont[0]) . "
										 AND A.NO_CONT = " . $this->db->escape($cont[1]);
                            $result_cont = $func->main->get_result($SQL_CONT);
                            if ($result_cont) {
                                foreach ($SQL_CONT->result_array() as $row => $value) {
                                    $arrcont = $value;
                                }
                            } else {
                                $insertCont = false;
                            }
                        }
                    } else {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                    if ($insertCont) {
                        $exec = $this->db->delete('t_request_batal_plp_cont', array('ID' => $id));
                        if ($exec) {
                            for ($a = 0; $a < count($arr_cont); $a++) {
                                $cont = explode("~", $arr_cont[$a]);
                                $SQL_CONT = "SELECT ID, NO_CONT, KD_CONT_UKURAN
											 FROM t_respon_plp_asal_cont
											 WHERE ID = " . $this->db->escape($cont[0]) . "
											 AND NO_CONT = " . $this->db->escape($cont[1]);
                                $result_cont = $func->main->get_result($SQL_CONT);
                                if ($result_cont) {
                                    foreach ($SQL_CONT->result_array() as $row => $value) {
                                        $arrcont = $value;
                                    }
                                    $arrcont['ID'] = $id;
                                    $arrcont['NO_CONT'] = $arrcont['NO_CONT'];
                                    $arrcont['KD_CONT_UKURAN'] = $arrcont['KD_CONT_UKURAN'];
                                    $this->db->insert('t_request_batal_plp_cont', $arrcont);
                                }
                            }
                        }
                    } else {
                        $error += 1;
                        $message = "Data gagal diproses, periksa data respons";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_request_batal_plp_hdr,t_request_batal_plp_cont");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "send_pembatalan_plp") {
                foreach ($this->input->post('tb_chktblpembatalan') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[1];
                    $DATA['KD_STATUS'] = '200';
                    $DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
                    $this->db->where(array('ID' => $ID));
                    $exec = $this->db->update('t_request_batal_plp_hdr', $DATA);
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_request_batal_plp_hdr");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/plp/pembatalan_plp/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "create_xml_impor") {
                foreach ($this->input->post('tb_chktblimpor') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $this->db->where(array('ID' => $ID));
                    $exec = $this->db->update('t_permit_cont', array('FL_STATUS' => '100', 'WK_STATUS' => date('Y-m-d H:i:s')));
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_permit_hdr");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/respon/impor_kontainer/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "delete") {
            if ($act == "kontainer") {
                foreach ($this->input->post('tb_chktblkontainer') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $NO_CONT = $arrchk[1];
                    $ACTION = strtolower($arrchk[2]);
                    $result = $this->db->delete('t_cocostscont', array('ID' => $ID, 'NO_CONT' => $NO_CONT));
                }
                if ($result) {
                    $func->main->get_log("delete", "t_cocostscont");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/" . $ACTION . "/post/" . $ID;
                } else {
                    echo "MSG#ERR#Data gagal diproses#";
                }
            } else if ($act == "request_dokumen") {
                foreach ($this->input->post('tb_chktblrequestdokumen') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $ACTION = strtolower($arrchk[1]);
                    $exec = $this->db->delete('t_request_custimp_status', array('ID' => $ID));
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    } else {
                       // $this->db->delete('t_request_custimp_hdr', array('ID' => $ID));
                    }
                }
                if ($error == 0) {
                   // $func->main->get_log("delete", "t_request_custimp_hdr");
                   echo "MSG#OK#Data berhasil diproses#" . site_url() . "/dokumen/ekspor/post";
                   //print_r($arrchk);
                } else {
                    echo "MSG#ERR#Data gagal diproses#";
                }
            } else if ($act == "kemasan") {
                foreach ($this->input->post('tb_chktblkemasan') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $SERI = $arrchk[1];
                    $ACTION = strtolower($arrchk[2]);
                    $result = $this->db->delete('t_cocostskms', array('ID' => $ID, 'SERI' => $SERI));
                }
                if ($result) {
                    $func->main->get_log("delete", "t_cocostskms");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/" . $ACTION . "/post/" . $ID;
                } else {
                    echo "MSG#ERR#Data gagal diproses#";
                }
            } else if ($act == "request_dokumen") {
                foreach ($this->input->post('tb_chktblrequestdokumen') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $ACTION = strtolower($arrchk[1]);
                    $exec = $this->db->delete('t_request_custimp_status', array('ID' => $ID));
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    } else {
                        $this->db->delete('t_request_custimp_hdr', array('ID' => $ID));
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "t_request_custimp_hdr");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/" . $ACTION . "/post";
                } else {
                    echo "MSG#ERR#Data gagal diproses#";
                }
            } else if ($act == "pengajuan_plp") {
                foreach ($this->input->post('tb_chktblrequestdokumen') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[1];
                    $exec = $this->db->delete('t_request_plp_cont', array('ID' => $ID));
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    } else {
                        $this->db->delete('t_request_plp_status', array('ID' => $ID));
                        $this->db->delete('t_request_plp_hdr', array('ID' => $ID));
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "t_request_plp_hdr,t_request_plp_cont,t_request_plp_status");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/plp/pengajuan_plp/post";
                } else {
                    echo "MSG#ERR#Data gagal diproses#";
                }
            } else if ($act == "pembatalan_plp") {
                foreach ($this->input->post('tb_chktblpembatalan') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[1];
                    $exec = $this->db->delete('t_request_batal_plp_cont', array('ID' => $ID));
                    if (!$exec) {
                        $error += 1;
                        $message = "Data gagal diproses";
                    } else {
                        $this->db->delete('t_request_batal_plp_status', array('ID' => $ID));
                        $this->db->delete('t_request_batal_plp_hdr', array('ID' => $ID));
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "t_request_batal_plp_hdr,t_request_batal_plp_cont,t_request_batal_plp_status");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/plp/pembatalan_plp/post";
                } else {
                    echo "MSG#ERR#Data gagal diproses#";
                }
            }
        } else if ($type == "read") {
            if ($act == "coarri") {
                $array_return = array();
                $nama = $_FILES['files']['name'];
                $type = $_FILES['files']['type'];
                $tmp = $_FILES['files']['tmp_name'];
                $size = $_FILES['files']['size'];
                $type = pathinfo($nama, PATHINFO_EXTENSION);
                if ($type != "xls") {
                    $message = "Data gagal diproses, periksa file type";
                } else {
                    switch ($id) {
                        case "discharge" : $kode_dok = 1;
                            break;
                        case "loading" : $kode_dok = 2;
                            break;
                        default : $kode_dok = 0;
                            break;
                    }
                    fopen($tmp, 'r');
                    $this->load->library('excel_reader');
                    $this->excel_reader->setOutputEncoding('CP1251');
                    $this->excel_reader->read($tmp);
                    $arr_excel = $this->excel_reader->sheets[0];
                    $arr_data = array();
                    $rows_start = 2;
                    $rows_last = count($arr_excel['cells']);
                    $cols_start = 1;
                    $cols_last = 44;
                    //$array_isocode = $func->main->get_array("SELECT ID FROM reff_cont_isocode","ID");
                    $array_kpbc = $func->main->get_array("SELECT ID FROM reff_kpbc", "ID");
                    $array_dok_imp = $func->main->get_array("SELECT ID FROM reff_kode_dok_bc WHERE KD_PERMIT='IMP'", "ID");
                    $array_dok_exp = $func->main->get_array("SELECT ID FROM reff_kode_dok_bc WHERE KD_PERMIT='EXP'", "ID");
                    $array_loading = $func->main->get_array("SELECT TRIM(A.NO_CONT) AS NO_CONT FROM t_cocostscont A
															 INNER JOIN t_cocostshdr B ON B.ID=A.ID
															 WHERE B.KD_ASAL_BRG='3' AND A.WK_IN IS NOT NULL AND WK_OUT IS NULL", "NO_CONT");
                    for ($i = $rows_start; $i <= $rows_last; $i++) {
                        $array_val_cont[] = $arr_excel['cells'][$i]['11'];
                        for ($c = $cols_start; $c <= $cols_last; $c++) {
                            $arr_temp = $arr_excel['cells'][$i][$c];
                            $class = "";
                            $title = "";
                            if ($c == "1") {
                                if ($arr_temp != $kode_dok) {
                                    $class = "error_table";
                                    $title = "KODE DOKUMEN TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($id == "discharge") {
                                $array_mandatory = array('3', '4', '5', '6', '7');
                            } else if ($id == "loading") {
                                $array_mandatory = array('4', '5', '6', '11', '29', '35', '37');
                            }
                            if (in_array($c, $array_mandatory)) {
                                if (!$arr_temp) {
                                    $class = "error_table";
                                    $title = "TERDAPAT DATA YANG MANDATORY";
                                    $error++;
                                }
                            }
                            $array_port = array('8', '10');
                            if (in_array($c, $array_port)) {
                                if (strlen($arr_temp) != "5") {
                                    $class = "error_table";
                                    $title = "KODE PELABUHAN MANDATORY 5 DIGIT";
                                    $error++;
                                }
                            }
                            if ($c == "9") {
                                if ($arr_temp != "") {
                                    if (strlen($arr_temp) != "5") {
                                        $class = "error_table";
                                        $title = "KODE PELABUHAN MANDATORY 5 DIGIT";
                                        $error++;
                                    }
                                }
                            }
                            if ($c == "11") {
                                if (count(array_unique($array_val_cont)) < count($array_val_cont)) {
                                    $class = "error_table";
                                    $title = "TERDAPAT DATA YANG SAMA";
                                    $error++;
                                }
                                if (strlen($arr_temp) != "11") {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                                switch ($id) {
                                    case "loading" :
                                        if (!in_array($arr_temp, $array_loading)) {
                                            $class = "error_table";
                                            $title = "DATA TIDAK DITEMUKAN";
                                            $error++;
                                        }
                                        break;
                                }
                            }
                            if ($c == "12") {
                                if (!in_array($arr_temp, array('20', '40', '45'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "13") {
                                if (!in_array($arr_temp, array('F', 'L'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "14") {
                                if (!in_array($arr_temp, array('FCL', 'LCL', 'MTY'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "15") {
                                if (!in_array($arr_temp, array('DRY', 'FLT', 'HQ', 'OT', 'RFR'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "17") {
                                if (!in_array($arr_temp, array('BAIK', 'RUSAK'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "23") {
                                if ($arr_temp != "") {
                                    if (strlen($arr_temp) != "15") {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                }
                            }
                            /* if($c=="28"){
                              if(!in_array($arr_temp,$array_isocode)){
                              $class = "error_table";
                              $title = "FORMAT DATA TIDAK SESUAI";
                              $error++;
                              }
                              } */
                            if ($c == "33") {
                                if ($arr_temp != "") {
                                    if (!in_array($arr_temp, array('1', '2', '3', '4'))) {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                }
                            }
                            if ($c == "35") {
                                if (!in_array($arr_temp, array('1', '2'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "37") {
                                if ($arr_temp != "") {
                                    if (!in_array($arr_temp, $array_kpbc)) {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                    if (strlen($arr_temp) != "6") {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                }
                            }
                            $arrayData[$i][$c] = array('align' => $align, 'content' => $arr_excel['cells'][$i][$c], 'class' => $class, 'title' => $title);
                        }
                    }
                    if (($error == 0) && count($arrayData) > 0) {
                        $html .= '<div style="text-align:right" style="border:1px #000 solid">';
                        $html .= '<button type="button" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light waves-effect waves-light" onclick="save_ajax(\'form_data\');" style="position:fixed; margin:0 0 0 -7em">
									<i class="icon md-check"></i> SAVE
								  </button>';
                        $html .= '</div>';
                        $html .= '<BR><BR>';
                    } else {
                        $html .= '<div role="alert" class="alert alert-alt alert-danger alert-dismissible">
								  	<button aria-label="Close" data-dismiss="alert" class="close" type="button">
										<span aria-hidden="true">×</span>
									</button>
									<a href="javascript:void(0)" class="alert-link">
										<i class="icon md-alert-circle-o" aria-hidden="true"></i>&nbsp;
										MOHON PERIKSA KEMBALI ELEMENT DATA PADA EXCEL
									</a>
								  </div>';
                        /* for ($a=$rows_start; $a<=$rows_last; $a++){
                          for ($b=$cols_start; $b<$cols_last; $b++){
                          $arrtemp[] = $arrayData[$a][$b]['title'];
                          }
                          }
                          $arrdata = array_unique($arrtemp);
                          if(count($arrdata) > 0){
                          for($a=0; $a<count($arrdata); $a++){
                          $html .= '<div class="col-sm-12">
                          <div class="alert dark alert-danger alert-dismissible" role="alert">
                          <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                          <span aria-hidden="true">×</span>
                          </button>
                          MOHON PERIKSA KEMBALI ELEMENT DATA PADA EXCEL
                          </div>
                          </div>';
                          }
                          } */
                    }
                    $html .= '<div class="col-sm-12"><div class="table-responsive">';
                    $html .= "<table class=\"table table-striped table-bordered\">";
                    $count = ($rows_last - $rows_start);
                    if (count($count) > 0) {
                        $html .= '<thead>
									<tr>
										<th><b>NO</b></th>
										<th style="min-width:100px"><b>DOKUMEN</b></th>
										<th style="min-width:150px"><b>NAMA ANGKUT</b></th>
										<th style="min-width:100px"><b>CALL SIGN</b></th>
										<th style="min-width:100px"><b>VOYAGE/FLIGHT</b></th>
										<th style="min-width:100px"><b>TGL. TIBA</b></th>
										<th style="min-width:100px"><b>NO. BC11</b></th>
										<th style="min-width:100px"><b>TGL. BC11</b></th>
										<th style="min-width:150px"><b>PELABUHAN MUAT</b></th>
										<th style="min-width:150px"><b>PELABUHAN TRANSIT</b></th>
										<th style="min-width:150px"><b>PELABUHAN BONGKAR</b></th>
										<th style="min-width:150px"><b>NO. KONTAINER</b></th>
										<th style="min-width:100px"><b>UKURAN</b></th>
										<th style="min-width:150px"><b>JENIS KONTAINER</b></th>
										<th style="min-width:180px"><b>STATUS KONTAINER IN/OUT</b></th>
										<th style="min-width:150px"><b>TIPE KONTAINER</b></th>
										<th style="min-width:100px"><b>TEMPERATURE</b></th>
										<th style="min-width:150px"><b>KONDISI SEGEL</b></th>
										<th style="min-width:100px"><b>NO. SEGEL</b></th>
										<th style="min-width:100px"><b>NO. BL/AWB</b></th>
										<th style="min-width:100px"><b>TGL. BL/AWB</b></th>
										<th style="min-width:150px"><b>NO. MASTER BL/AWB</b></th>
										<th style="min-width:150px"><b>TGL. MASTER BL/AWB</b></th>
										<th style="min-width:150px"><b>NPWP CONSIGNEE</b></th>
										<th style="min-width:100px"><b>CONSIGNEE</b></th>
										<th style="min-width:100px"><b>BRUTO</b></th>
										<th style="min-width:100px"><b>NO. POS BC11</b></th>
										<th style="min-width:150px"><b>LOKASI TIMBUN</b></th>
										<th style="min-width:100px"><b>ISO CODE</b></th>
										<th style="min-width:150px"><b>WAKTU IN/OUT</b></th>
										<th style="min-width:160px"><b>KODE DOKUMEN IN/OUT</b></th>
										<th style="min-width:160px"><b>NO. DOKUMEN IN/OUT</b></th>
										<th style="min-width:160px"><b>TGL. DOKUMEN IN/OUT</b></th>
										<th style="min-width:200px"><b>KODE SARANA ANGKUT IN/OUT</b></th>
										<th style="min-width:160px"><b>NO. POLISI IN/OUT</b></th>
										<th style="min-width:160px"><b>FL KONTAINER KOSONG</b></th>
										<th style="min-width:150px"><b>GUDANG TUJUAN</b></th>
										<th style="min-width:150px"><b>KODE KANTOR PABEAN</b></th>
										<th style="min-width:150px"><b>NO. DAFTAR PABEAN</b></th>
										<th style="min-width:150px"><b>TGL. DAFTAR PABEAN</b></th>
										<th style="min-width:100px"><b>NO. SEGEL BC</b></th>
										<th style="min-width:100px"><b>TGL. SEGEL BC</b></th>
										<th style="min-width:100px"><b>NO. IJIN TPS</b></th>
										<th style="min-width:100px"><b>TGL. IJIN TPS</b></th>
									</tr>
								  </thead>';
                        $nomor = 1;
                        for ($a = $rows_start; $a <= $rows_last; $a++) {
                            $html .= '<tbody>';
                            $html .= '<tr id="index_' . $nomor . '">';
                            $html .= '<td align="center" valign="top">' . $nomor . '</td>';
                            for ($b = $cols_start; $b < $cols_last; $b++) {
                                $html .= '<td align="' . $array_align[$b] . '" valign="top" class="' . $arrayData[$a][$b]['class'] . '" title="' . $arrayData[$a][$b]['title'] . '">' . $arrayData[$a][$b]['content'] . '</td>';
                            }
                            $html .= '</tr>';
                            $html .= '</tbody>';
                            $nomor++;
                        }
                    }
                    $html .= "</table>";
                    $html .= '</div></div>';
                    fclose($fp);
                }
                $array_return['html'] = $html;
                $array_return['error'] = $error;
                $array_return['message'] = $message;
                echo json_encode($array_return);
            } else if ($act == "codeco") {
                $array_return = array();
                $nama = $_FILES['files']['name'];
                $type = $_FILES['files']['type'];
                $tmp = $_FILES['files']['tmp_name'];
                $size = $_FILES['files']['size'];
                $type = pathinfo($nama, PATHINFO_EXTENSION);
                if ($type != "xls") {
                    $message = "Data gagal diproses, periksa file type";
                } else {
                    switch ($id) {
                        case "gatein" : $kode_dok = 4;
                            $dok = "GATE IN";
                            break;
                        case "gateout" : $kode_dok = 3;
                            $dok = "GATE OUT";
                            break;
                        default : $kode_dok = 0;
                            $dok = "";
                            break;
                    }
                    fopen($tmp, 'r');
                    $this->load->library('excel_reader');
                    $this->excel_reader->setOutputEncoding('CP1251');
                    $this->excel_reader->read($tmp);
                    $arr_excel = $this->excel_reader->sheets[0];
                    $arr_data = array();
                    $rows_start = 2;
                    $rows_last = count($arr_excel['cells']);
                    $cols_start = 1;
                    $cols_last = 44;
                    //$array_isocode = $func->main->get_array("SELECT ID FROM reff_cont_isocode","ID");
                    $array_kpbc = $func->main->get_array("SELECT ID FROM reff_kpbc", "ID");
                    $array_dok_imp = $func->main->get_array("SELECT ID FROM reff_kode_dok_bc WHERE KD_PERMIT='IMP'", "ID");
                    $array_dok_exp = $func->main->get_array("SELECT ID FROM reff_kode_dok_bc WHERE KD_PERMIT='EXP'", "ID");
                    $array_discharge = $func->main->get_array("SELECT TRIM(A.NO_CONT) AS NO_CONT FROM t_cocostscont A
															   INNER JOIN t_cocostshdr B ON B.ID=A.ID
															   WHERE B.KD_ASAL_BRG='1' AND A.WK_IN IS NOT NULL AND WK_OUT IS NULL", "NO_CONT");
                    for ($i = $rows_start; $i <= $rows_last; $i++) {
                        $array_val_cont[] = $arr_excel['cells'][$i]['11'];
                        for ($c = $cols_start; $c <= $cols_last; $c++) {
                            $arr_temp = $arr_excel['cells'][$i][$c];
                            $class = "";
                            $title = "";
                            $check_column = false;
                            if ($c == "1") {
                                if ($arr_temp != $kode_dok) {
                                    $class = "error_table";
                                    $title = "KODE DOKUMEN TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            $array_mandatory = array('4', '5', '6', '11', '19', '29', '30', '31', '32', '33', '34', '35', '37', '42', '43');
                            if (in_array($c, $array_mandatory)) {
                                if (!$arr_temp) {
                                    $class = "error_table";
                                    $title = "TERDAPAT DATA YANG MANDATORY";
                                    $error++;
                                }
                            }
                            $array_port = array('8', '10');
                            if (in_array($c, $array_port)) {
                                if (strlen($arr_temp) != "5") {
                                    $class = "error_table";
                                    $title = "KODE PELABUHAN MANDATORY 5 DIGIT";
                                    $error++;
                                }
                            }
                            if ($c == "9") {
                                if ($arr_temp != "") {
                                    if (strlen($arr_temp) != "5") {
                                        $class = "error_table";
                                        $title = "KODE PELABUHAN MANDATORY 5 DIGIT";
                                        $error++;
                                    }
                                }
                            }
                            if ($c == "11") {
                                if (count(array_unique($array_val_cont)) < count($array_val_cont)) {
                                    $class = "error_table";
                                    $title = "TERDAPAT DATA YANG SAMA";
                                    $error++;
                                }
                                if (strlen($arr_temp) != "11") {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                                switch ($id) {
                                    case "gateout" :
                                        if (!in_array($arr_temp, $array_discharge)) {
                                            $class = "error_table";
                                            $title = "DATA TIDAK DITEMUKAN";
                                            $error++;
                                        }
                                        break;
                                }
                            }
                            if ($c == "12") {
                                if (!in_array($arr_temp, array('20', '40', '45'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "13") {
                                if (!in_array($arr_temp, array('F', 'L'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "14") {
                                if (!in_array($arr_temp, array('FCL', 'LCL', 'MTY'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "15") {
                                if (!in_array($arr_temp, array('DRY', 'FLT', 'HQ', 'OT', 'RFR'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "17") {
                                if (!in_array($arr_temp, array('BAIK', 'RUSAK'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "23") {
                                if ($arr_temp != "") {
                                    if (strlen($arr_temp) != "15") {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                }
                            }
                            /* if($c=="28"){
                              if(!in_array($arr_temp,$array_isocode)){
                              $class = "error_table";
                              $title = "FORMAT DATA TIDAK SESUAI";
                              $error++;
                              }
                              } */
                            if ($c == "30") {
                                if ($kode_dok == 4) {
                                    if (!in_array($arr_temp, $array_dok_exp)) {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                }
                                if ($kode_dok == 3) {
                                    if (!in_array($arr_temp, $array_dok_imp)) {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                }
                            }
                            if ($c == "33") {
                                if ($arr_temp != "") {
                                    if (!in_array($arr_temp, array('1', '2', '3', '4'))) {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                }
                            }
                            if ($c == "35") {
                                if (!in_array($arr_temp, array('1', '2'))) {
                                    $class = "error_table";
                                    $title = "FORMAT DATA TIDAK SESUAI";
                                    $error++;
                                }
                            }
                            if ($c == "37") {
                                if ($arr_temp != "") {
                                    if (!in_array($arr_temp, $array_kpbc)) {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                    if (strlen($arr_temp) != "6") {
                                        $class = "error_table";
                                        $title = "FORMAT DATA TIDAK SESUAI";
                                        $error++;
                                    }
                                }
                            }
                            $arrayData[$i][$c] = array('align' => $align, 'content' => $arr_excel['cells'][$i][$c], 'class' => $class, 'title' => $title);
                        }
                    }
                    if (($error == 0) && count($arrayData) > 0) {
                        $html .= '<div style="text-align:right" style="border:1px #000 solid">';
                        $html .= '<button type="button" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light waves-effect waves-light" onclick="save_ajax(\'form_data\');" style="position:fixed; margin:0 0 0 -7em">
									<i class="icon md-check"></i> SAVE
								  </button>';
                        $html .= '</div>';
                        $html .= '<BR><BR>';
                    } else {
                        $html .= '<div role="alert" class="alert alert-alt alert-danger alert-dismissible">
								  	<button aria-label="Close" data-dismiss="alert" class="close" type="button">
										<span aria-hidden="true">×</span>
									</button>
									<a href="javascript:void(0)" class="alert-link">
										<i class="icon md-alert-circle-o" aria-hidden="true"></i>&nbsp;
										MOHON PERIKSA KEMBALI ELEMENT DATA PADA EXCEL
									</a>
								  </div>';
                    }
                    $html .= '<div class="table-responsive">';
                    $html .= "<table class=\"table table-striped table-bordered\">";
                    $count = ($rows_last - $rows_start);
                    if (count($count) > 0) {
                        $html .= '<thead>
									<tr>
										<th><b>NO</b></th>
										<th style="min-width:100px"><b>DOKUMEN</b></th>
										<th style="min-width:150px"><b>NAMA ANGKUT</b></th>
										<th style="min-width:100px"><b>CALL SIGN</b></th>
										<th style="min-width:100px"><b>VOYAGE/FLIGHT</b></th>
										<th style="min-width:100px"><b>TGL. TIBA</b></th>
										<th style="min-width:100px"><b>NO. BC11</b></th>
										<th style="min-width:100px"><b>TGL. BC11</b></th>
										<th style="min-width:150px"><b>PELABUHAN MUAT</b></th>
										<th style="min-width:150px"><b>PELABUHAN TRANSIT</b></th>
										<th style="min-width:150px"><b>PELABUHAN BONGKAR</b></th>
										<th style="min-width:150px"><b>NO. KONTAINER</b></th>
										<th style="min-width:100px"><b>UKURAN</b></th>
										<th style="min-width:150px"><b>JENIS KONTAINER</b></th>
										<th style="min-width:180px"><b>STATUS KONTAINER IN/OUT</b></th>
										<th style="min-width:150px"><b>TIPE KONTAINER</b></th>
										<th style="min-width:100px"><b>TEMPERATURE</b></th>
										<th style="min-width:150px"><b>KONDISI SEGEL</b></th>
										<th style="min-width:100px"><b>NO. SEGEL</b></th>
										<th style="min-width:100px"><b>NO. BL/AWB</b></th>
										<th style="min-width:100px"><b>TGL. BL/AWB</b></th>
										<th style="min-width:150px"><b>NO. MASTER BL/AWB</b></th>
										<th style="min-width:150px"><b>TGL. MASTER BL/AWB</b></th>
										<th style="min-width:150px"><b>NPWP CONSIGNEE</b></th>
										<th style="min-width:100px"><b>CONSIGNEE</b></th>
										<th style="min-width:100px"><b>BRUTO</b></th>
										<th style="min-width:100px"><b>NO. POS BC11</b></th>
										<th style="min-width:150px"><b>LOKASI TIMBUN</b></th>
										<th style="min-width:100px"><b>ISO CODE</b></th>
										<th style="min-width:150px"><b>WAKTU IN/OUT</b></th>
										<th style="min-width:160px"><b>KODE DOKUMEN IN/OUT</b></th>
										<th style="min-width:160px"><b>NO. DOKUMEN IN/OUT</b></th>
										<th style="min-width:160px"><b>TGL. DOKUMEN IN/OUT</b></th>
										<th style="min-width:200px"><b>KODE SARANA ANGKUT IN/OUT</b></th>
										<th style="min-width:160px"><b>NO. POLISI IN/OUT</b></th>
										<th style="min-width:160px"><b>FL KONTAINER KOSONG</b></th>
										<th style="min-width:150px"><b>GUDANG TUJUAN</b></th>
										<th style="min-width:150px"><b>KODE KANTOR PABEAN</b></th>
										<th style="min-width:150px"><b>NO. DAFTAR PABEAN</b></th>
										<th style="min-width:150px"><b>TGL. DAFTAR PABEAN</b></th>
										<th style="min-width:100px"><b>NO. SEGEL BC</b></th>
										<th style="min-width:100px"><b>TGL. SEGEL BC</b></th>
										<th style="min-width:100px"><b>NO. IJIN TPS</b></th>
										<th style="min-width:100px"><b>TGL. IJIN TPS</b></th>
									</tr>
								  </thead>';
                        $nomor = 1;
                        for ($a = $rows_start; $a <= $rows_last; $a++) {
                            $html .= '<tbody>';
                            $html .= '<tr id="index_' . $nomor . '">';
                            $html .= '<td align="center" valign="top">' . $nomor . '</td>';
                            for ($b = $cols_start; $b < $cols_last; $b++) {
                                $html .= '<td align="' . $array_align[$b] . '" valign="top" class="' . $arrayData[$a][$b]['class'] . '" title="' . $arrayData[$a][$b]['title'] . '">' . $arrayData[$a][$b]['content'] . '</td>';
                            }
                            $html .= '</tr>';
                            $html .= '</tbody>';
                            $nomor++;
                        }
                    }
                    $html .= "</table>";
                    $html .= '</div>';
                    fclose($fp);
                }
                $array_return['html'] = $html;
                $array_return['error'] = $error;
                $array_return['message'] = $message;
                echo json_encode($array_return);
            }
        } else if ($type == "upload") {
            if ($act == "coarri") {
                $array_return = array();
                $nama = $_FILES['files']['name'];
                $type = $_FILES['files']['type'];
                $tmp = $_FILES['files']['tmp_name'];
                $size = $_FILES['files']['size'];
                $type = pathinfo($nama, PATHINFO_EXTENSION);
                if ($type != "xls") {
                    $message = "Data gagal diproses, periksa file type";
                } else {
                    if ($id == "discharge") {
                        fopen($tmp, 'r');
                        $this->load->library('excel_reader');
                        $this->excel_reader->setOutputEncoding('CP1251');
                        $this->excel_reader->read($tmp);
                        $arr_excel = $this->excel_reader->sheets[0];
                        $arr_data = array();
                        $rows_start = 2;
                        $rows_last = count($arr_excel['cells']);
                        $cols_start = 2;
                        $cols_last = 44;
                        $insert = true;
                        for ($i = $rows_start; $i <= $rows_last; $i++) {
                            $SQL = "SELECT A.ID FROM t_cocostshdr A
									LEFT JOIN t_cocostscont B ON B.ID=A.ID
									WHERE A.KD_ASAL_BRG = '1'
									AND A.NO_BC11 = " . $this->db->escape(trim($arr_excel['cells'][$i][6])) . "
									AND A.NO_VOY_FLIGHT = " . $this->db->escape(trim($arr_excel['cells'][$i][4])) . "
									AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = " . $this->db->escape(trim($arr_excel['cells'][$i][5])) . "
									AND LEFT(B.NO_CONT,11) = " . $this->db->escape(trim($arr_excel['cells'][$i][11]));
                            $result = $func->main->get_result($SQL);
                            if ($result) {
                                $insert = false;
                                $message = "Data gagal diproses, sudah terdapat data";
                                $error++;
                            } else {
                                for ($c = $cols_start; $c <= $cols_last; $c++) {
                                    if ($arr_excel['cells'][$i]['1'] != "")
                                        $arrayData[$i][$c] = $arr_excel['cells'][$i][$c];
                                }
                            }
                        }
                        if ($insert) {
                            if (count($arrayData) > 0) {
                                for ($a = $rows_start; $a <= $rows_last; $a++) {
                                    $SQL = "SELECT A.ID FROM t_cocostshdr A WHERE A.KD_ASAL_BRG = '1'
											AND A.NO_BC11 = " . $this->db->escape(trim($arr_excel['cells'][$a][6])) . "
											AND A.NO_VOY_FLIGHT = " . $this->db->escape(trim($arr_excel['cells'][$a][4])) . "
											AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = " . $this->db->escape(trim($arr_excel['cells'][$a][5])) . "
											ORDER BY A.ID DESC LIMIT 1";
                                    $result = $func->main->get_result($SQL);
                                    if ($result) {
                                        foreach ($SQL->result_array() as $row => $value) {
                                            $arrdata = $value;
                                        }
                                        $HEADER_ID = $arrdata['ID'];
                                        $data = array('KD_KAPAL' => $this->get_referensi('kapal', $arrayData[$a][3], $arrayData[$a][2]),
                                            'NM_ANGKUT' => validate($arrayData[$a][2]),
                                            'WK_REKAM' => date('Y-m-d H:i:s'));
                                        $this->db->where(array('ID' => $HEADER_ID));
                                        $this->db->update('t_cocostshdr', $data);
                                    } else {
                                        $data = array('KD_ASAL_BRG' => '1',
                                            'KD_TPS' => $KD_TPS,
                                            'KD_GUDANG' => $KD_GUDANG,
                                            'KD_KAPAL' => $this->get_referensi('kapal', $arrayData[$a][3], $arrayData[$a][2]),
                                            'NM_ANGKUT' => validate($arrayData[$a][2]),
                                            'NO_VOY_FLIGHT' => validate($arrayData[$a][4]),
                                            'TGL_TIBA' => validate($arrayData[$a][5], 'DATE-S'),
                                            'NO_BC11' => validate($arrayData[$a][6]),
                                            'TGL_BC11' => validate($arrayData[$a][7], 'DATE-S'),
                                            'KD_PEL_MUAT' => $this->get_referensi('port', $arrayData[$a][8]),
                                            'KD_PEL_TRANSIT' => $this->get_referensi('port', $arrayData[$a][9]),
                                            'KD_PEL_BONGKAR' => $this->get_referensi('port', $arrayData[$a][10]),
                                            'WK_REKAM' => date('Y-m-d H:i:s'));
                                        $this->db->insert('t_cocostshdr', $data);
                                        $HEADER_ID = $this->db->insert_id();
                                    }
                                    if ($HEADER_ID != 0 || $HEADER_ID != "") {
                                        $dtl = array('ID' => $HEADER_ID,
                                            'NO_CONT' => validate($arrayData[$a][11]),
                                            'KD_CONT_UKURAN' => $this->get_referensi('cont_ukuran', $arrayData[$a][12]),
                                            'KD_CONT_JENIS' => $this->get_referensi('cont_jenis', $arrayData[$a][13]),
                                            'KD_CONT_STATUS_IN' => $this->get_referensi('cont_status', $arrayData[$a][14]),
                                            'KD_CONT_TIPE' => $this->get_referensi('cont_tipe', $arrayData[$a][15]),
                                            'TEMPERATURE' => validate($arrayData[$a][16]),
                                            'KONDISI_SEGEL' => validate($arrayData[$a][17]),
                                            'NO_SEGEL' => validate($arrayData[$a][18]),
                                            'NO_BL_AWB' => validate($arrayData[$a][19]),
                                            'TGL_BL_AWB' => validate($arrayData[$a][20], 'DATE-S'),
                                            'NO_MASTER_BL_AWB' => validate($arrayData[$a][21]),
                                            'TGL_MASTER_BL_AWB' => validate($arrayData[$a][22], 'DATE-S'),
                                            'KD_ORG_CONSIGNEE' => $this->get_referensi('cons', $arrayData[$a][23], $arrayData[$a][24]),
                                            'BRUTO' => validate($arrayData[$a][25]),
                                            'NO_POS_BC11' => validate($arrayData[$a][26]),
                                            'KD_TIMBUN' => validate($arrayData[$a][27]),
                                            'KD_ISO_CODE' => validate($arrayData[$a][28]),
                                            'WK_IN' => validate($arrayData[$a][29], 'DATE-S'),
                                            'KD_DOK_IN' => validate($arrayData[$a][30]),
                                            'NO_DOK_IN' => validate($arrayData[$a][31]),
                                            'TGL_DOK_IN' => validate($arrayData[$a][32], 'DATE-S'),
                                            'KD_PEL_MUAT' => $this->get_referensi('port', $arrayData[$a][8]),
                                            'KD_PEL_TRANSIT' => $this->get_referensi('port', $arrayData[$a][9]),
                                            'KD_PEL_BONGKAR' => $this->get_referensi('port', $arrayData[$a][10]),
                                            'KD_SARANA_ANGKUT_IN' => validate($arrayData[$a][33]),
                                            'NO_POL_IN' => validate($arrayData[$a][34]),
                                            'FL_CONT_KOSONG' => validate($arrayData[$a][35]),
                                            'KD_GUDANG_TUJUAN' => validate($arrayData[$a][36]),
                                            'KD_KANTOR_PABEAN' => validate($arrayData[$a][37]),
                                            'NO_DAFTAR_PABEAN' => validate($arrayData[$a][38]),
                                            'TGL_DAFTAR_PABEAN' => validate($arrayData[$a][39], 'DATE-S'),
                                            'NO_SEGEL_BC' => validate($arrayData[$a][40]),
                                            'TGL_SEGEL_BC' => validate($arrayData[$a][41], 'DATE-S'),
                                            'NO_IJIN_TPS' => validate($arrayData[$a][42]),
                                            'TGL_IJIN_TPS' => validate($arrayData[$a][43], 'DATE-S'),
                                            'WK_REKAM' => date('Y-m-d H:i:s'));
                                        $this->db->insert('t_cocostscont', $dtl);
                                    } else {
                                        $message = "Data gagal diproses";
                                        $error++;
                                    }
                                }
                            } else {
                                $message = "Data gagal diproses, sudah terdapat data";
                                $error++;
                            }
                        }
                        if ($error == 0) {
                            $func->main->get_log("add", "t_cocostshdr, t_cocostscont");
                            echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                        } else {
                            echo "MSG#ERR#" . $message . "#";
                        }
                    } else if ($id == "loading") {
                        fopen($tmp, 'r');
                        $this->load->library('excel_reader');
                        $this->excel_reader->setOutputEncoding('CP1251');
                        $this->excel_reader->read($tmp);
                        $arr_excel = $this->excel_reader->sheets[0];
                        $arr_data = array();
                        $rows_start = 2;
                        $rows_last = count($arr_excel['cells']);
                        $cols_start = 2;
                        $cols_last = 44;
                        for ($i = $rows_start; $i <= $rows_last; $i++) {
                            $SQL = "SELECT A.ID FROM t_cocostshdr A
									LEFT JOIN t_cocostscont B ON B.ID=A.ID
									WHERE A.KD_ASAL_BRG = '3'
									AND A.NO_BC11 = " . $this->db->escape(trim($arr_excel['cells'][$i][6])) . "
									AND A.NO_VOY_FLIGHT = " . $this->db->escape(trim($arr_excel['cells'][$i][4])) . "
									AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = " . $this->db->escape(trim($arr_excel['cells'][$i][5])) . "
									AND B.NO_CONT = " . $this->db->escape(trim($arr_excel['cells'][$i][11]));
                            $result = $func->main->get_result($SQL);
                            if ($result) {
                                for ($c = $cols_start; $c <= $cols_last; $c++) {
                                    if ($arr_excel['cells'][$i]['1'] != "")
                                        $arrayData[$i][$c] = $arr_excel['cells'][$i][$c];
                                }
                            }else {
                                $message = "Data gagal diproses, data tidak ditemukan";
                                $error++;
                            }
                        }
                        if ($error == 0 && count($arrayData) > 0) {
                            for ($a = $rows_start; $a <= $rows_last; $a++) {
                                $SQL = "SELECT A.ID, B.NO_CONT FROM t_cocostshdr A
										LEFT JOIN t_cocostscont B ON B.ID=A.ID
										WHERE A.KD_ASAL_BRG = '3'
										AND A.NO_BC11 = " . $this->db->escape(trim($arr_excel['cells'][$a][6])) . "
										AND A.NO_VOY_FLIGHT = " . $this->db->escape(trim($arr_excel['cells'][$a][4])) . "
										AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = " . $this->db->escape(trim($arr_excel['cells'][$a][5])) . "
										AND B.NO_CONT = " . $this->db->escape(trim($arr_excel['cells'][$a][11]));
                                $result = $func->main->get_result($SQL);
                                if ($result) {
                                    foreach ($SQL->result_array() as $row => $value) {
                                        $ID = $value['ID'];
                                        $NO_CONT = $value['NO_CONT'];
                                    }
                                    $dtl = array('KD_CONT_STATUS_OUT' => $this->get_referensi('cont_status', $arrayData[$a][14]),
                                        'WK_OUT' => validate($arrayData[$a][29], 'DATE-S'),
                                        'KD_DOK_OUT' => validate($arrayData[$a][30]),
                                        'NO_DOK_OUT' => validate($arrayData[$a][31]),
                                        'TGL_DOK_OUT' => validate($arrayData[$a][32], 'DATE-S'),
                                        'KD_SARANA_ANGKUT_OUT' => validate($arrayData[$a][33]),
                                        'NO_POL_OUT' => validate($arrayData[$a][34]),
                                        'FL_CONT_KOSONG' => validate($arrayData[$a][35]),
                                        'KD_GUDANG_TUJUAN' => validate($arrayData[$a][36]),
                                        'KD_KANTOR_PABEAN' => validate($arrayData[$a][37]),
                                        'NO_DAFTAR_PABEAN' => validate($arrayData[$a][38]),
                                        'TGL_DAFTAR_PABEAN' => validate($arrayData[$a][39], 'DATE-S'),
                                        'NO_SEGEL_BC' => validate($arrayData[$a][40]),
                                        'TGL_SEGEL_BC' => validate($arrayData[$a][41], 'DATE-S'),
                                        'NO_IJIN_TPS' => validate($arrayData[$a][42]),
                                        'TGL_IJIN_TPS' => validate($arrayData[$a][43], 'DATE-S'),
                                        'WK_REKAM' => date('Y-m-d H:i:s'));
                                    $this->db->where(array('ID' => $ID, 'NO_CONT' => $NO_CONT));
                                    $this->db->update('t_cocostscont', $dtl);
                                } else {
                                    $message = "Data gagal diproses, data tidak ditemukan";
                                    $error++;
                                }
                            }
                        } else {
                            $message = "Data gagal diproses";
                            $error++;
                        }
                        if ($error == 0) {
                            $func->main->get_log("update", "t_cocostscont");
                            echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                        } else {
                            echo "MSG#ERR#" . $message . "#";
                        }
                    }
                }
            } else if ($act == "codeco") {
                $array_return = array();
                $nama = $_FILES['files']['name'];
                $type = $_FILES['files']['type'];
                $tmp = $_FILES['files']['tmp_name'];
                $size = $_FILES['files']['size'];
                $type = pathinfo($nama, PATHINFO_EXTENSION);
                if ($type != "xls") {
                    $message = "Data gagal diproses, periksa file type";
                } else {
                    if ($id == "gatein") {
                        fopen($tmp, 'r');
                        $this->load->library('excel_reader');
                        $this->excel_reader->setOutputEncoding('CP1251');
                        $this->excel_reader->read($tmp);
                        $arr_excel = $this->excel_reader->sheets[0];
                        $arr_data = array();
                        $rows_start = 2;
                        $rows_last = count($arr_excel['cells']);
                        $cols_start = 2;
                        $cols_last = 44;
                        $insert = true;
                        for ($i = $rows_start; $i <= $rows_last; $i++) {
                            $SQL = "SELECT A.ID FROM t_cocostshdr A
									LEFT JOIN t_cocostscont B ON B.ID=A.ID
									WHERE A.KD_ASAL_BRG = '3'
									AND A.NO_BC11 = " . $this->db->escape(trim($arr_excel['cells'][$i][6])) . "
									AND A.NO_VOY_FLIGHT = " . $this->db->escape(trim($arr_excel['cells'][$i][4])) . "
									AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = " . $this->db->escape(trim($arr_excel['cells'][$i][5])) . "
									AND LEFT(B.NO_CONT,11) = " . $this->db->escape(trim($arr_excel['cells'][$i][11]));
                            $result = $func->main->get_result($SQL);
                            if ($result) {
                                $insert = false;
                                $message = "Data gagal diproses, sudah terdapat data";
                                $error++;
                            } else {
                                for ($c = $cols_start; $c <= $cols_last; $c++) {
                                    if ($arr_excel['cells'][$i]['1'] != "") {
                                        $arrayData[$i][$c] = $arr_excel['cells'][$i][$c];
                                    }
                                }
                            }
                        }
                        if ($insert) {
                            if (count($arrayData) > 0) {
                                for ($a = $rows_start; $a <= $rows_last; $a++) {
                                    $SQL = "SELECT A.ID FROM t_cocostshdr A WHERE A.KD_ASAL_BRG = '3'
											AND A.NO_BC11 = " . $this->db->escape(trim($arr_excel['cells'][$a][6])) . "
											AND A.NO_VOY_FLIGHT = " . $this->db->escape(trim($arr_excel['cells'][$a][4])) . "
											AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = " . $this->db->escape(trim($arr_excel['cells'][$a][5])) . "
											ORDER BY A.ID DESC LIMIT 1";
                                    $result = $func->main->get_result($SQL);
                                    if ($result) {
                                        foreach ($SQL->result_array() as $row => $value) {
                                            $arrdata = $value;
                                        }
                                        $HEADER_ID = $arrdata['ID'];
                                        $data = array('KD_KAPAL' => $this->get_referensi('kapal', $arrayData[$a][3], $arrayData[$a][2]),
                                            'NM_ANGKUT' => validate($arrayData[$a][2]),
                                            'WK_REKAM' => date('Y-m-d H:i:s'));
                                        $this->db->where(array('ID' => $HEADER_ID));
                                        $this->db->update('t_cocostshdr', $data);
                                    } else {
                                        $data = array('KD_ASAL_BRG' => '3',
                                            'KD_TPS' => $KD_TPS,
                                            'KD_GUDANG' => $KD_GUDANG,
                                            'KD_KAPAL' => $this->get_referensi('kapal', $arrayData[$a][3], $arrayData[$a][2]),
                                            'NM_ANGKUT' => validate($arrayData[$a][2]),
                                            'NO_VOY_FLIGHT' => validate($arrayData[$a][4]),
                                            'TGL_TIBA' => validate($arrayData[$a][5], 'DATE-S'),
                                            'NO_BC11' => validate($arrayData[$a][6]),
                                            'TGL_BC11' => validate($arrayData[$a][7], 'DATE-S'),
                                            'KD_PEL_MUAT' => $this->get_referensi('port', $arrayData[$a][8]),
                                            'KD_PEL_TRANSIT' => $this->get_referensi('port', $arrayData[$a][9]),
                                            'KD_PEL_BONGKAR' => $this->get_referensi('port', $arrayData[$a][10]),
                                            'WK_REKAM' => date('Y-m-d H:i:s'));
                                        $this->db->insert('t_cocostshdr', $data);
                                        $HEADER_ID = $this->db->insert_id();
                                    }
                                    if ($HEADER_ID != 0 || $HEADER_ID != "") {
                                        $dtl = array('ID' => $HEADER_ID,
                                            'NO_CONT' => validate($arrayData[$a][11]),
                                            'KD_CONT_UKURAN' => $this->get_referensi('cont_ukuran', $arrayData[$a][12]),
                                            'KD_CONT_JENIS' => $this->get_referensi('cont_jenis', $arrayData[$a][13]),
                                            'KD_CONT_STATUS_IN' => $this->get_referensi('cont_status', $arrayData[$a][14]),
                                            'KD_CONT_TIPE' => $this->get_referensi('cont_tipe', $arrayData[$a][15]),
                                            'TEMPERATURE' => validate($arrayData[$a][16]),
                                            'KONDISI_SEGEL' => validate($arrayData[$a][17]),
                                            'NO_SEGEL' => validate($arrayData[$a][18]),
                                            'NO_BL_AWB' => validate($arrayData[$a][19]),
                                            'TGL_BL_AWB' => validate($arrayData[$a][20], 'DATE-S'),
                                            'NO_MASTER_BL_AWB' => validate($arrayData[$a][21]),
                                            'TGL_MASTER_BL_AWB' => validate($arrayData[$a][22], 'DATE-S'),
                                            'KD_ORG_CONSIGNEE' => $this->get_referensi('cons', $arrayData[$a][23], $arrayData[$a][24]),
                                            'BRUTO' => validate($arrayData[$a][25]),
                                            'NO_POS_BC11' => validate($arrayData[$a][26]),
                                            'KD_TIMBUN' => validate($arrayData[$a][27]),
                                            'KD_ISO_CODE' => validate($arrayData[$a][28]),
                                            'WK_IN' => validate($arrayData[$a][29], 'DATE-S'),
                                            'KD_DOK_IN' => validate($arrayData[$a][30]),
                                            'NO_DOK_IN' => validate($arrayData[$a][31]),
                                            'TGL_DOK_IN' => validate($arrayData[$a][32], 'DATE-S'),
                                            'KD_PEL_MUAT' => $this->get_referensi('port', $arrayData[$a][8]),
                                            'KD_PEL_TRANSIT' => $this->get_referensi('port', $arrayData[$a][9]),
                                            'KD_PEL_BONGKAR' => $this->get_referensi('port', $arrayData[$a][10]),
                                            'KD_SARANA_ANGKUT_IN' => validate($arrayData[$a][33]),
                                            'NO_POL_IN' => validate($arrayData[$a][34]),
                                            'FL_CONT_KOSONG' => validate($arrayData[$a][35]),
                                            'KD_GUDANG_TUJUAN' => validate($arrayData[$a][36]),
                                            'KD_KANTOR_PABEAN' => validate($arrayData[$a][37]),
                                            'NO_DAFTAR_PABEAN' => validate($arrayData[$a][38]),
                                            'TGL_DAFTAR_PABEAN' => validate($arrayData[$a][39], 'DATE-S'),
                                            'NO_SEGEL_BC' => validate($arrayData[$a][40]),
                                            'TGL_SEGEL_BC' => validate($arrayData[$a][41], 'DATE-S'),
                                            'NO_IJIN_TPS' => validate($arrayData[$a][42]),
                                            'TGL_IJIN_TPS' => validate($arrayData[$a][43], 'DATE-S'),
                                            'WK_REKAM' => date('Y-m-d H:i:s'));
                                        $this->db->insert('t_cocostscont', $dtl);
                                    } else {
                                        $message = "Data gagal diproses";
                                        $error++;
                                    }
                                }
                            } else {
                                $message = "Data gagal diproses";
                            }
                        }
                        if ($error == 0) {
                            $func->main->get_log("add", "t_cocostshdr, t_cocostscont");
                            echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                        } else {
                            echo "MSG#ERR#" . $message . "#";
                        }
                    } else if ($id == "gateout") {
                        fopen($tmp, 'r');
                        $this->load->library('excel_reader');
                        $this->excel_reader->setOutputEncoding('CP1251');
                        $this->excel_reader->read($tmp);
                        $arr_excel = $this->excel_reader->sheets[0];
                        $arr_data = array();
                        $rows_start = 2;
                        $rows_last = count($arr_excel['cells']);
                        $cols_start = 2;
                        $cols_last = 44;
                        for ($i = $rows_start; $i <= $rows_last; $i++) {
                            $SQL = "SELECT A.ID FROM t_cocostshdr A
									LEFT JOIN t_cocostscont B ON B.ID=A.ID
									WHERE A.KD_ASAL_BRG = '1'
									AND A.NO_BC11 = " . $this->db->escape(trim($arr_excel['cells'][$i][6])) . "
									AND A.NO_VOY_FLIGHT = " . $this->db->escape(trim($arr_excel['cells'][$i][4])) . "
									AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = " . $this->db->escape(trim($arr_excel['cells'][$i][5])) . "
									AND B.NO_CONT = " . $this->db->escape(trim($arr_excel['cells'][$i][11]));
                            $result = $func->main->get_result($SQL);
                            if ($result) {
                                for ($c = $cols_start; $c <= $cols_last; $c++) {
                                    if ($arr_excel['cells'][$i]['1'] != "") {
                                        $arrayData[$i][$c] = $arr_excel['cells'][$i][$c];
                                    }
                                }
                            } else {
                                $message = "Data gagal diproses, data tidak ditemukan";
                                $error++;
                            }
                        }
                        if ($error == 0 && count($arrayData) > 0) {
                            for ($a = $rows_start; $a <= $rows_last; $a++) {
                                $SQL = "SELECT A.ID, B.NO_CONT FROM t_cocostshdr A
										LEFT JOIN t_cocostscont B ON B.ID=A.ID
										WHERE A.KD_ASAL_BRG = '1'
										AND A.NO_BC11 = " . $this->db->escape(trim($arr_excel['cells'][$a][6])) . "
										AND A.NO_VOY_FLIGHT = " . $this->db->escape(trim($arr_excel['cells'][$a][4])) . "
										AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = " . $this->db->escape(trim($arr_excel['cells'][$a][5])) . "
										AND B.NO_CONT = " . $this->db->escape(trim($arr_excel['cells'][$a][11]));
                                $result = $func->main->get_result($SQL);
                                if ($result) {
                                    foreach ($SQL->result_array() as $row => $value) {
                                        $ID = $value['ID'];
                                        $NO_CONT = $value['NO_CONT'];
                                    }
                                    $dtl = array('KD_CONT_STATUS_OUT' => $this->get_referensi('cont_status', $arrayData[$a][14]),
                                        'WK_OUT' => validate($arrayData[$a][29], 'DATE-S'),
                                        'KD_DOK_OUT' => validate($arrayData[$a][30]),
                                        'NO_DOK_OUT' => validate($arrayData[$a][31]),
                                        'TGL_DOK_OUT' => validate($arrayData[$a][32], 'DATE-S'),
                                        'KD_SARANA_ANGKUT_OUT' => validate($arrayData[$a][33]),
                                        'NO_POL_OUT' => validate($arrayData[$a][34]),
                                        'FL_CONT_KOSONG' => validate($arrayData[$a][35]),
                                        'KD_GUDANG_TUJUAN' => validate($arrayData[$a][36]),
                                        'KD_KANTOR_PABEAN' => validate($arrayData[$a][37]),
                                        'NO_DAFTAR_PABEAN' => validate($arrayData[$a][38]),
                                        'TGL_DAFTAR_PABEAN' => validate($arrayData[$a][39], 'DATE-S'),
                                        'NO_SEGEL_BC' => validate($arrayData[$a][40]),
                                        'TGL_SEGEL_BC' => validate($arrayData[$a][41], 'DATE-S'),
                                        'NO_IJIN_TPS' => validate($arrayData[$a][42]),
                                        'TGL_IJIN_TPS' => validate($arrayData[$a][43], 'DATE-S'),
                                        'WK_REKAM' => date('Y-m-d H:i:s'));
                                    $this->db->where(array('ID' => $ID, 'NO_CONT' => $NO_CONT));
                                    $this->db->update('t_cocostscont', $dtl);
                                } else {
                                    $message = "Data gagal diproses, data tidak ditemukan";
                                    $error++;
                                }
                            }
                        } else {
                            $message = "Data gagal diproses";
                            $error++;
                        }
                        if ($error == 0) {
                            $func->main->get_log("update", "t_cocostscont");
                            echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                        } else {
                            echo "MSG#ERR#" . $message . "#";
                        }
                    }
                }
            }
        } else if ($type == "create") {
            if ($act == "xml_impor") {
                $dirXML = "";
                foreach ($this->input->post('tb_chktblimpor') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $SQL = "SELECT A.ID, A.NO_DOK_INOUT AS NO_DOKUMEN,
							CASE WHEN A.KD_DOK_INOUT = '1'  THEN 'SPB'
								 WHEN A.KD_DOK_INOUT = '19' THEN 'SPJ'
								 WHEN A.KD_DOK_INOUT = '6'  THEN 'NPE'
							END AS JENIS_DOKUMEN, DATE_FORMAT(A.TGL_DOK_INOUT,'%Y%m%d') AS TGL_DOKUMEN, A.KD_KANTOR, 
							A.NO_BL_AWB, DATE_FORMAT(A.TGL_BL_AWB,'%Y%m%d') AS TGL_BL_AWB, A.CONSIGNEE, 
							A.NO_DAFTAR_PABEAN, DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%Y%m%d') AS TGL_DAFTAR_PABEAN,
							CASE A.KD_DOK_INOUT WHEN '1' THEN 'PIB'
												WHEN '19' THEN 'PIB'
												WHEN '6' THEN 'PEB'
							END AS DAFTAR_PABEAN
							FROM t_permit_hdr A
							WHERE A.ID = '6'";
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                        foreach ($SQL->result_array() as $row => $value) {
                            $QUERY = "SELECT B.NO_CONT, KD_CONT_UKURAN 
									  FROM t_permit_cont B 
									  WHERE ID = " . $this->db->escape($value['ID']);
                            $exec = $func->main->get_result($QUERY);
                            if ($exec) {
                                $str_xml = '<?xml version="1.0" encoding="utf-8"?>';
                                $str_xml .= '<nctsmsg>';
                                $str_xml .= '<sender>';
                                $str_xml .= '<main>TPSONLINE NPCT1</main>';
                                $str_xml .= '<sub><type>NPCT1Customs</type></sub>';
                                $str_xml .= '</sender>';
                                $str_xml .= '<receipient>NPCT1</receipient>';
                                $str_xml .= '<msgref>' . $value['ID'] . '</msgref>';
                                $str_xml .= '<msgtype>1</msgtype>';
                                foreach ($QUERY->result_array() as $rows => $values) {
                                    $str_xml .= '<nctsdoc>';
                                    $str_xml .= '<mrnnumber>' . str_xml($value['NO_DOKUMEN']) . '</mrnnumber>';
                                    $str_xml .= '<container>' . str_xml($values['NO_CONT']) . '</container>';
                                    $str_xml .= '<doctype>' . str_xml($value['JENIS_DOKUMEN']) . '</doctype>';
                                    $str_xml .= '<validationdate>' . str_xml($value['TGL_DOKUMEN']) . '</validationdate>';
                                    $str_xml .= '<validateoffice>040300</validateoffice>';
                                    $str_xml .= '</nctsdoc>';
                                    $str_xml .= '<nctsdoc>';
                                    $str_xml .= '<mrnnumber>' . str_xml($value['NO_DAFTAR_PABEAN']) . '</mrnnumber>';
                                    $str_xml .= '<container>' . str_xml($values['NO_CONT']) . '</container>';
                                    $str_xml .= '<doctype>' . str_xml($value['DAFTAR_PABEAN']) . '</doctype>';
                                    $str_xml .= '<validationdate>' . str_xml($value['TGL_DAFTAR_PABEAN']) . '</validationdate>';
                                    $str_xml .= '<validateoffice>040300</validateoffice>';
                                    $str_xml .= '</nctsdoc>';
                                }
                                $str_xml .= '</nctsmsg>';
                            }
                        }
                        /* $file_name = $value['ID'].".xml";
                          $folder_path = date("Ymd");
                          $mvdir = $dirXML.$folder_path;
                          if (!is_dir($mvdir)){
                          $old = umask(0);
                          mkdir($mvdir, 0777);
                          umask($old);
                          }
                          $mvdir .= "/";
                          $handle = fopen($mvdir.$file_name, 'w');
                          if(fwrite($handle, $edi) === FALSE){
                          echo "Failed create file";
                          $this->db->where(array('ID' => $row['ID'], 'NO_CONT' => $row['NO_CONT']));
                          $this->db->update('t_cocostscont',array('FL_CREATE' => '300'));
                          }else{
                          fclose($handle);
                          chmod($file,0777);
                          echo "Success create file";
                          $this->db->where(array('ID' => $row['ID'], 'NO_CONT' => $row['NO_CONT']));
                          $this->db->update('t_cocostscont',array('FL_CREATE' => '200'));
                          $a++;
                          } */
                    }
                }
                die();
                if ($result) {
                    //$func->main->get_log("add","t_cocostscont");
                    //echo "MSG#OK#Data berhasil diproses#".site_url()."/".$ACTION."/post/".$ID;
                } else {
                    //echo "MSG#ERR#Data gagal diproses#";
                }
            }
			
		  if ($act == "xml_impor_ubahstatus") {

                $dirXML = "";
$SQL = "SELECT A.NO_UBAH_STATUS, A.KD_GUDANG_ASAL, A.KD_GUDANG_TUJUAN,
        B.NM_LENGKAP,B.KD_ORGANISASI,C.NAMA,C.ALAMAT,C.EMAIL,C.NPWP,C.NOTELP,
        C.NOFAX,A.NAMA_KAPAL,A.CALL_SIGN,A.NO_VOY_FLIGHT,DATE_FORMAT(A.TGL_TIBA,'%Y-%m-%d') AS TGL_TIBA,A.NO_BC11,
        DATE_FORMAT(A.TGL_BC11,'%Y-%m-%d') AS TGL_BC11, DATE_FORMAT(A.TGL_UBAH_STATUS,'%Y-%m-%d') AS TGL_UBAH_STATUS 
                    FROM t_ubah_status A INNER JOIN app_user B ON A.ID_USER=B.ID INNER JOIN t_organisasi C ON B.KD_ORGANISASI=C.ID 
                    WHERE A.KD_STATUS='200'";

                   
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                                $str_xml = '<?xml version="1.0" encoding="utf-8"?>';
                                $str_xml .= '<DOCUMENT xmlns="loadubahstatus.xsd">';
                                $str_xml .= ' <LOADUBAHSTATUS>';
                                
                                foreach ($SQL->result_array() as $rows => $values) {
                                    
                                    $str_xml .= '<HEADER>';
                                    $str_xml .= '<NO_UBAH_STATUS>' . str_xml($values['NO_UBAH_STATUS']) . '</NO_UBAH_STATUS>';
                                    $str_xml .= '<KD_GUDANG_ASAL>' . str_xml($values['KD_GUDANG_ASAL']) . '</KD_GUDANG_ASAL>';
                                    $str_xml .= '<KD_GUDANG_TUJUAN>' . str_xml($values['KD_GUDANG_TUJUAN']) . '</KD_GUDANG_TUJUAN>';
                                    $str_xml .= '<NM_LENGKAP>' . str_xml($values['NM_LENGKAP']) . '</NM_LENGKAP>';
                                    $str_xml .= '<KD_ORGANISASI>' . str_xml($values['KD_ORGANISASI']) . '</KD_ORGANISASI>';
                                    $str_xml .= '<NAMA_ORGANISASI>' . str_xml($values['NAMA_ORGANISASI']) . '</NAMA_ORGANISASI>';
                                    $str_xml .= '<ALAMAT>' . str_xml($values['ALAMAT']) . '</ALAMAT>';
                                    $str_xml .= '<EMAIL>' . str_xml($values['EMAIL']) . '</EMAIL>';
                                    $str_xml .= '<NPWP>' . str_xml($values['NPWP']) . '</NPWP>';
                                    $str_xml .= '<NOTELP>' . str_xml($values['NOTELP']) . '</NOTELP>';
                                    $str_xml .= '<NOFAX>' . str_xml($values['NOFAX']) . '</NOFAX>';
                                    $str_xml .= '<NAMA_KAPAL>' . str_xml($values['NAMA_KAPAL']) . '</NAMA_KAPAL>';
                                    $str_xml .= '<NO_VOY_FLIGHT>' . str_xml($values['NO_VOY_FLIGHT']) . '</NO_VOY_FLIGHT>';
                                    $str_xml .= '<TGL_TIBA>' . str_xml($values['TGL_TIBA']) . '</TGL_TIBA>';
                                    $str_xml .= '<NO_BC11>' . str_xml($values['NO_BC11']) . '</NO_BC11>';
                                    $str_xml .= '<TGL_BC11>' . str_xml($values['TGL_BC11']) . '</TGL_BC11>';
                                    $str_xml .= '<TGL_UBAH_STATUS>' . str_xml($values['TGL_UBAH_STATUS']) . '</TGL_UBAH_STATUS>';
                                    $str_xml .= '</HEADER>';
                                     $str_xml .= ' <DETIL>';
 #$DETAIL = mysq"SELECT NO_CONT,UKURAN,DATE_FORMAT(WK_REKAM,'%Y-%m-%d %H-%i-%s') AS WK_REKAM FROM t_no_kontainer WHERE NO_UBAH_STATUS='".$values['NO_UBAH_STATUS']."'";                                  
  $this->db->select("NO_CONT,KD_CONT_UKURAN, WK_REKAM");
  $this->db->where('NO_UBAH_STATUS', $values['NO_UBAH_STATUS']);
$DETAIL = $this->db->get('t_no_kontainer');
      foreach ($DETAIL->result_array() as $rowsD => $d) {
                 
                  $str_xml .= ' <CONTAINER>';
                  $str_xml .= ' <NO_CONT>' . str_xml($d['NO_CONT']) . '</NO_CONT>';
                  $str_xml .= '<UKURAN>' . str_xml($d['UKURAN']) . '</UKURAN>';
                  $str_xml .= '<WK_REKAM>' . str_xml($d['WK_REKAM']) . '</WK_REKAM>';
                  $str_xml .= '</CONTAINER>';
                  
}
$str_xml .= '</DETIL>';
                                }
                                $str_xml .= '</LOADUBAHSTATUS>';
                                $str_xml .= '</DOCUMENT>';
                        if($str_xml == true)
                        {
                        	/*
                        $this->db->set('KD_STATUS', '2');
                        $this->db->where('KD_STATUS', '1');
                        $ubah = $this->db->update('t_ubah_status');
                        */
                         echo $str_xml;
                        }
                        else
                        {
                            echo "periksa koneksi anda";
                        }

                                
                    }
                    else
                    {
                        echo "Data Tidak Ditemukan";
                    }
             
                    /*
 $this->load->helper('download');
force_download('ubahstatus.xml', $str_xml);
*/
            }
        }
    }

    function get_data($act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $KD_TPS = $this->newsession->userdata('KD_TPS');
        $KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
        if ($act == "kapal") {
            $arrid = explode("~", $id);
            $SQL = "SELECT A.*, B.NAMA AS NAMA_KAPAL, B.CALL_SIGN, func_name(A.KD_ASAL_BRG,'ASAL_BARANG') AS ASAL_BARANG,
					func_name(A.KD_ASAL_BRG,'ASAL_BARANG') AS ASAL_BARANG, func_name(A.KD_GUDANG,'GUDANG') AS GUDANG,
					func_name(A.KD_KAPAL,'KAPAL') AS NAMA_KAPAL, DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, 
					func_name(A.KD_PEL_MUAT,'PORT') AS PEL_MUAT, func_name(A.KD_PEL_TRANSIT,'PORT') AS PEL_TRANSIT,
					func_name(A.KD_PEL_BONGKAR,'port') AS PEL_BONGKAR, DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS TGL_BC11, 
					DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y %H:%i:%s') AS TGL_REKAM, func_name(A.KD_TPS,'TPS') AS TPS,
					DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') TGL_PLP
					FROM t_cocostshdr A
					LEFT JOIN reff_kapal B ON B.ID=A.KD_KAPAL
					WHERE A.ID = " . $this->db->escape($arrid[0]);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "kapal_repo") {
            $arrid = explode("~", $id);
            $SQL = "SELECT A.*, B.NAMA AS NAMA_KAPAL, A.CALL_SIGN, func_name(A.KD_ASAL_BRG,'ASAL_BARANG') AS ASAL_BARANG,
					func_name(A.KD_ASAL_BRG,'ASAL_BARANG') AS ASAL_BARANG, func_name(A.KD_GUDANG,'GUDANG') AS GUDANG,
					func_name(A.KD_KAPAL,'KAPAL') AS NAMA_KAPAL, DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, 
					func_name(A.KD_PEL_MUAT,'PORT') AS PEL_MUAT, func_name(A.KD_PEL_TRANSIT,'PORT') AS PEL_TRANSIT,
					func_name(A.KD_PEL_BONGKAR,'port') AS PEL_BONGKAR, DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS TGL_BC11, 
					DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y %H:%i:%s') AS TGL_REKAM, func_name(A.KD_TPS,'TPS') AS TPS
					FROM t_repohdr A
					LEFT JOIN reff_kapal B ON B.ID=A.KD_KAPAL
					WHERE A.ID = " . $this->db->escape($arrid[0]);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "kontainer") {
            $arrid = explode("~", $id);
            if ($arrid[0] != "") {
                $addsql .= " AND A.ID = " . $this->db->escape($arrid[0]);
            }
            if ($arrid[1] != "") {
                $addsql .= " AND A.NO_CONT = " . $this->db->escape($arrid[1]);
            }
            $SQL = "SELECT A.*, B.NPWP AS NPWP_CONSIGNEE, B.NAMA AS CONSIGNEE, func_name(A.KD_CONT_UKURAN, 'CONT_UKURAN') AS CONT_UKURAN,
					func_name(A.KD_CONT_JENIS, 'CONT_JENIS') AS CONT_JENIS, func_name(A.KD_CONT_TIPE, 'CONT_TIPE') AS CONT_TIPE,
					func_name(A.KD_ISO_CODE, 'ISO_CODE') AS ISO_CODE, DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS TGL_BL_AWB,
					DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y') AS TGL_MASTER_BL_AWB, func_name(A.KD_PEL_MUAT,'port') AS PEL_MUAT,
					func_name(A.KD_PEL_TRANSIT,'port') AS PEL_TRANSIT, func_name(A.KD_PEL_BONGKAR,'port') AS PEL_BONGKAR,
					func_name(A.KD_DOK_IN,'DOK_BC') AS DOK_IN, DATE_FORMAT(A.TGL_DOK_IN,'%d-%m-%Y') AS TGL_DOK_IN,
					DATE_FORMAT(A.WK_IN,'%d-%m-%Y %H:%i:%s') AS WK_IN, func_name(A.KD_CONT_STATUS_IN, 'CONT_STATUS') AS CONT_STATUS_IN,
					func_name(A.KD_SARANA_ANGKUT_IN, 'SARANA_ANGKUT') AS SARANA_ANGKUT_IN, func_name(A.KD_DOK_OUT,'DOK_BC') AS DOK_OUT,
					DATE_FORMAT(A.TGL_DOK_OUT,'%d-%m-%Y') AS TGL_DOK_OUT, func_name(A.KD_CONT_STATUS_OUT, 'CONT_STATUS') AS CONT_STATUS_OUT,
					func_name(A.KD_SARANA_ANGKUT_OUT, 'SARANA_ANGKUT') AS SARANA_ANGKUT_OUT, func_name(A.KD_TPS_TUJUAN, 'TPS') AS TPS_TUJUAN,
					func_name(A.KD_GUDANG_TUJUAN, 'GUDANG') AS GUDANG_TUJUAN, DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_DAFTAR_PABEAN,
					DATE_FORMAT(A.TGL_SEGEL_BC,'%d-%m-%Y') AS TGL_SEGEL_BC, DATE_FORMAT(A.TGL_IJIN_TPS,'%d-%m-%Y') AS TGL_IJIN_TPS,
					DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y %H:%i:%s') AS TGL_REKAM, DATE_FORMAT(A.WK_OUT,'%d-%m-%Y %H:%i:%s') AS WK_OUT
					FROM t_cocostscont A
					LEFT JOIN t_organisasi B ON B.ID=A.KD_ORG_CONSIGNEE
					WHERE 1=1" . $addsql;
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "kontainer_repo") {

            $arrid = explode("~", $id);
            if ($arrid[0] != "") {
                $addsql .= " AND A.ID = " . $this->db->escape($arrid[0]);
            }
            if ($arrid[1] != "") {
                $addsql .= " AND A.NO_CONT = " . $this->db->escape($arrid[1]);
            }
            $SQL = "SELECT A.*, B.NPWP AS NPWP_CONSIGNEE, B.NAMA AS CONSIGNEE, func_name(A.KD_CONT_UKURAN, 'CONT_UKURAN') AS CONT_UKURAN,
					func_name(A.KD_CONT_JENIS, 'CONT_JENIS') AS CONT_JENIS, func_name(A.KD_CONT_TIPE, 'CONT_TIPE') AS CONT_TIPE,
					func_name(A.KD_ISO_CODE, 'ISO_CODE') AS ISO_CODE, DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS TGL_BL_AWB,
					DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y') AS TGL_MASTER_BL_AWB, func_name(A.KD_PEL_MUAT,'port') AS PEL_MUAT,
					func_name(A.KD_PEL_TRANSIT,'port') AS PEL_TRANSIT, func_name(A.KD_PEL_BONGKAR,'port') AS PEL_BONGKAR,
					func_name(A.KD_DOK_IN,'DOK_BC') AS DOK_IN, DATE_FORMAT(A.TGL_DOK_IN,'%d-%m-%Y') AS TGL_DOK_IN,
					DATE_FORMAT(A.WK_IN,'%d-%m-%Y %H:%i:%s') AS WK_IN, func_name(A.KD_CONT_STATUS_IN, 'CONT_STATUS') AS CONT_STATUS_IN,
					func_name(A.KD_SARANA_ANGKUT_IN, 'SARANA_ANGKUT') AS SARANA_ANGKUT_IN, func_name(A.KD_DOK_OUT,'DOK_BC') AS DOK_OUT,
					DATE_FORMAT(A.TGL_DOK_OUT,'%d-%m-%Y') AS TGL_DOK_OUT, func_name(A.KD_CONT_STATUS_OUT, 'CONT_STATUS') AS CONT_STATUS_OUT,
					func_name(A.KD_SARANA_ANGKUT_OUT, 'SARANA_ANGKUT') AS SARANA_ANGKUT_OUT, func_name(A.KD_TPS_TUJUAN, 'TPS') AS TPS_TUJUAN,
					func_name(A.KD_GUDANG_TUJUAN, 'GUDANG') AS GUDANG_TUJUAN, DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_DAFTAR_PABEAN,
					DATE_FORMAT(A.TGL_SEGEL_BC,'%d-%m-%Y') AS TGL_SEGEL_BC, DATE_FORMAT(A.TGL_IJIN_TPS,'%d-%m-%Y') AS TGL_IJIN_TPS,
					DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y %H:%i:%s') AS TGL_REKAM, DATE_FORMAT(A.WK_OUT,'%d-%m-%Y %H:%i:%s') AS WK_OUT
					FROM t_repocont A
					LEFT JOIN t_organisasi B ON B.ID=A.KD_ORG_CONSIGNEE
					WHERE 1=1" . $addsql;
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "kemasan") {
            $arrid = explode("~", $id);
            if ($arrid[0] != "") {
                $addsql .= " AND A.ID = " . $this->db->escape($arrid[0]);
            }
            if ($arrid[1] != "") {
                $addsql .= " AND A.SERI = " . $this->db->escape($arrid[1]);
            }
            $SQL = "SELECT A.*, func_name(A.KD_KEMASAN,'KEMASAN') AS KEMASAN, func_name(A.KD_DOK_IN,'DOK_BC') AS NAMA_DOK_IN,
					func_name(A.KD_PEL_MUAT,'PORT') AS PEL_MUAT, func_name(A.KD_PEL_TRANSIT,'PORT') AS PEL_TRANSIT, 
					func_name(A.KD_PEL_BONGKAR,'PORT') AS PEL_BONGKAR, B.NAMA AS CONSIGNEE, DATE_FORMAT(A.WK_IN,'%d-%m-%Y %H:%i:%s') AS WK_IN,
					func_name(A.KD_DOK_IN,'DOK_BC') AS DOK_IN, DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y') AS TGL_MASTER_BL_AWB,
					DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS TGL_BL_AWB, DATE_FORMAT(A.TGL_DOK_IN,'%d-%m-%Y') AS TGL_DOK_IN,
					DATE_FORMAT(A.WK_OUT,'%d-%m-%Y %H:%i:%s') AS WK_OUT, func_name(A.KD_DOK_OUT,'DOK_BC') AS DOK_OUT,
					DATE_FORMAT(A.TGL_DOK_OUT,'%d-%m-%Y') AS TGL_DOK_OUT, DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%d-%m-%Y') AS TGL_DAFTAR_PABEAN,
					DATE_FORMAT(A.TGL_SEGEL_BC,'%d-%m-%Y') AS TGL_SEGEL_BC, DATE_FORMAT(A.TGL_IJIN_TPS,'%d-%m-%Y') AS TGL_IJIN_TPS,
					DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y %H:%i:%s') AS TGL_REKAM,
					func_name(A.KD_CONT_STATUS_IN,'CONT_STATUS') AS CONT_STATUS_IN, 
					func_name(A.KD_SARANA_ANGKUT_IN,'SARANA_ANGKUT') AS SARANA_ANGKUT_IN,  
					func_name(A.KD_CONT_STATUS_OUT,'CONT_STATUS') AS CONT_STATUS_OUT,
					func_name(A.KD_SARANA_ANGKUT_OUT,'SARANA_ANGKUT') AS SARANA_ANGKUT_OUT
					FROM t_cocostskms A
					LEFT JOIN t_organisasi B ON B.ID=A.KD_ORG_CONSIGNEE
                    WHERE 1=1" . $addsql;
                    //var_dump($SQL);die();
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "coarri_codeco") {
            $add = "";
            $add_sql = "";
            $arr = explode("-", $id);
            switch ($arr[1]) {
                case "discharge" : $add = "WK_IN";
                    $add_sql .= " AND A.KD_ASAL_BRG = '1'";
                    break;
                case "loading" : $add = "WK_OUT";
                    $add_sql .= " AND A.KD_ASAL_BRG = '4'";
                    break;
                case "gate_in" : $add = "WK_IN";
                    $add_sql .= " AND A.KD_ASAL_BRG = '4'";
                    break;
                case "gate_out" : $add = "WK_OUT";
                    $add_sql .= " AND A.KD_ASAL_BRG = '1'";
                    break;
            }
            $SQL = "SELECT COUNT(*) AS DATA 
					FROM t_cocostshdr A
					INNER JOIN " . $arr[0] . " B ON B.ID=A.ID
					WHERE YEAR(B." . $add . ")=YEAR(NOW())
					AND WEEKOFYEAR(NOW())=WEEKOFYEAR(B." . $add . ")" . $add_sql;
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata['DATA'];
            }
        } else if ($act == "permit_hdr") {
            $SQL = "SELECT A.ID, A.CAR, A.KD_KANTOR, IFNULL(C.NAMA,'-') AS NMKPBC, A.KD_DOK_INOUT, A.NO_DOK_INOUT, A.TGL_DOK_INOUT,
					A.NO_DAFTAR_PABEAN, A.TGL_DAFTAR_PABEAN, A.ALAMAT_CONSIGNEE, IFNULL(A.NPWP_PPJK,'-') AS NPWP_PPJK, 
					IFNULL(A.NAMA_PPJK,'-') AS NAMA_PPJK, IFNULL(A.ALAMAT_PPJK,'-') AS ALAMAT_PPJK, A.NO_VOY_FLIGHT, A.KD_GUDANG, 
					IFNULL(A.JML_CONT,'-') AS JML_CONT, IFNULL(A.BRUTO,'-') AS BRUTO, IFNULL(A.NETTO,'-') AS NETTO, 
					IFNULL(A.NO_BC11,'-') AS NO_BC11, IFNULL(A.TGL_BC11,'-') AS TGL_BC11, IFNULL(A.NO_POS_BC11,'-') AS NO_POS_BC11, 
					IFNULL(A.NO_BL_AWB,'-') AS NO_BL_AWB, IFNULL(A.TGL_BL_AWB,'-') AS TGL_BL_AWB, func_name(A.KD_GUDANG,'GUDANG') as GUDANG,
					IFNULL(A.NO_MASTER_BL_AWB,'-') AS NO_MASTER_BL_AWB, IFNULL(A.TGL_MASTER_BL_AWB,'-') AS TGL_MASTER_BL_AWB, 
					IFNULL(A.KD_KANTOR_PENGAWAS,'-') AS KD_KANTOR_PENGAWAS, IFNULL(A.KD_KANTOR_BONGKAR,'-') AS KD_KANTOR_BONGKAR, 
					A.FL_SEGEL, CASE A.STATUS_JALUR WHEN 'H' THEN 'HIJAU' WHEN 'K' THEN 'KUNING' ELSE 'MERAH' END AS STATUS_JALUR, 
					A.FL_KARANTINA, A.KD_STATUS, A.TGL_STATUS, A.NM_ANGKUT, A.ID_CONSIGNEE AS NPWP_CONSIGNEE, 
					A.CONSIGNEE AS 'NM_CONSIGNEE', D.NAMA AS 'JENIS_DOK'
					FROM t_permit_hdr A
					LEFT JOIN reff_kapal B ON A.NM_ANGKUT = B.ID
					LEFT JOIN reff_kpbc C ON A.KD_KANTOR = C.ID
					LEFT JOIN reff_kode_dok_bc D ON A.KD_DOK_INOUT = D.ID
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
        } else if ($act == "custimp_hdr") {
            $SQL = "SELECT * FROM t_request_custimp_hdr WHERE ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "request_plp") {
            $SQL = "SELECT A.NO_SURAT, DATE_FORMAT(A.TGL_SURAT,'%d-%m-%Y') AS TGL_SURAT, A.YOR_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN,
					A.YOR_TUJUAN, A.KD_KAPAL, A.NM_ANGKUT, A.NO_VOY_FLIGHT, DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA,
					A.NO_BC11, DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS TGL_BC11, A.NM_PEMOHON, A.KD_ALASAN_PLP, 
					B.KD_PEL_MUAT, func_name(B.KD_PEL_MUAT,'PORT') AS PEL_MUAT, 
					B.KD_PEL_TRANSIT, func_name(B.KD_PEL_TRANSIT,'PORT') AS PEL_TRANSIT,
					B.KD_PEL_BONGKAR, func_name(B.KD_PEL_BONGKAR,'port') AS PEL_BONGKAR, 
					C.NAMA AS ALASAN_PLP, D.NAMA_GUDANG AS GUDANG_TUJUAN
					FROM t_request_plp_hdr A
					LEFT JOIN t_cocostshdr B ON B.NM_ANGKUT=A.NM_ANGKUT AND B.NO_VOY_FLIGHT=A.NO_VOY_FLIGHT
					AND B.TGL_TIBA=A.TGL_TIBA AND B.NO_BC11=A.NO_BC11 AND B.TGL_BC11=A.TGL_BC11
					LEFT JOIN reff_alasan_plp C ON C.ID=A.KD_ALASAN_PLP
					LEFT JOIN reff_gudang D ON D.KD_TPS=A.KD_TPS_TUJUAN AND D.KD_GUDANG=A.KD_GUDANG_TUJUAN
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
        } else if ($act == "request_plp_cont") {
            $SQL = "SELECT A.ID, A.NO_CONT, A.KD_CONT_UKURAN FROM t_request_plp_cont A WHERE A.ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata[] = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "respon_plp") {
            $SQL = "SELECT A.*, func_name(A.KD_KPBC,'KPBC') AS KPBC, DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') AS TGL_PLP,
					DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s') AS TGL_STATUS, B.NAMA AS STATUS
					FROM t_respon_plp_asal_hdr A
					LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPRES'
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
        } else if ($act == "respon_plp_cont_print") {
            $arrid = explode('~', $id);
            if ($arrid[1] != "") {
                $add_sql .= " AND B.NO_CONT = " . $this->db->escape($arrid[1]);
            }
            $SQL = "SELECT A.KD_KPBC, func_name(A.KD_KPBC,'KPBC') AS KPBC, A.NO_PLP, DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') AS TGL_PLP,
					B.NO_CONT, B.KD_CONT_UKURAN, B.KD_CONT_JENIS, B.KD_STATUS, C.NO_SURAT, 
					DATE_FORMAT(C.TGL_SURAT,'%d-%m-%Y') AS TGL_SURAT, C.KD_TPS_ASAL, C.KD_TPS_TUJUAN, 
					C.YOR_ASAL, C.YOR_TUJUAN, C.NO_VOY_FLIGHT, DATE_FORMAT(C.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, C.NO_BC11,
					DATE_FORMAT(C.TGL_BC11,'%d-%m-%Y') AS TGL_BC11, D.NAMA AS ALASAN_PLP, C.NM_ANGKUT AS NM_KAPAL,
					func_name(C.KD_TPS_ASAL,'TPS') AS TPS_ASAL, func_name(C.KD_TPS_TUJUAN,'TPS') AS TPS_TUJUAN
					FROM t_respon_plp_asal_hdr A
					INNER JOIN t_respon_plp_asal_cont B ON B.ID=A.ID
					INNER JOIN t_request_plp_hdr C ON C.REF_NUMBER=A.REF_NUMBER
					INNER JOIN reff_alasan_plp D ON D.ID=C.KD_ALASAN_PLP
					WHERE A.ID = " . $this->db->escape($arrid[0]) . $add_sql;
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata[] = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "request_batal_plp") {
            $SQL = "SELECT A.NO_SURAT, DATE_FORMAT(A.TGL_SURAT,'%d-%m-%Y') AS TGL_SURAT, A.ALASAN, A.NM_PEMOHON,
					B.NO_PLP, DATE_FORMAT(B.TGL_PLP,'%d-%m-%Y') AS TGL_PLP, B.KD_KPBC, func_name(B.KD_KPBC,'KPBC') AS KPBC,
					B.ALASAN_REJECT, A.KD_KPBC AS KD_KPBC_BTL, func_name(B.KD_KPBC,'KPBC') AS KPBC_BTL
					FROM t_request_batal_plp_hdr A
					LEFT JOIN t_respon_plp_asal_hdr B ON B.REF_NUMBER=A.REF_NUMBER
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
        } else if ($act == "sppb") {
            $SQL = "SELECT A.CAR, A.NO_SPPB, DATE_FORMAT(A.TGL_SPPB, '%d-%m-%y') as TGL_SPPB, A.NO_DO, DATE_FORMAT(A.TGL_DO, '%d-%m-%y') as TGL_DO, 
					A.KD_KPBC, DATE_FORMAT(A.TGL_EXPIRED_DO, '%d-%m-%y') as TGL_EXPIRED_DO, A.NAMA_FORWARDER, A.NO_CONT_ASAL,
					func_name(IFNULL(A.KODE_DOK,'-'),'DOK_BC') AS DOK_BC, A.WK_REKAM, A.KD_STATUS, 
					func_npwp(A.NPWP_CONSIGNEE) AS NPWP_IMP, A.CONSIGNEE, A.NO_BL_AWB, A.NM_ANGKUT, A.KD_GUDANG_TUJUAN, func_name(IFNULL(KD_KPBC,'-'),'KPBC') AS 'NM_KPBC',
					DATE_FORMAT(A.TGL_TIBA, '%d-%m-%y') as TGL_TIBA,IFNULL(DATE_FORMAT(A.TGL_STATUS, '%d-%m-%y'),'-') AS TGL_STATUS,
					func_name(IFNULL(A.KODE_DOK,'-'),'DOK_BC') AS 'DOK_BC', func_name(IFNULL(KD_GUDANG_TUJUAN,'-'),'GUDANG') AS 'NM_GUDANG' 
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
        } else if ($act == "history") {
            $SQL = "SELECT A.DESKRIPSI, DATE_FORMAT(A.WK_REKAM,'%W, %M %Y %H:%i:%s') AS WK_REKAM, B.NM_LENGKAP, B.PATH
					FROM app_log A
					INNER JOIN app_user B ON B.ID=A.KD_USER
					WHERE A.WK_REKAM >= DATE_SUB(NOW(), INTERVAL 8 HOUR)
					AND A.KD_USER = " . $this->db->escape($this->newsession->userdata('ID')) . "
					ORDER BY A.WK_REKAM DESC";
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata[] = $value;
                }
                return $arrdata;
            }
        }
    }

}