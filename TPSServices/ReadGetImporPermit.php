<?php

set_time_limit(3600);
require_once("config.php");

$method = 'READGETIMPPERMIT';
$KdAPRF = 'GETIMPPERMIT';
$KodeDokBC = '1';
//$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
//$CheckFile = $main->CheckFile($filename);
//if (!$CheckFile) {
   // $createFile = $main->createFile($filename);
    $main->connect();

    //BEGIN
    $SQL = "SELECT a.ID, a.RESPONSE FROM app_log_services a WHERE a.METHOD in 
	('GetImporPermit','GetImpor_Sppb','GetImporPermit_FASP','ReceiveImporPermit','ReceiveImpor_Sppb','ReceiveImporPermit_FASP') 
	AND a.FL_USED = '0' AND a.RESPONSE is not null order by a.WK_REKAM ASC limit 5";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) { 
        while ($Query->next()) {
            $ID_LOG = $Query->get("ID");
            $STR_DATA = $Query->get("RESPONSE");
            
            $xml = xml2ary($STR_DATA);
            if (count($xml) > 0) {
                $xml = $xml['DOCUMENT']['_c'];
                $countSPPB = 0;
                $countSPPB = count($xml['SPPB']);
                if ($countSPPB > 1) {
                    for ($c = 0; $c < $countSPPB; $c++) {
                        $SPPB = $xml['SPPB'][$c]['_c'];
                        InsertSPPB($KodeDokBC, $SPPB, $ID_LOG);
                    }
                } elseif ($countSPPB == 1) {
                    $SPPB = $xml['SPPB']['_c'];
                    InsertSPPB($KodeDokBC, $SPPB, $ID_LOG);
                }

                if($countSPPB > 0){
                    $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);

                    $SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);

                    if($Execute){
                        $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                        $Execute = $conn->execute($SQL);                    
                    }
                }else{
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
            
            echo $SQL . '<br>';
        }
    } else {
        echo 'data tidak ada.';
    }
    //END

    $main->connect(false);
    //$main->removeFile($filename);
//} else {
  //  echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
//}

function InsertSPPB($KodeDokBC, $SPPB, $ID_LOG) {		
    global $CONF, $conn;
    $header = $SPPB['HEADER']['_c'];
    $CAR = trim($header['CAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CAR']['_v'])) . "'";
    $NO_SPPB = trim($header['NO_SPPB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_SPPB']['_v'])) . "'";
    $TGL_SPPB = trim($header['TGL_SPPB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_SPPB']['_v'])) . "','%m/%d/%Y')";
    $KD_KPBC = trim($header['KD_KPBC']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KPBC']['_v'])) . "'";
    $NO_PIB = trim($header['NO_PIB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_PIB']['_v'])) . "'";
    $TGL_PIB = trim($header['TGL_PIB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_PIB']['_v'])) . "','%m/%d/%Y')";
    $NPWP_IMP = trim($header['NPWP_IMP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_IMP']['_v'])) . "'";
    $NAMA_IMP = trim($header['NAMA_IMP']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($header['NAMA_IMP']['_v']))) . "'";
    $ALAMAT_IMP = trim($header['ALAMAT_IMP']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($header['ALAMAT_IMP']['_v']))) . "'";
    $NPWP_PPJK = trim($header['NPWP_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_PPJK']['_v'])) . "'";
    $NAMA_PPJK = trim($header['NAMA_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_PPJK']['_v'])) . "'";
    $ALAMAT_PPJK = trim($header['ALAMAT_PPJK']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($header['ALAMAT_PPJK']['_v']))) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $BRUTO = trim($header['BRUTO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['BRUTO']['_v'])) . "'";
    $NETTO = trim($header['NETTO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NETTO']['_v'])) . "'";
    $GUDANG = trim($header['GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG']['_v'])) . "'";
    $STATUS_JALUR = trim($header['STATUS_JALUR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['STATUS_JALUR']['_v'])) . "'";
    $JML_CONT = trim($header['JML_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JML_CONT']['_v'])) . "'";
    $NO_BC11 = trim($header['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($header['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_BC11']['_v'])) . "','%m/%d/%Y')";
    $NO_POS_BC11 = trim($header['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_POS_BC11']['_v'])) . "'";
    $NO_BL_AWB = trim($header['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BL_AWB']['_v'])) . "'";
    $TG_BL_AWB = trim($header['TG_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TG_BL_AWB']['_v'])) . "','%m/%d/%Y')";
    $NO_MASTER_BL_AWB = trim($header['NO_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_MASTER_BL_AWB']['_v'])) . "'";
    $TG_MASTER_BL_AWB = trim($header['TG_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TG_MASTER_BL_AWB']['_v'])) . "','%m/%d/%Y')";

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
                                          FL_KARANTINA, KD_STATUS, TGL_STATUS,ID_LOG)
                VALUES (" . $CAR . "," . $KD_KPBC . ", '" . $KodeDokBC . "', " . $NO_SPPB . ", " . $TGL_SPPB . ", 
                        " . $NO_PIB . ", " . $TGL_PIB . ", " . $NPWP_IMP . ", " . $NAMA_IMP . ", 
                        " . $ALAMAT_IMP . ", " . $NPWP_PPJK . ", " . $NAMA_PPJK . ", " . $ALAMAT_PPJK . ", " . $NM_ANGKUT . ", 
                        " . $NO_VOY_FLIGHT . ", " . $GUDANG . ", " . $JML_CONT . ", " . $BRUTO . ", " . $NETTO . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", 
                        " . $NO_POS_BC11 . ", " . $NO_BL_AWB . ", " . $TG_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TG_MASTER_BL_AWB . ", 
                        NULL, NULL, NULL, " . $STATUS_JALUR . ", 
                        NULL, '100', NOW(),'".$ID_LOG."')";
        $Execute = $conn->execute($SQL);
        echo $SQL . '<br>';
        $ID = mysql_insert_id();

        if ($ID != '') {
            //DETIL KEMASAN DAN KONTAINER
            $detil = $SPPB['DETIL']['_c'];

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
    $JNS_MUAT = trim($CONT['JNS_MUAT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JNS_MUAT']['_v'])) . "'";
    echo $NO_CONT . '<br>';

    $SQL = "INSERT INTO t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS)
            VALUES (" . $ID . ", " . $NO_CONT . ", " . $SIZE . ", " . $JNS_MUAT . ")";
    $Execute = $conn->execute($SQL);
    echo $SQL . '<br>';
}

?>
