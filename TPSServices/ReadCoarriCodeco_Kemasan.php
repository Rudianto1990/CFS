<?php

set_time_limit(3600);
require_once("config.php");

$method = 'ReadCoarriCodeco_Kemasan';
$KdAPRF = 'CoarriCodeco_Kemasan';
$KodeDokBC = '1';
$sqlerror='';
$main = new main($CONF, $conn);
  $main->connect();

  //BEGIN
  $SQL = "SELECT a.ID, a.REQUEST, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('CoarriCodeco_Kemasan') AND a.RESPONSE is not null
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
			$countSPPB = count($xml['COCOKMS']);
			echo $ID_LOG . '<br>';
			if ($countSPPB > 1) {
			  for ($c = 0; $c < $countSPPB; $c++) {
				$cocostskms = $xml['COCOKMS'][$c]['_c'];
				Insertcocostskms($KodeDokBC, $cocostskms, $ID_LOG);
			  }
			} elseif ($countSPPB == 1) {
			  $cocostskms = $xml['COCOKMS']['_c'];
			  Insertcocostskms($KodeDokBC, $cocostskms, $ID_LOG);
			}else{
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
		  }else{
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

function Insertcocostskms($KodeDokBC, $cocostskms, $ID_LOG) {
    global $CONF, $conn;
	$sqlerror='';
    $header = $cocostskms['HEADER']['_c'];
    $KD_DOK = trim($header['KD_DOK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_DOK']['_v'])) . "'";
    $KD_TPS = trim($header['KD_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $CALL_SIGN = trim($header['CALL_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CALL_SIGN']['_v'])) . "'";
    $TGL_TIBA = trim($header['TGL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_TIBA']['_v'])) . "','%Y%m%d')";
    $KD_GUDANG = trim($header['KD_GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_GUDANG']['_v'])) . "'";
    $REF_NUMBER = trim($header['REF_NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['REF_NUMBER']['_v'])) . "'";

    $KMS = $cocostskms['DETIL']['_c']['KMS']['_c'];
	$NO_BC11 = trim($KMS['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_BC11']['_v'])) . "'";
	$TGL_BC11 = trim($KMS['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_BC11']['_v'])) . "','%Y%m%d')";

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
    #echo $REF_NUMBER . '<br>';
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
                        " . $CALL_SIGN . ", " . $NO_VOY_FLIGHT . ", " . $TGL_TIBA . ", " . $NO_BC11 . ", " . $TGL_BC11 . ",NOW());";
        $Execute = $conn->execute($SQL);
		if($Execute!=''){
			$ID = mysql_insert_id();
			echo $ID . '<br>';
		}else{
			$sqlerror=mysql_errno() . ": " . mysql_error().'; '.'Query Error: Cannot Insert t_cocostshdr; '.$SQL;
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
	}else{
        $Query->next();
        $ID = $Query->get("ID");
    }
	if ($ID != '') {
		$detil = $cocostskms['DETIL']['_c'];

		$countKMS = count($detil['KMS']);
		echo $countKMS.'<br>';
		if ($countKMS > 1) {
			for ($d = 0; $d < $countKMS; $d++) {
				$KMS = $detil['KMS'][$d]['_c'];
				$return = InsertKemasan($ID, $KMS, $header['KD_DOK']['_v']);
				if($return!='true'){
					$return = explode('|',$return);
					$sqlerror .= $return[1];
				}
			}
		} elseif ($countKMS == 1) {
			$KMS = $detil['KMS']['_c'];
			$return = InsertKemasan($ID, $KMS, $header['KD_DOK']['_v']);
			if($return!='true'){
				$return = explode('|',$return);
				$sqlerror .= $return[1];
			}
		}else{
			$sqlerror='Data kemasan kosong;';
		}
		if($sqlerror==''){
			$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);
			echo 'OK';

			if($Execute){
			$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);
			}
		}else{
			$responseerror='Query Error: Cannot Insert t_cocostskms; '. $sqlerror;
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

function InsertKemasan($ID, $KMS, $KD_DOK) {
    global $CONF, $conn;
	$NO_BL_AWB = trim($KMS['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_BL_AWB']['_v'])) . "'";
	$TGL_BL_AWB = trim($KMS['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";
	$NO_MASTER_BL_AWB = trim($KMS['NO_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_MASTER_BL_AWB']['_v'])) . "'";
	$TGL_MASTER_BL_AWB = trim($KMS['TGL_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_MASTER_BL_AWB']['_v'])) . "','%Y%m%d')";
	$ID_CONSIGNEE = trim($KMS['ID_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['ID_CONSIGNEE']['_v'])) . "'";
	$CONSIGNEE = trim($KMS['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($KMS['CONSIGNEE']['_v']))) . "'";
	$BRUTO = trim($KMS['BRUTO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['BRUTO']['_v'])) . "'";
	$NO_BC11 = trim($KMS['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_BC11']['_v'])) . "'";
	$TGL_BC11 = trim($KMS['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_BC11']['_v'])) . "','%Y%m%d')";
	$NO_POS_BC11 = trim($KMS['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_POS_BC11']['_v'])) . "'";
	$CONT_ASAL = trim($KMS['CONT_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['CONT_ASAL']['_v'])) . "'";
	//$SERI_KEMAS = trim($KMS['SERI_KEMAS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['SERI_KEMAS']['_v'])) . "'";
	$KD_KEMAS = trim($KMS['KD_KEMAS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['KD_KEMAS']['_v'])) . "'";
	$JML_KEMAS = trim($KMS['JML_KEMAS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['JML_KEMAS']['_v'])) . "'";
	$KD_TIMBUN = trim($KMS['KD_TIMBUN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['KD_TIMBUN']['_v'])) . "'";
	$KD_DOK_INOUT = trim($KMS['KD_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['KD_DOK_INOUT']['_v'])) . "'";
	$NO_DOK_INOUT = trim($KMS['NO_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_DOK_INOUT']['_v'])) . "'";
	$TGL_DOK_INOUT = trim($KMS['TGL_DOK_INOUT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_DOK_INOUT']['_v'])) . "','%Y%m%d')";
	$WK_INOUT = trim($KMS['WK_INOUT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['WK_INOUT']['_v'])) . "','%Y%m%d%H%i%s')";
	$KD_SAR_ANGKUT_INOUT = trim($KMS['KD_SAR_ANGKUT_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['KD_SAR_ANGKUT_INOUT']['_v'])) . "'";
	$NO_POL = trim($KMS['NO_POL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_POL']['_v'])) . "'";
	#gunakan ctype_upper() untuk validasi inputan hanya huruf besar
	$PEL_MUAT = (trim($KMS['PEL_MUAT']['_v']) == "" || !ctype_upper(trim($KMS['PEL_MUAT']['_v']))) ? "NULL" : "'" . strtoupper(trim($KMS['PEL_MUAT']['_v'])) . "'";
	InsertPelabuhan($PEL_MUAT);
	$PEL_TRANSIT = (trim($KMS['PEL_TRANSIT']['_v']) == "" || !ctype_upper(trim($KMS['PEL_TRANSIT']['_v']))) ? "NULL" : "'" . strtoupper(trim($KMS['PEL_TRANSIT']['_v'])) . "'";
	InsertPelabuhan($PEL_TRANSIT);
	$PEL_BONGKAR = (trim($KMS['PEL_BONGKAR']['_v']) == "" || !ctype_upper(trim($KMS['PEL_BONGKAR']['_v']))) ? "NULL" : "'" . strtoupper(trim($KMS['PEL_BONGKAR']['_v'])) . "'";
	InsertPelabuhan($PEL_BONGKAR);
	$GUDANG_TUJUAN = trim($KMS['GUDANG_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['GUDANG_TUJUAN']['_v'])) . "'";
	$KODE_KANTOR = trim($KMS['KODE_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['KODE_KANTOR']['_v'])) . "'";
	$NO_DAFTAR_PABEAN = trim($KMS['NO_DAFTAR_PABEAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_DAFTAR_PABEAN']['_v'])) . "'";
	$TGL_DAFTAR_PABEAN = trim($KMS['TGL_DAFTAR_PABEAN']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_DAFTAR_PABEAN']['_v'])) . "','%Y%m%d')";
	$NO_SEGEL_BC = trim($KMS['NO_SEGEL_BC']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_SEGEL_BC']['_v'])) . "'";
	$TGL_SEGEL_BC = trim($KMS['TGL_SEGEL_BC']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_SEGEL_BC']['_v'])) . "','%Y%m%d')";
	$NO_IJIN_TPS = trim($KMS['NO_IJIN_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($KMS['NO_IJIN_TPS']['_v'])) . "'";
	$TGL_IJIN_TPS = trim($KMS['TGL_IJIN_TPS']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($KMS['TGL_IJIN_TPS']['_v'])) . "','%Y%m%d')";
    #echo $SERI_KEMAS . ''.$NO_BC11.''.$TGL_BC11.'<br>';

    $SQL = "SELECT A.ID 
            FROM t_cocostskms A
            WHERE A.ID = '" . $ID . "'
                  AND A.NO_CONT_ASAL = " . $CONT_ASAL . " 
				  AND A.NO_BL_AWB = " . $NO_BL_AWB . "
				  AND A.TGL_BL_AWB = " . $TGL_BL_AWB . "";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        if ($KD_DOK == '1') { // Discharge 
            $SQL = "UPDATE t_cocostskms SET KD_DOK_IN = " . $KD_DOK_INOUT . ", NO_DOK_IN = " . $NO_DOK_INOUT . ", TGL_DOK_IN = " . $TGL_DOK_INOUT . ", WK_IN = " . $WK_INOUT . ", KD_CONT_STATUS_IN = NULL, KD_SARANA_ANGKUT_IN = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_IN = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT_ASAL = " . $CONT_ASAL . " 
						  AND NO_BL_AWB = " . $NO_BL_AWB . "
						  AND TGL_BL_AWB = " . $TGL_BL_AWB . "";
        } elseif ($KD_DOK == '3') { // Gate Out Lini 1
            $SQL = "UPDATE t_cocostskms SET KD_DOK_OUT = " . $KD_DOK_INOUT . ", NO_DOK_OUT = " . $NO_DOK_INOUT . ", TGL_DOK_OUT = " . $TGL_DOK_INOUT . ", WK_OUT = " . $WK_INOUT . ", KD_CONT_STATUS_OUT = NULL, KD_SARANA_ANGKUT_OUT = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_OUT = " . $NO_POL . ", KD_GUDANG_TUJUAN = " . $GUDANG_TUJUAN . ", NO_DAFTAR_PABEAN = " . $NO_DAFTAR_PABEAN . ", TGL_DAFTAR_PABEAN = " . $TGL_DAFTAR_PABEAN . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT_ASAL = " . $CONT_ASAL . " 
						  AND NO_BL_AWB = " . $NO_BL_AWB . "
						  AND TGL_BL_AWB = " . $TGL_BL_AWB . "";
        } elseif ($KD_DOK == '5') { // Gate In Lini 2
            $SQL = "UPDATE t_cocostskms SET KD_DOK_IN = " . $KD_DOK_INOUT . ", NO_DOK_IN = " . $NO_DOK_INOUT . ", TGL_DOK_IN = " . $TGL_DOK_INOUT . ", WK_IN = " . $WK_INOUT . ", KD_CONT_STATUS_IN = NULL, KD_SARANA_ANGKUT_IN = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_IN = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT_ASAL = " . $CONT_ASAL . " 
						  AND NO_BL_AWB = " . $NO_BL_AWB . "
						  AND TGL_BL_AWB = " . $TGL_BL_AWB . "";
        } elseif ($KD_DOK == '6') { // Gate Out Lini 2
            $SQL = "UPDATE t_cocostskms SET KD_DOK_OUT = " . $KD_DOK_INOUT . ", NO_DOK_OUT = " . $NO_DOK_INOUT . ", TGL_DOK_OUT = " . $TGL_DOK_INOUT . ", WK_OUT = " . $WK_INOUT . ", KD_CONT_STATUS_OUT = NULL, KD_SARANA_ANGKUT_OUT = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_OUT = " . $NO_POL . ", KD_GUDANG_TUJUAN = " . $GUDANG_TUJUAN . ", NO_DAFTAR_PABEAN = " . $NO_DAFTAR_PABEAN . ", TGL_DAFTAR_PABEAN = " . $TGL_DAFTAR_PABEAN . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT_ASAL = " . $CONT_ASAL . " 
						  AND NO_BL_AWB = " . $NO_BL_AWB . "
						  AND TGL_BL_AWB = " . $TGL_BL_AWB . "";
        }
        echo $SQL . '<hr>';
    } else {
		$SQLSERI = "SELECT IFNULL(MAX(SERI)+1,1) AS SERI FROM t_cocostskms WHERE ID = '" . $ID . "'";
		$Queryseri = $conn->query($SQLSERI);
		$Queryseri->next();
		$SERI = $Queryseri->get("SERI");
		if ($SERI == '') {
			$SERI = 1;
		}

		if (($KD_DOK=='1') || ($KD_DOK=='5')) {
			$SQL = "INSERT INTO t_cocostskms (ID, SERI, KD_KEMASAN, JUMLAH, NO_CONT_ASAL, BRUTO,
					NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
					KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN,
					KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
					NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, WK_REKAM)
					VALUES (" . $ID . ", " . $SERI . ", " . $KD_KEMAS . ", " . $JML_KEMAS . ", " . $CONT_ASAL . ", ". $BRUTO. "
					, " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
					, " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
					, " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
					, " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", now());";
		}elseif (($KD_DOK=='3') || ($KD_DOK=='6')) {
			$SQL = "INSERT INTO t_cocostskms (ID, SERI, KD_KEMASAN, JUMLAH, NO_CONT_ASAL, BRUTO,
					NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
					KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT,
					KD_SARANA_ANGKUT_OUT, NO_POL_OUT, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
					NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, WK_REKAM)
					VALUES (" . $ID . ", " . $SERI . ", " . $KD_KEMAS . ", " . $JML_KEMAS . ", " . $CONT_ASAL . ", ". $BRUTO. "
					, " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
					, " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
					, " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
					, " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", now());";
		}
	}
    if ($SQL != '') {
        $Execute = $conn->execute($SQL);
        if (!$Execute) {
			$SQL=mysql_errno() . ": " . mysql_error(). '; '. $SQL;
            echo 'Cannot execute query t_cocostskms. ' . $SQL . '<hr>';
        }
    }
    return ($Execute != '') ? 'true' : 'false|' . $SQL;
}

?>
