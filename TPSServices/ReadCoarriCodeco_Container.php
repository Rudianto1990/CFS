<?php

set_time_limit(3600);
require_once("config.php");

$method = 'ReadCoarriCodeco_Container';
$KdAPRF = 'CoarriCodeco_Container';
$KodeDokBC = '1';
$sqlerror = '';
//$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
//$CheckFile = $main->CheckFile($filename);
//if (!$CheckFile) {
// $createFile = $main->createFile($filename);
$main->connect();

//BEGIN
$SQL = "SELECT a.ID, a.REQUEST, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('CoarriCodeco_Container') AND a.RESPONSE is not null
		AND a.FL_USED='0' order by a.WK_REKAM ASC limit 100";
$Query = $conn->query($SQL);
if ($Query->size() > 0) {
    while ($Query->next()) {
        $ID_LOG = $Query->get("ID");
        $STR_DATA = $Query->get("REQUEST");
		$RESPONSE = $Query->get("RESPONSE");

        $xml = xml2ary($STR_DATA);
	  if (stripos($RESPONSE, 'BERHASIL') !== FALSE) {
        if (count($xml) > 0) {
            $xml = $xml['DOCUMENT']['_c'];
            $countSPPB = 0;
            $countSPPB = count($xml['COCOCONT']);
            echo $ID_LOG . '<br>';
            if ($countSPPB > 1) {
                for ($c = 0; $c < $countSPPB; $c++) {
                    $cocostscont = $xml['COCOCONT'][$c]['_c'];
                    Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG);
                }
            } elseif ($countSPPB == 1) {
                $cocostscont = $xml['COCOCONT']['_c'];
                Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG);
            } else {
                $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

                $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

                $SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Data XML salah' WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

                if($Execute){
                  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                  $Execute = $conn->execute($SQL);
                }
            }
        } else {
            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Data tidak ada' WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            if($Execute){
              $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
              $Execute = $conn->execute($SQL);
            }
        }
	  } else {
			echo 'respon gagal<br>';
			$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Respon gagal' WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			if($Execute){
			  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			  $Execute = $conn->execute($SQL);
			}   
	  }
        #echo $SQL . '<br>';
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

function Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG) {
    global $CONF, $conn;
    $sqlerror = '';
    $header = $cocostscont['HEADER']['_c'];
    $KD_DOK = trim($header['KD_DOK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_DOK']['_v'])) . "'";
    $KD_TPS = trim($header['KD_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $CALL_SIGN = trim($header['CALL_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CALL_SIGN']['_v'])) . "'";
    $TGL_TIBA = trim($header['TGL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_TIBA']['_v'])) . "','%Y%m%d')";
    $KD_GUDANG = trim($header['KD_GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_GUDANG']['_v'])) . "'";
    $REF_NUMBER = trim($header['REF_NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['REF_NUMBER']['_v'])) . "'";

    $CONT = $cocostscont['DETIL']['_c']['CONT']['_c'];
    $NO_BC11 = trim($CONT['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($CONT['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BC11']['_v'])) . "','%Y%m%d')";

    switch ($header['KD_DOK']['_v']) {
        case "1": // COARRI DISCHARGE
            $KD_ASAL_BRG = '1';
            break;
        case "2": // COARRI LOADING
            $KD_ASAL_BRG = '3';
            break;
        case "3": // CODECO IMPOR
            $KD_ASAL_BRG = '1';
            break;
        case "4": // CODECO EKSPOR
            $KD_ASAL_BRG = '3';
            break;
        case "5": // GATE IN LINI 2 (IMPOR)
            $KD_ASAL_BRG = '2';
            break;
        case "6": // GATE OUT LINI 2 (IMPOR)
            $KD_ASAL_BRG = '2';
            break;
        case "7": // GATE IN LINI 2 (EKSPOR)
            $KD_ASAL_BRG = '4';
            break;
        case "8": // GATE OUT LINI 2 (EKSPOR)
            $KD_ASAL_BRG = '4';
            break;
    }
    //echo $REF_NUMBER . '<br>';
    $SQL = "SELECT A.ID
            FROM t_cocostshdr A
            WHERE A.KD_GUDANG = " . $KD_GUDANG . "
				  AND A.KD_ASAL_BRG = '" . $KD_ASAL_BRG . "'
                  AND A.NM_ANGKUT = " . $NM_ANGKUT . "
                  AND A.NO_VOY_FLIGHT = " . $NO_VOY_FLIGHT . "
                  AND A.TGL_TIBA = " . $TGL_TIBA . "";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_cocostshdr (KD_ASAL_BRG, KD_TPS, KD_GUDANG, NM_ANGKUT,
                                          CALL_SIGN, NO_VOY_FLIGHT, TGL_TIBA, NO_BC11, TGL_BC11, WK_REKAM)
                VALUES (" . $KD_ASAL_BRG . "," . $KD_TPS . ", " . $KD_GUDANG . ", " . $NM_ANGKUT . ",
                        " . $CALL_SIGN . ", " . $NO_VOY_FLIGHT . ", " . $TGL_TIBA . ", " . $NO_BC11 . ", " . $TGL_BC11 . ",
                        NOW());";
        $Execute = $conn->execute($SQL);
        if ($Execute) {
            $ID = mysql_insert_id();
        } else {
            $sqlerror = mysql_errno() . ": " . mysql_error().'; '.'Query Error: Cannot Insert t_cocostshdr; ' . $SQL;
			echo $sqlerror.'<hr>';
            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = 'UPDATE app_log_services_failed SET KETERANGAN = "' . $sqlerror . '" WHERE ID = "' . $ID_LOG . '"';
            $Execute = $conn->execute($SQL);
			
			if($Execute){
			  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			  $Execute = $conn->execute($SQL);
			}			
        }
    } else {
        $Query->next();
        $ID = $Query->get("ID");
    }
	$SQL = "select A.ID from t_permohonan_cfshdr A WHERE A.NAMA_KAPAL=".$NM_ANGKUT." AND A.NO_VOY_FLIGHT=".$NO_VOY_FLIGHT."
			AND A.TGL_TIBA=".$TGL_TIBA." AND A.NO_BC11=".$NO_BC11." AND A.TGL_BC11=".$TGL_BC11;
	$Query = $conn->query($SQL);
	if ($Query->size() != 0) {
		while ($Query->next()) {
			$ID_CFS = $Query->get("ID");
		}
	}else{
		$ID_CFS = '';
	}
    //echo $ID . '<br>';


    if ($ID != '') {
        $detil = $cocostscont['DETIL']['_c'];

        $countCONT = count($detil['CONT']);
        //echo $countCONT . '<br>';
        if ($countCONT > 1) {
            for ($d = 0; $d < $countCONT; $d++) {
                $CONT = $detil['CONT'][$d]['_c'];
                $return = InsertKontainer($ID, $CONT, $header['KD_DOK']['_v'], $ID_CFS);
                if ($return != 'true') {
                    $return = explode('|', $return);
                    $sqlerror .= $return[1];
                }
            }
        } elseif ($countCONT == 1) {
            $CONT = $detil['CONT']['_c'];
            $return = InsertKontainer($ID, $CONT, $header['KD_DOK']['_v'], $ID_CFS);
            if ($return != 'true') {
                $return = explode('|', $return);
                $sqlerror .= $return[1];
            }
        } else {
            $sqlerror = 'Data kontainer kosong;';
        }
        if ($sqlerror == '') {
            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);
			if($Execute){
			  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			  $Execute = $conn->execute($SQL);
			}			
			echo 'OK';
        } else {
            $responseerror = 'Query Error: Cannot Insert t_cocostscont; ' . $sqlerror;
			echo $responseerror;
            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = 'UPDATE app_log_services_failed SET KETERANGAN = "' . $responseerror . '" WHERE ID = "' . $ID_LOG . '"';
            $Execute = $conn->execute($SQL);
			if($Execute){
			  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			  $Execute = $conn->execute($SQL);
			}			
        }
    }
}

function InsertPelabuhan($PEL="") {
    global $CONF, $conn;
	if($PEL!=""){
		$SQL = "SELECT A.ID FROM reff_pelabuhan A WHERE A.ID = " . $PEL . "";
		$Query = $conn->query($SQL);
		if ($Query->size() == 0) {
			$SQL = "INSERT INTO reff_pelabuhan (ID) VALUES (" . $PEL . ");";
			$Execute = $conn->execute($SQL);
		}
	}
}

function InsertKontainer($ID, $CONT, $KD_DOK, $CFS="") {
    global $CONF, $conn;
    $NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
    $NO_SEGEL = trim($CONT['NO_SEGEL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_SEGEL']['_v'])) . "'";
    $JNS_CONT = trim($CONT['JNS_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JNS_CONT']['_v'])) . "'";
    $NO_BL_AWB = trim($CONT['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($CONT['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";
    $NO_MASTER_BL_AWB = trim($CONT['NO_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_MASTER_BL_AWB']['_v'])) . "'";
    $TGL_MASTER_BL_AWB = trim($CONT['TGL_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_MASTER_BL_AWB']['_v'])) . "','%Y%m%d')";
    $ID_CONSIGNEE = trim($CONT['ID_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['ID_CONSIGNEE']['_v'])) . "'";
    $CONSIGNEE = trim($CONT['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['CONSIGNEE']['_v'])) . "'";
    $BRUTO = trim($CONT['BRUTO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['BRUTO']['_v'])) . "'";
    $NO_BC11 = trim($CONT['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($CONT['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BC11']['_v'])) . "','%Y%m%d')";
    $NO_POS_BC11 = trim($CONT['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_POS_BC11']['_v'])) . "'";
    $KD_TIMBUN = trim($CONT['KD_TIMBUN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['KD_TIMBUN']['_v'])) . "'";
    $KD_DOK_INOUT = trim($CONT['KD_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['KD_DOK_INOUT']['_v'])) . "'";
    $NO_DOK_INOUT = trim($CONT['NO_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_DOK_INOUT']['_v'])) . "'";
    $TGL_DOK_INOUT = trim($CONT['TGL_DOK_INOUT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_DOK_INOUT']['_v'])) . "','%Y%m%d')";
    $WK_INOUT = trim($CONT['WK_INOUT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['WK_INOUT']['_v'])) . "','%Y%m%d%H%i%s')";
    $KD_SAR_ANGKUT_INOUT = trim($CONT['KD_SAR_ANGKUT_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['KD_SAR_ANGKUT_INOUT']['_v'])) . "'";
    $NO_POL = trim($CONT['NO_POL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_POL']['_v'])) . "'";
    $FL_CONT_KOSONG = trim($CONT['FL_CONT_KOSONG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['FL_CONT_KOSONG']['_v'])) . "'";
    $ISO_CODE = trim($CONT['ISO_CODE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['ISO_CODE']['_v'])) . "'";
    /* $PEL_MUAT = (trim($CONT['PEL_MUAT']['_v']) == "") ? "NULL" : "'" . strtoupper(trim($CONT['PEL_MUAT']['_v'])) . "'";
      $PEL_TRANSIT = (trim($CONT['PEL_TRANSIT']['_v']) == "") ? "NULL" : "'" . strtoupper(trim($CONT['PEL_TRANSIT']['_v'])) . "'";
      $PEL_BONGKAR = (trim($CONT['PEL_BONGKAR']['_v']) == "") ? "NULL" : "'" . strtoupper(trim($CONT['PEL_BONGKAR']['_v'])) . "'";
     */
	$PEL_MUAT = (trim($CONT['PEL_MUAT']['_v']) == "" || !ctype_upper(trim($CONT['PEL_MUAT']['_v']))) ? "NULL" : "'" . strtoupper(trim($CONT['PEL_MUAT']['_v'])) . "'";
	InsertPelabuhan($PEL_MUAT);
    $PEL_TRANSIT = (trim($CONT['PEL_TRANSIT']['_v']) == "" || !ctype_upper(trim($CONT['PEL_TRANSIT']['_v']))) ? "NULL" : "'" . strtoupper(trim($CONT['PEL_TRANSIT']['_v'])) . "'";
	InsertPelabuhan($PEL_TRANSIT);
    $PEL_BONGKAR = (trim($CONT['PEL_BONGKAR']['_v']) == "" || !ctype_upper(trim($CONT['PEL_BONGKAR']['_v']))) ? "NULL" : "'" . strtoupper(trim($CONT['PEL_BONGKAR']['_v'])) . "'";
	InsertPelabuhan($PEL_BONGKAR);
    $GUDANG_TUJUAN = trim($CONT['GUDANG_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['GUDANG_TUJUAN']['_v'])) . "'";
    $KODE_KANTOR = trim($CONT['KODE_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['KODE_KANTOR']['_v'])) . "'";
    $NO_DAFTAR_PABEAN = trim($CONT['NO_DAFTAR_PABEAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_DAFTAR_PABEAN']['_v'])) . "'";
    $TGL_DAFTAR_PABEAN = trim($CONT['TGL_DAFTAR_PABEAN']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_DAFTAR_PABEAN']['_v'])) . "','%Y%m%d')";
    $NO_SEGEL_BC = trim($CONT['NO_SEGEL_BC']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_SEGEL_BC']['_v'])) . "'";
    $TGL_SEGEL_BC = trim($CONT['TGL_SEGEL_BC']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_SEGEL_BC']['_v'])) . "','%Y%m%d')";
    $NO_IJIN_TPS = trim($CONT['NO_IJIN_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_IJIN_TPS']['_v'])) . "'";
    $TGL_IJIN_TPS = trim($CONT['TGL_IJIN_TPS']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_IJIN_TPS']['_v'])) . "','%Y%m%d')";
    //echo $NO_CONT . '<br>';


    $SQL = "SELECT A.ID 
            FROM t_cocostscont A
            WHERE A.ID = '" . $ID . "'
                  AND A.NO_CONT = " . $NO_CONT . "";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        if ($KD_DOK == '1') { // Discharge 
            $SQL = "UPDATE t_cocostscont SET KD_DOK_IN = " . $KD_DOK_INOUT . ", NO_DOK_IN = " . $NO_DOK_INOUT . ", TGL_DOK_IN = " . $TGL_DOK_INOUT . ", WK_IN = " . $WK_INOUT . ", KD_CONT_STATUS_IN = NULL, KD_SARANA_ANGKUT_IN = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_IN = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
        } elseif ($KD_DOK == '2') { // Loading
            $SQL = "UPDATE t_cocostscont SET KD_DOK_OUT = " . $KD_DOK_INOUT . ", NO_DOK_OUT = " . $NO_DOK_INOUT . ", TGL_DOK_OUT = " . $TGL_DOK_INOUT . ", WK_OUT = " . $WK_INOUT . ", KD_CONT_STATUS_OUT = NULL, KD_SARANA_ANGKUT_OUT = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_OUT = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
        } elseif ($KD_DOK == '3') { // Gate Out Lini 1
            $SQL = "UPDATE t_cocostscont SET KD_DOK_OUT = " . $KD_DOK_INOUT . ", NO_DOK_OUT = " . $NO_DOK_INOUT . ", TGL_DOK_OUT = " . $TGL_DOK_INOUT . ", WK_OUT = " . $WK_INOUT . ", KD_CONT_STATUS_OUT = NULL, KD_SARANA_ANGKUT_OUT = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_OUT = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='600', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        } elseif ($KD_DOK == '4') { // CODECO EKSPOR
            $SQL = "UPDATE t_cocostscont SET KD_DOK_IN = " . $KD_DOK_INOUT . ", NO_DOK_IN = " . $NO_DOK_INOUT . ", TGL_DOK_IN = " . $TGL_DOK_INOUT . ", WK_IN = " . $WK_INOUT . ", KD_CONT_STATUS_IN = NULL, KD_SARANA_ANGKUT_IN = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_IN = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
        } elseif ($KD_DOK == '5') { // Gate In Lini 2
            $SQL = "UPDATE t_cocostscont SET KD_DOK_IN = " . $KD_DOK_INOUT . ", NO_DOK_IN = " . $NO_DOK_INOUT . ", TGL_DOK_IN = " . $TGL_DOK_INOUT . ", WK_IN = " . $WK_INOUT . ", KD_CONT_STATUS_IN = NULL, KD_SARANA_ANGKUT_IN = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_IN = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='700', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        } elseif ($KD_DOK == '6') { // Gate Out Lini 2
            $SQL = "UPDATE t_cocostscont SET KD_DOK_OUT = " . $KD_DOK_INOUT . ", NO_DOK_OUT = " . $NO_DOK_INOUT . ", TGL_DOK_OUT = " . $TGL_DOK_INOUT . ", WK_OUT = " . $WK_INOUT . ", KD_CONT_STATUS_OUT = NULL, KD_SARANA_ANGKUT_OUT = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_OUT = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='800', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        }
        echo $SQL . '<hr>';
    } else { 
        if ($KD_DOK == '1') { // Discharge 
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
                                               NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
                                               KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN,
                                               KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
                                               NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
        } elseif ($KD_DOK == '2') { // Loading
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT,
				KD_SARANA_ANGKUT_OUT, NO_POL_OUT, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
        } elseif ($KD_DOK == '3') { // Gate Out Lini 1
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT,
				KD_SARANA_ANGKUT_OUT, NO_POL_OUT, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='600', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        } elseif ($KD_DOK == '4') { // CODECO EKSPOR
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN,
				KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
        } elseif ($KD_DOK == '5') { // Gate In Lini 2
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN,
				KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='700', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        } elseif ($KD_DOK == '6') { // Gate Out Lini 2
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT,
				KD_SARANA_ANGKUT_OUT, NO_POL_OUT, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='800', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        }
    }

    if ($SQL != '') {
        $Execute = $conn->execute($SQL);
        if (!$Execute) {
			$SQL=mysql_errno() . ": " . mysql_error(). '; '. $SQL;
            echo 'Cannot execute query t_cocostscont. ' . $SQL . '<hr>';
        }else{
			if ($CFS != ""){
				$Execute = $conn->execute($sqlupdateCont);
			}
		}
    }
    return ($Execute != '') ? 'true' : 'false|' . $SQL;
}

?>
