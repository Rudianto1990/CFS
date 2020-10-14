<?php
set_time_limit(3600);
require_once("config.php");

$method = 'READGETDOKUMENPABEANPERMIT';
$KdAPRF = 'GETDOKUMENPABEANPERMIT';
$main = new main($CONF, $conn);
    $main->connect();

    //BEGIN
    $SQL = "SELECT a.ID, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('GetDokumenPabeanPermit_FASP')  AND a.FL_USED = '0' AND a.RESPONSE is not null order by a.WK_REKAM ASC limit 5";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) { 
        while ($Query->next()) {
            $ID_LOG = $Query->get("ID");
            $STR_DATA = $Query->get("RESPONSE");
            
            $xml = xml2ary($STR_DATA);
            if (count($xml) > 0) {
                $xml = $xml['DOCUMENT']['_c'];
                $countDOKPAB = 0;
                $countDOKPAB = count($xml['DOKPAB']);
                if ($countDOKPAB > 1) {
                    for ($c = 0; $c < $countDOKPAB; $c++) {
                        $DOKPAB = $xml['DOKPAB'][$c]['_c'];
                        InsertDOKPAB($DOKPAB, $ID_LOG);
                    }
                } elseif ($countDOKPAB == 1) {
                    $DOKPAB = $xml['DOKPAB']['_c'];
                    InsertDOKPAB($DOKPAB, $ID_LOG);
                }

                if($countDOKPAB > 0){
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

function InsertDOKPAB($DOKPAB, $ID_LOG) {		
    global $CONF, $conn;
    $header = $DOKPAB['HEADER']['_c'];
    $KD_DOK_INOUT = trim($header['KD_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_DOK_INOUT']['_v'])) . "'";
    $CAR = trim($header['CAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CAR']['_v'])) . "'";
    $KD_KPBC = trim($header['KD_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR']['_v'])) . "'";
    $NO_SPPB = trim($header['NO_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_DOK_INOUT']['_v'])) . "'";
    $TGL_SPPB = trim($header['TGL_DOK_INOUT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_DOK_INOUT']['_v'])) . "','%Y%m%d')";
    $NO_DAFTAR = trim($header['NO_DAFTAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_DAFTAR']['_v'])) . "'";
    $TGL_DAFTAR = trim($header['TGL_DAFTAR']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_DAFTAR']['_v'])) . "','%Y%m%d')";
    $KD_KANTOR_PENGAWAS = trim($header['KD_KANTOR_PENGAWAS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR_PENGAWAS']['_v'])) . "'";
    $KD_KANTOR_BONGKAR = trim($header['KD_KANTOR_BONGKAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR_BONGKAR']['_v'])) . "'";
    $NPWP_IMP = trim($header['NPWP_IMP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_IMP']['_v'])) . "'";
    $NAMA_IMP = trim($header['NM_IMP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_IMP']['_v'])) . "'";
    $ALAMAT_IMP = trim($header['AL_IMP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['AL_IMP']['_v'])) . "'";
    $NPWP_PPJK = trim($header['NPWP_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_PPJK']['_v'])) . "'";
    $NAMA_PPJK = trim($header['NM_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_PPJK']['_v'])) . "'";
    $ALAMAT_PPJK = trim($header['AL_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['AL_PPJK']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $BRUTO = trim($header['BRUTO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['BRUTO']['_v'])) . "'";
    $NETTO = trim($header['NETTO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NETTO']['_v'])) . "'";
    $GUDANG = trim($header['GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG']['_v'])) . "'";
    $STATUS_JALUR = trim($header['STATUS_JALUR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['STATUS_JALUR']['_v'])) . "'";
    $JML_CONT = trim($header['JML_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JML_CONT']['_v'])) . "'";
    $NO_BC11 = trim($header['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($header['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_BC11']['_v'])) . "','%Y%m%d')";
    $NO_POS_BC11 = trim($header['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_POS_BC11']['_v'])) . "'";
    $NO_BL_AWB = trim($header['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BL_AWB']['_v'])) . "'";
    $TG_BL_AWB = trim($header['TG_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TG_BL_AWB']['_v'])) . "','%Y%m%d')";
    $NO_MASTER_BL_AWB = trim($header['NO_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_MASTER_BL_AWB']['_v'])) . "'";
    $TGL_MASTER_BL_AWB = trim($header['TGL_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_MASTER_BL_AWB']['_v'])) . "','%Y%m%d')";
	$FL_SEGEL = trim($header['FL_SEGEL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['FL_SEGEL']['_v'])) . "'";

    echo $CAR . '<br>';
    $SQL = "SELECT CAR
            FROM t_permit_hdr
            WHERE CAR = " . $CAR . " 
                  AND KD_DOK_INOUT = " . $KD_DOK_INOUT . "";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, 
										  NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, ALAMAT_CONSIGNEE, 
										  NPWP_PPJK, NAMA_PPJK, ALAMAT_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, 
										  KD_GUDANG, JML_CONT, BRUTO, NETTO, NO_BC11, TGL_BC11, NO_POS_BC11, 
										  NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, KD_KANTOR_PENGAWAS, 
										  KD_KANTOR_BONGKAR, FL_SEGEL, STATUS_JALUR, KD_STATUS, TGL_STATUS,ID_LOG)
                VALUES (" . $CAR . "," . $KD_KPBC . ", " . $KD_DOK_INOUT . ", " . $NO_SPPB . ", " . $TGL_SPPB . ", 
						" . $NO_DAFTAR . ", " . $TGL_DAFTAR . ", " . $NPWP_IMP . ", " . $NAMA_IMP . ", " . $ALAMAT_IMP . ", 
						" . $NPWP_PPJK . ", " . $NAMA_PPJK . ", " . $ALAMAT_PPJK . ", " . $NM_ANGKUT . ", " . $NO_VOY_FLIGHT . ", 
						" . $GUDANG . ", " . $JML_CONT . ", " . $BRUTO . ", " . $NETTO . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", 
                        " . $NO_POS_BC11 . ", " . $NO_BL_AWB . ", " . $TG_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ",
						" . $KD_KANTOR_PENGAWAS . ", " . $KD_KANTOR_BONGKAR . ", " . $FL_SEGEL . ", " . $STATUS_JALUR . ", '100', NOW(),'".$ID_LOG."')";
        $Execute = $conn->execute($SQL);
        echo $SQL . '<br>';
        $ID = mysql_insert_id();

        if ($ID != '') {
            //DETIL KEMASAN DAN KONTAINER
            $detil = $DOKPAB['DETIL']['_c'];

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
