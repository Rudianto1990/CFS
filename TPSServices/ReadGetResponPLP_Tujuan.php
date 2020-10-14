<?php

set_time_limit(3600);
require_once("config.php");

$method = 'READGETRESPONPLPTUJUAN2';
$KdAPRF = 'GETRESPLPTUJUAN2';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $main->connect();

    //BEGIN
	$SQL = "SELECT a.ID, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('GetResponPLP_Tujuan','ReceiveResponPLP_Tujuan') AND a.FL_USED='0' AND a.RESPONSE is not null order by a.WK_REKAM ASC limit 10";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $ID_LOG = $Query->get("ID");
            $STR_DATA = $Query->get("RESPONSE");

            $xml = xml2ary($STR_DATA);
            if (count($xml) > 0) {
                $xml = $xml['DOCUMENT']['_c'];
                $countPLP = count($xml['RESPONPLP']);
                if ($countPLP > 1) {
                    for ($c = 0; $c < $countPLP; $c++) {
                        $RESPONPLP = $xml['RESPONPLP'][$c]['_c'];
                        InsertPLPResponTujuan($RESPONPLP);
                    }
                } elseif ($countPLP == 1) {
                    $RESPONPLP = $xml['RESPONPLP']['_c'];
                    InsertPLPResponTujuan($RESPONPLP);
                }
                if($countPLP > 0){
					echo 'Sukses';
                    $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);

                    $SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);

                    if($Execute){
                        $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                        $Execute = $conn->execute($SQL);                    
                    }
                }else{
					echo 'Data XML salah';
                    $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);    

                    $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);

                    $SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Tidak Berhasil Parsing Data', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);

                    if($Execute){
                        $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                        $Execute = $conn->execute($SQL);                    
                    }
                }
            }else{
				echo 'Data XML tidak ada';
                $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);    

                $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

				$SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Tidak ada data', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);

                if($Execute){
                    $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);                    
                }
            }
        }
    } else {
        echo 'data tidak ada.';
    }
    //END

    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}

function InsertPLPResponTujuan($RESPONPLP) {
    global $CONF, $conn;
    $header = $RESPONPLP['HEADER']['_c'];
    $KD_KANTOR = trim($header['KD_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR']['_v'])) . "'";
    $KD_TPS = trim($header['KD_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS']['_v'])) . "'";
    $KD_TPS_ASAL = trim($header['KD_TPS_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS_ASAL']['_v'])) . "'";
    $GUDANG_TUJUAN = trim($header['GUDANG_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG_TUJUAN']['_v'])) . "'";
    $NO_PLP = trim($header['NO_PLP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_PLP']['_v'])) . "'";
    $TGL_PLP = trim($header['TGL_PLP']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_PLP']['_v'])) . "','%Y%m%d')";
    $CALL_SIGN = trim($header['CALL_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CALL_SIGN']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $TGL_TIBA = trim($header['TGL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_TIBA']['_v'])) . "','%Y%m%d')";
    //add tag element
    $NO_BC11 = trim($header['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($header['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_BC11']['_v'])) . "','%Y%m%d')";
    $NO_SURAT = trim($header['NO_SURAT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_SURAT']['_v'])) . "'";
    $TGL_SURAT = trim($header['TGL_SURAT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_SURAT']['_v'])) . "','%Y%m%d')";

    echo $NO_PLP . '-' . $TGL_PLP . '<br>';
    $SQL = "SELECT ID
            FROM t_respon_plp_tujuan_v2_hdr
            WHERE NO_PLP = " . $NO_PLP . " 
                  AND TGL_PLP = " . $TGL_PLP . "";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_respon_plp_tujuan_v2_hdr (KD_KPBC, KD_TPS_ASAL, KD_TPS_TUJUAN, KD_GUDANG_TUJUAN, 
                                                        NO_PLP, TGL_PLP, NO_SURAT, TGL_SURAT, NM_ANGKUT, 
                                                        NO_VOY_FLIGHT, CALL_SIGN, TGL_TIBA, NO_BC11, TGL_BC11, 
                                                        TGL_STATUS)
                VALUES (" . $KD_KANTOR . ", " . $KD_TPS_ASAL . ", " . $KD_TPS . ", " . $GUDANG_TUJUAN . ", " . $NO_PLP . ", 
                        " . $TGL_PLP . ", " . $NO_SURAT . ", " . $TGL_SURAT . ", " . $NM_ANGKUT . ", " . $NO_VOY_FLIGHT . ", 
                        " . $CALL_SIGN . ", " . $TGL_TIBA . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", NOW())";
        $Execute = $conn->execute($SQL);
        echo $SQL . '<br>';
        $ID = mysql_insert_id();

        if ($ID != '') {
            // INSERT INTO t_cocostshdr BEGIN
            $SQL = "SELECT ID
                    FROM t_cocostshdr
                    WHERE KD_ASAL_BRG = '2'
                          AND NO_BC11 = " . $NO_BC11 . "
                          AND TGL_BC11 = " . $TGL_BC11 . "";
            echo $SQL . '<br>';
            $Query = $conn->query($SQL);
            if ($Query->size() > 0) {
                $Query->next();
                $ID_T_COCOSTSHDR = $Query->get("ID");
            } else {
                $SQL = "INSERT INTO t_cocostshdr (KD_ASAL_BRG, KD_TPS, KD_GUDANG, KD_KAPAL, NM_ANGKUT, NO_VOY_FLIGHT, 
                                              TGL_TIBA, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, NO_BC11, 
                                              TGL_BC11, CARMANIF, WK_REKAM)
                    VALUES ('2', " . $KD_TPS . ", " . $GUDANG_TUJUAN . ", NULL, " . $NM_ANGKUT . ", " . $NO_VOY_FLIGHT . ", 
                            " . $TGL_TIBA . ", NULL, NULL, NULL, " . $NO_BC11 . ", 
                            " . $TGL_BC11 . ", NULL, NOW())";
                echo $SQL . '<br>';
                $Execute = $conn->execute($SQL);
                $ID_T_COCOSTSHDR = mysql_insert_id();
            }
            // INSERT INTO t_cocostshdr END
            //DETIL KEMASAN DAN KONTAINER
            $detil = $RESPONPLP['DETIL']['_c'];

            //KEMASAN
            $countKMS = count($detil['KMS']);
            if ($countKMS > 1) {
                for ($d = 0; $d < $countKMS; $d++) {
                    $KMS = $detil['KMS'][$d]['_c'];
                    InsertKemasan($ID, $KMS, $ID_T_COCOSTSHDR);
                }
            } else if ($countKMS == 1) {
                $KMS = $detil['KMS']['_c'];
                InsertKemasan($ID, $KMS, $ID_T_COCOSTSHDR);
            }

            //KONTAINER
            $countCONT = count($detil['CONT']);
            if ($countCONT > 1) {
                for ($d = 0; $d < $countCONT; $d++) {
                    $CONT = $detil['CONT'][$d]['_c'];
                    InsertKontainer($ID, $CONT, $ID_T_COCOSTSHDR);
                }
            } elseif ($countCONT == 1) {
                $CONT = $detil['CONT']['_c'];
                InsertKontainer($ID, $CONT, $ID_T_COCOSTSHDR);
            }
        }
    }
}

function InsertKemasan($ID, $KMS, $ID_T_COCOSTSHDR) {
    global $CONF, $conn;
    $JNS_KMS = trim($KMS['JNS_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['JNS_KMS']['_v'])) . "'";
    $JML_KMS = trim($KMS['JML_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['JML_KMS']['_v'])) . "'";
    $NO_BL_AWB = trim($KMS['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($KMS['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";
    //add tag element
//    $NO_POS_BC11 = trim($KMS['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_POS_BC11']['_v'])) . "'";
//    $CONSIGNEE = trim($KMS['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['CONSIGNEE']['_v'])) . "'";
    echo $JNS_KMS . '<br>';

    $SQL = "INSERT INTO t_respon_plp_tujuan_v2_kms (ID, KD_KEMASAN, JML_KMS, NO_BL_AWB, TGL_BL_AWB)
            VALUES (" . $ID . ", " . $JNS_KMS . ", " . $JML_KMS . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ")";
    $Execute = $conn->execute($SQL);
    echo $SQL . '<br>';

    //INSERT INTO t_cocostskms BEGIN
    $SQL = "SELECT IFNULL(MAX(SERI),0) AS MAX_SERI
            FROM t_cocostskms 
            WHERE ID = " . $ID_T_COCOSTSHDR . "";
    echo $SQL . '<br>';
    $QueryDetail = $conn->query($SQL);
    $QueryDetail->next();
    $MAX_SERI = $QueryDetail->get("MAX_SERI");
    $NEXT_SERI = intval($MAX_SERI) + intval(1);

//    $SQL = "SELECT ID
//            FROM t_organisasi
//            WHERE NAMA = " . $CONSIGNEE . "
//                  AND KD_TIPE_ORGANISASI = 'CONS'";
//    echo $SQL . '<br>';
//    $QueryDetail = $conn->query($SQL);
//    if ($QueryDetail->size() > 0) {
//        $ID_ORGANISASI = $QueryDetail->get("ID");
//    } else {
//        $SQL = "INSERT INTO t_organisasi (KD_KAPAL, NPWP, NAMA, ALAMAT, NOTELP, NOFAX, EMAIL, 
//                                                 KD_TIPE_ORGANISASI, KD_TPS, USERNAME_TPSONLINE_BC, 
//                                                 PASSWORD_TPSONLINE_BC)
//                VALUES (NULL, NULL, " . $CONSIGNEE . ", NULL, NULL, NULL, NULL, 
//                        'CONS', NULL, NULL, 
//                        NULL)";
//        echo $SQL . '<br>';
//        $Execute = $conn->execute($SQL);
//        $ID_ORGANISASI = mysql_insert_id();
//    }

    $SQL = "SELECT NO_PLP, TGL_PLP
            FROM t_respon_plp_tujuan_v2_hdr
            WHERE ID = " . $ID . "";
    echo $SQL . '<br>';
    $QueryDetail = $conn->query($SQL);
    $QueryDetail->next();
    $NO_PLP = $QueryDetail->get("NO_PLP");
    $TGL_PLP = $QueryDetail->get("TGL_PLP");

    $SQL = "INSERT INTO t_cocostskms (ID, SERI, KD_KEMASAN, JUMLAH, ID_CONT_ASAL, NO_CONT_ASAL, BRUTO, NO_SEGEL, 
                                      KONDISI_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, 
                                      NO_POS_BC11, KD_ORG_CONSIGNEE, KD_TIMBUN_KAPAL, KD_TIMBUN, KD_PEL_MUAT, 
                                      KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN, 
                                      KD_CONT_STATUS_IN, KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_DOK_OUT, NO_DOK_OUT, 
                                      TGL_DOK_OUT, WK_OUT, KD_CONT_STATUS_OUT, KD_SARANA_ANGKUT_OUT, NO_POL_OUT, 
                                      KD_TPS_TUJUAN, KD_GUDANG_TUJUAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, 
                                      NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, WK_REKAM)
            VALUES (" . $ID_T_COCOSTSHDR . ", '" . $NEXT_SERI . "', " . $JNS_KMS . ", " . $JML_KMS . ", NULL, NULL, NULL, NULL, 
                    NULL, " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", NULL, NULL, 
                    NULL, NULL, NULL, NULL, NULL, 
                    NULL, NULL, '3', '" . $NO_PLP . "', '" . $TGL_PLP . "', NULL, 
                    NULL, NULL, NULL, NULL, NULL, 
                    NULL, NULL, NULL, NULL, NULL, 
                    NULL, NULL, NULL, NULL, 
                    NULL, NULL, NULL, NULL, NOW())";
    echo $SQL . '<br>';
    $Execute = $conn->execute($SQL);
    //INSERT INTO t_cocostskms END
}

function InsertKontainer($ID, $CONT, $ID_T_COCOSTSHDR) {
    global $CONF, $conn;
    $NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
    //add tag element
    $JNS_CONT = trim($CONT['JNS_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JNS_CONT']['_v'])) . "'";
    $NO_POS_BC11 = trim($CONT['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_POS_BC11']['_v'])) . "'";
    $CONSIGNEE = trim($CONT['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['CONSIGNEE']['_v'])) . "'";
    $NO_BL_AWB = trim($CONT['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($CONT['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";

    echo $NO_CONT . '<br>';

    $SQL = "INSERT INTO t_respon_plp_tujuan_v2_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, NO_POS_BC11, CONSIGNEE, NO_BL_AWB, TGL_BL_AWB)
            VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $NO_POS_BC11 . ", " . $CONSIGNEE . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ")";
    $Execute = $conn->execute($SQL);
    echo $SQL . '<br>';

    //INSERT INTO t_cocostscont BEGIN
    $SQL = "SELECT ID 
            FROM t_cocostscont
            WHERE ID = " . $ID_T_COCOSTSHDR . "
                  AND NO_CONT = " . $NO_CONT . "";
    echo $SQL . '<br>';
    $QueryDetail = $conn->query($SQL);
    if ($QueryDetail->size() == 0) {
        $SQL = "SELECT NO_PLP, TGL_PLP
            FROM t_respon_plp_tujuan_v2_hdr
            WHERE ID = " . $ID . "";
        echo $SQL . '<br>';
        $QueryDetail = $conn->query($SQL);
        $QueryDetail->next();
        $NO_PLP = $QueryDetail->get("NO_PLP");
        $TGL_PLP = $QueryDetail->get("TGL_PLP");

        $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_CONT_TIPE, KD_ISO_CODE, 
                                       TEMPERATURE, BRUTO, NO_SEGEL, KONDISI_SEGEL, NO_BL_AWB, TGL_BL_AWB, 
                                       NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, 
                                       KD_TIMBUN_KAPAL, KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, 
                                       KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN, KD_CONT_STATUS_IN, 
                                       KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, 
                                       WK_OUT, KD_CONT_STATUS_OUT, KD_SARANA_ANGKUT_OUT, NO_POL_OUT, 
                                       KD_TPS_TUJUAN, KD_GUDANG_TUJUAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, 
                                       NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, WK_REKAM)
            VALUES (" . $ID_T_COCOSTSHDR . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", NULL, NULL, 
                    NULL, NULL, NULL, NULL, NULL, NULL, 
                    NULL, NULL, NULL, NULL, 
                    NULL, NULL, NULL, NULL, NULL, 
                    '3', '" . $NO_PLP . "', '" . $TGL_PLP . "', NULL, NULL, 
                    NULL, NULL, NULL, NULL, NULL, 
                    NULL, NULL, NULL, NULL, 
                    NULL, NULL, NULL, NULL, 
                    NULL, NULL, NULL, NULL, NOW())";
        echo $SQL . '<br>';
        $Execute = $conn->execute($SQL);
    }
    //INSERT INTO t_cocostscont END
}

?>