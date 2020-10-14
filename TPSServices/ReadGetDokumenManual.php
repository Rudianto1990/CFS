<?php
set_time_limit(3600);
require_once("config.php");

$method = 'READGETDOKUMENMANUAL';
$KdAPRF = 'GETDOKUMENMANUAL';
$main = new main($CONF, $conn);
    $main->connect();

    //BEGIN
    $SQL = "SELECT a.ID, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('GetDokumenManual')  AND a.FL_USED = '0' AND a.RESPONSE is not null order by a.WK_REKAM ASC limit 5";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) { 
        while ($Query->next()) {
            $ID_LOG = $Query->get("ID");
            $STR_DATA = $Query->get("RESPONSE");
            
            $xml = xml2ary($STR_DATA);
            if (count($xml) > 0) {
                $xml = $xml['DOCUMENT']['_c'];
                $countMANUAL = 0;
                $countMANUAL = count($xml['MANUAL']);
                if ($countMANUAL > 1) {
                    for ($c = 0; $c < $countMANUAL; $c++) {
                        $MANUAL = $xml['MANUAL'][$c]['_c'];
                        InsertMANUAL($MANUAL, $ID_LOG);
                    }
                } elseif ($countMANUAL == 1) {
                    $MANUAL = $xml['MANUAL']['_c'];
                    InsertMANUAL($MANUAL, $ID_LOG);
                }

                if($countMANUAL > 0){
					echo 'sukses';
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
            
            echo '<hr>';
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

function InsertMANUAL($MANUAL, $ID_LOG) {		
    global $CONF, $conn;
    $header = $MANUAL['HEADER']['_c'];
    $CAR = trim($header['ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['ID']['_v'])) . "'";
    $KD_KPBC = trim($header['KD_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR']['_v'])) . "'";
    $KD_DOK_INOUT = trim($header['KD_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_DOK_INOUT']['_v'])) . "'";
    $NO_SPPB = trim($header['NO_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_DOK_INOUT']['_v'])) . "'";
    $TGL_SPPB = trim($header['TGL_DOK_INOUT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_DOK_INOUT']['_v'])) . "','%d/%m/%Y')";
    $NPWP_IMP = trim($header['ID_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['ID_CONSIGNEE']['_v'])) . "'";
    $NAMA_IMP = trim($header['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CONSIGNEE']['_v'])) . "'";
    $NPWP_PPJK = trim($header['NPWP_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_PPJK']['_v'])) . "'";
    $NAMA_PPJK = trim($header['NAMA_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_PPJK']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $GUDANG = trim($header['GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG']['_v'])) . "'";
    $JML_CONT = trim($header['JML_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JML_CONT']['_v'])) . "'";
    $NO_BC11 = trim($header['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($header['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_BC11']['_v'])) . "','%d/%m/%Y')";
    $NO_POS_BC11 = trim($header['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_POS_BC11']['_v'])) . "'";
    $NO_BL_AWB = trim($header['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BL_AWB']['_v'])) . "'";
    $TG_BL_AWB = trim($header['TG_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TG_BL_AWB']['_v'])) . "','%d/%m/%Y')";
    $FL_SEGEL = trim($header['FL_SEGEL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['FL_SEGEL']['_v'])) . "'";

    echo $CAR . '<br>';
    $SQL = "SELECT CAR
            FROM t_permit_hdr
            WHERE CAR = " . $CAR . " 
                  AND KD_DOK_INOUT = " . $KD_DOK_INOUT . "";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, 
                                          ID_CONSIGNEE, CONSIGNEE, NPWP_PPJK, NAMA_PPJK, NM_ANGKUT, 
                                          NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, NO_BC11, TGL_BC11, 
                                          NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, FL_SEGEL, KD_STATUS, TGL_STATUS,ID_LOG)
                VALUES (" . $CAR . "," . $KD_KPBC . ", " . $KD_DOK_INOUT . ", " . $NO_SPPB . ", " . $TGL_SPPB . ", 
                        " . $NPWP_IMP . ", " . $NAMA_IMP . ", " . $NPWP_PPJK . ", " . $NAMA_PPJK . ", " . $NM_ANGKUT . ", 
                        " . $NO_VOY_FLIGHT . ", " . $GUDANG . ", " . $JML_CONT . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", 
                        " . $NO_POS_BC11 . ", " . $NO_BL_AWB . ", " . $TG_BL_AWB . ", " . $FL_SEGEL . ", '100', NOW(),'".$ID_LOG."')";
        $Execute = $conn->execute($SQL);
        echo $SQL . '<br>';
        $ID = mysql_insert_id();

        if ($ID != '') {
            //DETIL KEMASAN DAN KONTAINER
            $detil = $MANUAL['DETIL']['_c'];

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
    $CAR_KMS = trim($KMS['ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['ID']['_v'])) . "'";
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
    $CAR_CONT = trim($CONT['ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['ID']['_v'])) . "'";
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
