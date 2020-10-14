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
	$SQL = "SELECT a.ID, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('GetResponBatalPLPTujuan','ReceiveResponBatalPLPTujuan') and a.RESPONSE is not null order by a.WK_REKAM ASC limit 10";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $ID_LOG = $Query->get("ID");
            $STR_DATA = $Query->get("RESPONSE");

            $xml = xml2ary($STR_DATA);
            if (count($xml) > 0) {
                $xml = $xml['DOCUMENT']['_c'];
                $countPLP = count($xml['RESPON_BATAL']);
                if ($countPLP > 1) {
                    for ($c = 0; $c < $countPLP; $c++) {
                        $RESPONPLP = $xml['RESPON_BATAL'][$c]['_c'];
                        InsertPLPResponTujuan($RESPONPLP);
                    }
                } elseif ($countPLP == 1) {
                    $RESPONPLP = $xml['RESPON_BATAL']['_c'];
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
    $NO_PLP = trim($header['NO_PLP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_PLP']['_v'])) . "'";
    $TGL_PLP = trim($header['TGL_PLP']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_PLP']['_v'])) . "','%Y%m%d')";
    $NO_BATAL_PLP = trim($header['NO_BATAL_PLP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BATAL_PLP']['_v'])) . "'";
    $TGL_BATAL_PLP = trim($header['TGL_BATAL_PLP']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_BATAL_PLP']['_v'])) . "','%Y%m%d')";

    echo $NO_PLP . '-' . $TGL_PLP . '<br>';
    $SQL = "SELECT ID
            FROM t_respon_batal_plp_tujuan_hdr
            WHERE NO_BATAL_PLP = " . $NO_BATAL_PLP . " 
                  AND TGL_BATAL_PLP = " . $TGL_BATAL_PLP . "";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_respon_batal_plp_tujuan_hdr (KD_KPBC, KD_TPS_ASAL, KD_TPS,
                                                        NO_PLP, TGL_PLP, NO_BATAL_PLP, TGL_BATAL_PLP, KD_STATUS, 
                                                        TGL_STATUS)
                VALUES (" . $KD_KANTOR . ", " . $KD_TPS_ASAL . ", " . $KD_TPS . ", " . $NO_PLP . ", 
                        " . $TGL_PLP . ", " . $NO_BATAL_PLP . ", " . $TGL_BATAL_PLP . ",'100', NOW())";
        $Execute = $conn->execute($SQL);
        echo $SQL . '<br>';
        $ID = mysql_insert_id();

        if ($ID != '') {
            // INSERT INTO t_cocostshdr END
            //DETIL KEMASAN DAN KONTAINER
            $detil = $RESPONPLP['DETIL']['_c'];

            //KEMASAN
            $countKMS = count($detil['KMS']);
            if ($countKMS > 1) {
                for ($d = 0; $d < $countKMS; $d++) {
                    $KMS = $detil['KMS'][$d]['_c'];
                    InsertKemasan($ID, $KMS);
                }
            } else if ($countKMS == 1) {
                $KMS = $detil['KMS']['_c'];
                InsertKemasan($ID, $KMS);
            }

            //KONTAINER
            $countCONT = count($detil['CONT']);
            if ($countCONT > 1) {
                for ($d = 0; $d < $countCONT; $d++) {
                    $CONT = $detil['CONT'][$d]['_c'];
                    InsertKontainer($ID, $CONT);
                }
            } elseif ($countCONT == 1) {
                $CONT = $detil['CONT']['_c'];
                InsertKontainer($ID, $CONT);
            }
        }
    }
}

function InsertKemasan($ID, $KMS) {
    global $CONF, $conn;
    $JNS_KMS = trim($KMS['JNS_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['JNS_KMS']['_v'])) . "'";
    $JML_KMS = trim($KMS['JML_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['JML_KMS']['_v'])) . "'";
    $NO_BL_AWB = trim($KMS['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($KMS['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";
    //add tag element
//    $NO_POS_BC11 = trim($KMS['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_POS_BC11']['_v'])) . "'";
//    $CONSIGNEE = trim($KMS['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['CONSIGNEE']['_v'])) . "'";
    echo $JNS_KMS . '<br>';

    $SQL = "INSERT INTO t_respon_batal_plp_tujuan_kms (ID, KD_KEMASAN, JML_KMS, NO_BL_AWB, TGL_BL_AWB)
            VALUES (" . $ID . ", " . $JNS_KMS . ", " . $JML_KMS . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ")";
    $Execute = $conn->execute($SQL);
    echo $SQL . '<br>';
}

function InsertKontainer($ID, $CONT) {
    global $CONF, $conn;
    $NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";

    echo $NO_CONT . '<br>';

    $SQL = "INSERT INTO t_respon_batal_plp_tujuan_cont (ID, NO_CONT, KD_CONT_UKURAN)
            VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ")";
    $Execute = $conn->execute($SQL);
    echo $SQL . '<br>';
}

?>