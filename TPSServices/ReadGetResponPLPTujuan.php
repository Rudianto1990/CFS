<?php

set_time_limit(3600);
require_once("config.php");

$method = 'READGETRESPONPLPTUJUAN';
$KdAPRF = 'GETRESPLPTUJUAN';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    #$createFile = $main->createFile($filename);
    $main->connect();

    //BEGIN
    $SQL = "SELECT ID, STR_DATA
            FROM mailbox A 
            WHERE A.KD_STATUS = '100'
                  AND KD_APRF = '" . $KdAPRF . "'
            LIMIT 0,10";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $ID_MAILBOX = $Query->get("ID");
            $STR_DATA = $Query->get("STR_DATA");

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
            }
            $SQL = "UPDATE mailbox SET KD_STATUS = '200', TGL_STATUS = NOW()
                    WHERE ID = '" . $ID_MAILBOX . "'";
            $Execute = $conn->execute($SQL);
            echo $SQL . '<br>';
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

    echo $NO_PLP . '-' . $TGL_PLP . '<br>';
    $SQL = "SELECT ID
            FROM t_respon_plp_tujuan_hdr
            WHERE NO_PLP = " . $NO_PLP . " 
                  AND TGL_PLP = " . $TGL_PLP . "";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_respon_plp_tujuan_hdr (KD_KPBC, KD_TPS_ASAL, KD_TPS_TUJUAN, KD_GUDANG_TUJUAN, 
                                                     NO_PLP, TGL_PLP, NM_ANGKUT, 
                                                     NO_VOY_FLIGHT, CALL_SIGN, TGL_TIBA, TGL_STATUS)
                VALUES (" . $KD_KANTOR . ", " . $KD_TPS_ASAL . ", " . $KD_TPS . ", " . $GUDANG_TUJUAN . ", " . $NO_PLP . ", 
                        " . $TGL_PLP . ", " . $NM_ANGKUT . ", " . $NO_VOY_FLIGHT . ", 
                        " . $CALL_SIGN . ", " . $TGL_TIBA . ", NOW())";
        $Execute = $conn->execute($SQL);
        echo $SQL . '<br>';
        $ID = mysql_insert_id();

        if ($ID != '') {
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
    echo $JNS_KMS . '<br>';

    $SQL = "INSERT INTO t_respon_plp_tujuan_kms (ID, KD_KEMASAN, JML_KMS, NO_BL_AWB, TGL_BL_AWB)
            VALUES (" . $ID . ", " . $JNS_KMS . ", " . $JML_KMS . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ")";
    $Execute = $conn->execute($SQL);
    echo $SQL . '<br>';
}

function InsertKontainer($ID, $CONT) {
    global $CONF, $conn;
    $NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
    echo $NO_CONT . '<br>';

    $SQL = "INSERT INTO t_respon_plp_tujuan_cont (ID, NO_CONT, KD_CONT_UKURAN)
            VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ")";
    $Execute = $conn->execute($SQL);
    echo $SQL . '<br>';
}

?>