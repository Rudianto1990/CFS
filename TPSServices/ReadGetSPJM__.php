<?php

set_time_limit(3600);
require_once("config.php");

$method = 'READGETSPJM';
$KdAPRF = 'GETSPJM';
$KodeDokBC = '19';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
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
                $countSPJM = count($xml['SPJM']);
                if ($countSPJM > 1) {
                    for ($c = 0; $c < $countSPJM; $c++) {
                        $SPJM = $xml['SPJM'][$c]['_c'];
                        InsertSPJM($KodeDokBC, $SPJM);
                    }
                } elseif ($countSPJM == 1) {
                    $SPJM = $xml['SPJM']['_c'];
                    InsertSPJM($KodeDokBC, $SPJM);
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

function InsertSPJM($KodeDokBC, $SPJM) {
    global $CONF, $conn;
    $header = $SPJM['HEADER']['_c'];

    $CAR = trim($header['CAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CAR']['_v'])) . "'";
    $KD_KANTOR = trim($header['KD_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR']['_v'])) . "'";
    $NO_PIB = trim($header['NO_PIB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_PIB']['_v'])) . "'";
    $TGL_PIB = trim($header['TGL_PIB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_PIB']['_v'])) . "','%m/%d/%Y')";
    $NPWP_IMP = trim($header['NPWP_IMP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_IMP']['_v'])) . "'";
    $NAMA_IMP = trim($header['NAMA_IMP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_IMP']['_v'])) . "'";
    $NPWP_PPJK = trim($header['NPWP_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_PPJK']['_v'])) . "'";
    $NAMA_PPJK = trim($header['NAMA_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_PPJK']['_v'])) . "'";
    $GUDANG = trim($header['GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG']['_v'])) . "'";
    $JML_CONT = trim($header['JML_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JML_CONT']['_v'])) . "'";
    $NO_BC11 = trim($header['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($header['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_BC11']['_v'])) . "','%m/%d/%Y')";
    $NO_POS_BC11 = trim($header['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_POS_BC11']['_v'])) . "'";
    $FL_KARANTINA = trim($header['FL_KARANTINA']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['FL_KARANTINA']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";

    echo $CAR . '<br>';
    $SQL = "SELECT CAR
            FROM t_permit_hdr
            WHERE CAR = " . $CAR . " 
                  AND KD_DOK_INOUT = '" . $KodeDokBC . "'";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, 
                                          NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, 
                                          ALAMAT_CONSIGNEE, NPWP_PPJK, NAMA_PPJK, ALAMAT_PPJK, NM_ANGKUT, 
                                          NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, BRUTO, NETTO, NO_BC11, TGL_BC11, 
                                          NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, 
                                          KD_KANTOR_PENGAWAS, KD_KANTOR_BONGKAR, FL_SEGEL, STATUS_JALUR, 
                                          FL_KARANTINA, KD_STATUS, TGL_STATUS)
                VALUES (" . $CAR . "," . $KD_KANTOR . ", '" . $KodeDokBC . "', NULL, NULL, 
                        " . $NO_PIB . ", " . $TGL_PIB . ", " . $NPWP_IMP . ", " . $NAMA_IMP . ", 
                        NULL, " . $NPWP_PPJK . ", " . $NAMA_PPJK . ", NULL, " . $NM_ANGKUT . ", 
                        " . $NO_VOY_FLIGHT . ", " . $GUDANG . ", " . $JML_CONT . ", NULL, NULL, " . $NO_BC11 . ", " . $TGL_BC11 . ", 
                        " . $NO_POS_BC11 . ", NULL, NULL, NULL, NULL, 
                        NULL, NULL, NULL, NULL, 
                        " . $FL_KARANTINA . ", '100', NOW())";
        $Execute = $conn->execute($SQL);
        echo $SQL . '<br>';
        $ID = mysql_insert_id();

        if ($ID != '') {
            //DETIL KEMASAN DAN KONTAINER
            $detil = $SPJM['DETIL']['_c'];

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
    $CAR_KMS = trim($KMS['CAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['CAR']['_v'])) . "'";
    $JNS_KMS = trim($KMS['JNS_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['JNS_KMS']['_v'])) . "'";
    $MERK_KMS = trim($KMS['MERK_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['MERK_KMS']['_v'])) . "'";
    $JML_KMS = trim($KMS['JML_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['JML_KMS']['_v'])) . "'";
    echo $JNS_KMS . '<br>';

    $SQL = "INSERT INTO t_permit_kms (ID, JNS_KMS, MERK_KMS, JML_KMS)
            VALUES (" . $ID . ", " . $JNS_KMS . ", " . $MERK_KMS . ", " . $JML_KMS . ")";
    $Execute = $conn->execute($SQL);
    echo $SQL . '<br>';
}

function InsertKontainer($ID, $CONT) {
    global $CONF, $conn;
    $CAR_CONT = trim($CONT['CAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['CAR']['_v'])) . "'";
    $NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $SIZE = trim($CONT['SIZE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['SIZE']['_v'])) . "'";
    echo $NO_CONT . '<br>';

    $SQL = "INSERT INTO t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS)
            VALUES (" . $ID . ", " . $NO_CONT . ", " . $SIZE . ", NULL)";
    $Execute = $conn->execute($SQL);
    echo $SQL . '<br>';
}

?>