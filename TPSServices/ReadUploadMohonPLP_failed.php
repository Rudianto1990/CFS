<?php

set_time_limit(3600);
require_once("config.php");

$method = 'ReadCoarriCodeco_Container';
$KdAPRF = 'CoarriCodeco_Container';
$KodeDokBC = '1';
$sqlerror='';
$main = new main($CONF, $conn);
  $main->connect();

  //$SQL = "SELECT a.ID, a.REQUEST, a.RESPONSE FROM app_log_services_failed a WHERE a.METHOD in ('UploadMohonPLP') AND a.RESPONSE like '%berhasil%' order by a.WK_REKAM ASC limit 10";
  //$SQL = "SELECT a.ID, a.REQUEST, a.RESPONSE FROM app_log_services_test_cfs a WHERE a.METHOD in ('UploadMohonPLP') order by a.WK_REKAM ASC";
  $Query = $conn->query($SQL);
  //print_r($Query);die();
  if ($Query->size() > 0) {
    while ($Query->next()) {
      $ID_LOG = $Query->get("ID");
      $STR_DATA = $Query->get("REQUEST");
      $RESPONSE = $Query->get("RESPONSE");
		$SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services_test_cfs WHERE ID = '" . $ID_LOG . "'";
		$Execute = $conn->execute($SQL);

		if($Execute){
		$SQL = "DELETE FROM app_log_services_test_cfs WHERE ID = '" . $ID_LOG . "'";
		$Execute = $conn->execute($SQL);
		}else{
			echo mysql_error().'<br>';
		}

      /* $xml = xml2ary($STR_DATA);
	  if (count($xml) > 0) {
		$xml = $xml['DOCUMENT']['_c'];
		$countSPPB = 0;
		$countSPPB = count($xml['LOADPLP']);
		echo $ID_LOG . '<br>';
		if ($countSPPB > 1) {
		  for ($c = 0; $c < $countSPPB; $c++) {
			$cocostscont = $xml['LOADPLP'][$c]['_c'];
			$detil = $cocostscont['DETIL']['_c'];
			if(isset($detil['KMS']) && isset($detil['CONT'])){
				if(count($detil['KMS']) > 0 && count($detil['CONT']) > 0){
					echo 'Format XML Salah<br>';
				}
			}else{
				Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG);
			}
		  }
		} elseif ($countSPPB == 1) {
			$cocostscont = $xml['LOADPLP']['_c'];
			$detil = $cocostscont['DETIL']['_c'];
			if(isset($detil['KMS']) && isset($detil['CONT'])){
				if(count($detil['KMS']) > 0 && count($detil['CONT']) > 0){
					echo 'Format XML Salah<br>';
				}
			}else{
				Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG);
			}
		}else{
		  echo 'Data XML salah<br>';
		  $SQL = "INSERT INTO app_log_services_test_cfs SELECT * FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
		  $Execute = $conn->execute($SQL);

		  $SQL = "UPDATE app_log_services_test_cfs SET RESPONSE = 'Data XML salah' WHERE ID = '" . $ID_LOG . "'";
		  $Execute = $conn->execute($SQL);

		  if($Execute){
			$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);
		  }
		}
	  }else{
		echo 'XML tidak ada<br>';
		  $SQL = "INSERT INTO app_log_services_test_cfs SELECT * FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
		  $Execute = $conn->execute($SQL);

		  $SQL = "UPDATE app_log_services_test_cfs SET RESPONSE = 'XML tidak ada' WHERE ID = '" . $ID_LOG . "'";
		  $Execute = $conn->execute($SQL);

		  if($Execute){
			$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);
		  }
	  }
    echo '<hr>'; */
    }
  } else {
    echo 'data tidak ada.<br>';
  }

  $main->connect(false);

function Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG) {
    global $CONF, $conn;
	$sqlerror='';$tipe='';
    $header = $cocostscont['HEADER']['_c'];
    $KD_KANTOR = trim($header['KD_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR']['_v'])) . "'";
    $TIPE_DATA = trim($header['TIPE_DATA']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['TIPE_DATA']['_v'])) . "'";
    $KD_TPS_ASAL = trim($header['KD_TPS_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS_ASAL']['_v'])) . "'";
    $REF_NUMBER = trim($header['REF_NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['REF_NUMBER']['_v'])) . "'";
    $NO_SURAT = trim($header['NO_SURAT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_SURAT']['_v'])) . "'";
    $TGL_SURAT = trim($header['TGL_SURAT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_SURAT']['_v'])) . "','%Y%m%d')";
    $GUDANG_ASAL = trim($header['GUDANG_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG_ASAL']['_v'])) . "'";
    $KD_TPS_TUJUAN = trim($header['KD_TPS_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS_TUJUAN']['_v'])) . "'";
    $GUDANG_TUJUAN = trim($header['GUDANG_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG_TUJUAN']['_v'])) . "'";
    $KD_ALASAN_PLP = trim($header['KD_ALASAN_PLP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_ALASAN_PLP']['_v'])) . "'";
    $YOR_ASAL = trim($header['YOR_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['YOR_ASAL']['_v'])) . "'";
    $YOR_TUJUAN = trim($header['YOR_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['YOR_TUJUAN']['_v'])) . "'";
    $CALL_SIGN = trim($header['CALL_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CALL_SIGN']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $TGL_TIBA = trim($header['TGL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_TIBA']['_v'])) . "','%Y%m%d')";
    $NO_BC11 = trim($header['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($header['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_BC11']['_v'])) . "','%Y%m%d')";
    $NM_PEMOHON = trim($header['NM_PEMOHON']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_PEMOHON']['_v'])) . "'";

    echo $REF_NUMBER . '<br>';
    $SQL = "SELECT ID, REF_NUMBER FROM t_request_plp_hdr WHERE REF_NUMBER = " . $REF_NUMBER;
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_request_plp_hdr (TIPE_DATA, KD_KPBC, NO_SURAT, TGL_SURAT, KD_TPS_ASAL, KD_GUDANG_ASAL, YOR_ASAL, KD_TPS_TUJUAN, KD_GUDANG_TUJUAN, 
						YOR_TUJUAN, NM_ANGKUT, NO_VOY_FLIGHT, TGL_TIBA, NO_BC11, TGL_BC11, NM_PEMOHON, KD_ALASAN_PLP, REF_NUMBER, KD_STATUS, TGL_STATUS)
                VALUES (" . $TIPE_DATA . "," . $KD_KANTOR . ", " . $NO_SURAT . ", " . $TGL_SURAT . ", " . $KD_TPS_ASAL . ", " . $GUDANG_ASAL . ", " . $YOR_ASAL . ", " . $KD_TPS_TUJUAN . ", " . $GUDANG_TUJUAN . ", " . $YOR_TUJUAN . ", " . $NM_ANGKUT . ", " . $NO_VOY_FLIGHT . ", " . $TGL_TIBA . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", " . $NM_PEMOHON . ", " . $KD_ALASAN_PLP . ", " . $REF_NUMBER . ", '400',NOW());";
		$Execute = $conn->execute($SQL);
		if($Execute!=''){
			$ID = mysql_insert_id();
			echo $ID . '<br>';
			$tipe="insert";
		}else{
			$sqlerror='Query Error: Cannot Insert t_request_plp_hdr; '. $SQL;
		}
	} else{
		$SQL = "UPDATE t_request_plp_hdr SET TIPE_DATA=" . $TIPE_DATA . ", KD_KPBC=" . $KD_KANTOR . ", NO_SURAT=" . $NO_SURAT . ",
				TGL_SURAT=" . $TGL_SURAT . ", KD_TPS_ASAL=" . $KD_TPS_ASAL . ", KD_GUDANG_ASAL=" . $GUDANG_ASAL . ", 
				YOR_ASAL=" . $YOR_ASAL . ", KD_TPS_TUJUAN=" . $KD_TPS_TUJUAN . ", KD_GUDANG_TUJUAN=" . $GUDANG_TUJUAN . ", 
				YOR_TUJUAN=" . $YOR_TUJUAN . ", NM_ANGKUT=" . $NM_ANGKUT . ", NO_VOY_FLIGHT=" . $NO_VOY_FLIGHT . ", 
				TGL_TIBA=" . $TGL_TIBA . ", NO_BC11=" . $NO_BC11 . ", TGL_BC11=" . $TGL_BC11 . ", NM_PEMOHON=" . $NM_PEMOHON . ", 
				KD_ALASAN_PLP=" . $KD_ALASAN_PLP . ", KD_STATUS='400', TGL_STATUS=NOW() WHERE REF_NUMBER = " . $REF_NUMBER.";";
		$Execute = $conn->execute($SQL);
		if($Execute!=''){
			$Query->next();
			$ID = $Query->get("ID");
			$tipe="update";
		}else{
			$sqlerror='Query Error: Cannot Update t_request_plp_hdr; '. $SQL;
		}
    }
	if ($sqlerror == '') {
		$SQL = "select A.ID from t_permohonan_cfshdr A WHERE A.NAMA_KAPAL=".$NM_ANGKUT." AND A.NO_VOY_FLIGHT=".$NO_VOY_FLIGHT."
				AND A.TGL_TIBA=".$TGL_TIBA." AND A.NO_BC11=".$NO_BC11." AND A.TGL_BC11=".$TGL_BC11;
		$Query = $conn->query($SQL);
		if ($Query->size() != 0) {
			while ($Query->next()) {
				$ID_CFS = $Query->get("ID");
			}
		} else {
			$ID_CFS = "";
		}
		$detil = $cocostscont['DETIL']['_c'];
		$countCONT = count($detil['CONT']);
		$countKMS = count($detil['KMS']);
		if ($countCONT > 1) {
			for ($d = 0; $d < $countCONT; $d++) {
				$CONT = $detil['CONT'][$d]['_c'];
				$return = InsertKontainer($ID, $CONT, $tipe, $ID_CFS);
				if($return!='true'){
					$return = explode('|',$return);
					$sqlerror .= $return[1];
				}
			}
		} elseif ($countCONT == 1) {
			$CONT = $detil['CONT']['_c'];
			$return = InsertKontainer($ID, $CONT, $tipe, $ID_CFS);
			if($return!='true'){
				$return = explode('|',$return);
				$sqlerror .= $return[1];
			}
		}
		if ($countKMS > 1) {
			for ($d = 0; $d < $countKMS; $d++) {
				$KMS = $detil['KMS'][$d]['_c'];
				$return = InsertKemasan($ID, $KMS, $tipe);
				if($return!='true'){
					$return = explode('|',$return);
					$sqlerror .= $return[1];
				}
			}
		} elseif ($countKMS == 1) {
			$KMS = $detil['KMS']['_c'];
			$return = InsertKemasan($ID, $KMS, $tipe);
			if($return!='true'){
				$return = explode('|',$return);
				$sqlerror .= $return[1];
			}
		}
		
		if($sqlerror==''){
			echo 'sukses';
			$SQL = "INSERT INTO app_log_services_test_cfs SELECT * FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "UPDATE app_log_services_test_cfs SET KETERANGAN = 'sukses' WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			if($Execute){
			$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);
			}
		}else{
			echo $sqlerror;
			$responseerror='Query Error: Cannot Insert '. $sqlerror;
			$SQL = "UPDATE app_log_services_failed SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "INSERT INTO app_log_services_test_cfs SELECT * FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = 'UPDATE app_log_services_test_cfs SET KETERANGAN = "' . $responseerror . '" WHERE ID = "' . $ID_LOG . '"';
			$Execute = $conn->execute($SQL);

			if($Execute){
			$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);
			}
		}
	} else {
		echo $sqlerror;
		$SQL = "UPDATE app_log_services_failed SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
		$Execute = $conn->execute($SQL);

		$SQL = "INSERT INTO app_log_services_test_cfs SELECT * FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
		$Execute = $conn->execute($SQL);

		$SQL = 'UPDATE app_log_services_test_cfs SET KETERANGAN = "' . $sqlerror . '" WHERE ID = "' . $ID_LOG . '"';
		$Execute = $conn->execute($SQL);

		if($Execute){
		$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
		$Execute = $conn->execute($SQL);
		}
	}
}

function InsertKontainer($ID, $CONT, $TYPE, $CFS="") {
    global $CONF, $conn;
	$NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
	$UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
	if($TYPE=="insert"){
		$SQL = "INSERT INTO t_request_plp_cont (ID, NO_CONT, KD_CONT_UKURAN)
				VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ");";		
	}elseif($TYPE=="update"){
		$SQL = "SELECT * FROM t_request_plp_cont WHERE ID = " . $ID ." AND NO_CONT = " . $NO_CONT;
		$Query = $conn->query($SQL);
		if ($Query->size() == 0) {
			$SQL = "INSERT INTO t_request_plp_cont (ID, NO_CONT, KD_CONT_UKURAN)
					VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ");";		
		}
	}
	$Execute = $conn->execute($SQL);
	if($CFS!=""){
		$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='200', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
		$Execute1 = $conn->execute($sqlupdateCont);
	}else{
		$Execute1= $Execute;
		$sqlupdateCont="";
	}
	return ($Execute1!='')? 'true':'false|t_request_plp_cont; '.$SQL.$sqlupdateCont;
}

function InsertKemasan($ID, $CONT, $TYPE) {
    global $CONF, $conn;
	$KD_KEMASAN = trim($CONT['JNS_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JNS_KMS']['_v'])) . "'";
	$JML_KMS = trim($CONT['JML_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JML_KMS']['_v'])) . "'";
	$NO_BL_AWB = trim($CONT['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($CONT['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";
	if($TYPE=="insert"){
		$SQL = "INSERT INTO t_request_plp_kms (ID, KD_KEMASAN, JML_KMS,NO_BL_AWB,TGL_BL_AWB)
				VALUES (" . $ID . ", " . $KD_KEMASAN . ", " . $JML_KMS . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ")";
	}elseif($TYPE=="update"){
		$SQL = "SELECT * FROM t_request_plp_kms WHERE ID = " . $ID ." AND KD_KEMASAN=" . $KD_KEMASAN . " 
				AND NO_BL_AWB=" . $NO_BL_AWB . " AND TGL_BL_AWB=" . $TGL_BL_AWB;
		$Query = $conn->query($SQL);
		if ($Query->size() == 0) {
			$SQL = "INSERT INTO t_request_plp_kms (ID, KD_KEMASAN, JML_KMS,NO_BL_AWB,TGL_BL_AWB)
					VALUES (" . $ID . ", " . $KD_KEMASAN . ", " . $JML_KMS . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ")";
		}
	}
	$Execute = $conn->execute($SQL);
	return ($Execute!='')? 'true':'false|t_request_plp_kms; '.$SQL;
}
/* function Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG) {
    global $CONF, $conn;
	$sqlerror='';
    $header = $cocostscont['HEADER']['_c'];
    $KD_KANTOR = trim($header['KD_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR']['_v'])) . "'";
    $TIPE_DATA = trim($header['TIPE_DATA']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['TIPE_DATA']['_v'])) . "'";
    $KD_TPS_ASAL = trim($header['KD_TPS_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS_ASAL']['_v'])) . "'";
    $REF_NUMBER = trim($header['REF_NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['REF_NUMBER']['_v'])) . "'";
    $NO_SURAT = trim($header['NO_SURAT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_SURAT']['_v'])) . "'";
    $TGL_SURAT = trim($header['TGL_SURAT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_SURAT']['_v'])) . "','%Y%m%d')";
    $GUDANG_ASAL = trim($header['GUDANG_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG_ASAL']['_v'])) . "'";
    $KD_TPS_TUJUAN = trim($header['KD_TPS_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS_TUJUAN']['_v'])) . "'";
    $GUDANG_TUJUAN = trim($header['GUDANG_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['GUDANG_TUJUAN']['_v'])) . "'";
    $KD_ALASAN_PLP = trim($header['KD_ALASAN_PLP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_ALASAN_PLP']['_v'])) . "'";
    $YOR_ASAL = trim($header['YOR_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['YOR_ASAL']['_v'])) . "'";
    $YOR_TUJUAN = trim($header['YOR_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['YOR_TUJUAN']['_v'])) . "'";
    $CALL_SIGN = trim($header['CALL_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CALL_SIGN']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $TGL_TIBA = trim($header['TGL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_TIBA']['_v'])) . "','%Y%m%d')";
    $NO_BC11 = trim($header['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($header['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_BC11']['_v'])) . "','%Y%m%d')";
    $NM_PEMOHON = trim($header['NM_PEMOHON']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_PEMOHON']['_v'])) . "'";

    echo $REF_NUMBER . '<br>';
    $SQL = "SELECT REF_NUMBER FROM t_request_plp_hdr WHERE REF_NUMBER = " . $REF_NUMBER;
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_request_plp_hdr (TIPE_DATA, KD_KPBC, NO_SURAT, TGL_SURAT, KD_TPS_ASAL, KD_GUDANG_ASAL, YOR_ASAL, KD_TPS_TUJUAN, KD_GUDANG_TUJUAN, 
						YOR_TUJUAN, NM_ANGKUT, NO_VOY_FLIGHT, TGL_TIBA, NO_BC11, TGL_BC11, NM_PEMOHON, KD_ALASAN_PLP, REF_NUMBER, KD_STATUS, TGL_STATUS)
                VALUES (" . $TIPE_DATA . "," . $KD_KANTOR . ", " . $NO_SURAT . ", " . $TGL_SURAT . ", " . $KD_TPS_ASAL . ", " . $GUDANG_ASAL . ", " . $YOR_ASAL . ", " . $KD_TPS_TUJUAN . ", " . $GUDANG_TUJUAN . ", " . $YOR_TUJUAN . ", " . $NM_ANGKUT . ", " . $NO_VOY_FLIGHT . ", " . $TGL_TIBA . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", " . $NM_PEMOHON . ", " . $KD_ALASAN_PLP . ", " . $REF_NUMBER . ", '400',NOW());";
		$Execute = $conn->execute($SQL);
		if($Execute!=''){
			$ID = mysql_insert_id();
			echo $ID . '<br>';
			if ($ID != '') {
				$SQL = "select A.ID from t_permohonan_cfshdr A WHERE A.NAMA_KAPAL=".$NM_ANGKUT." AND A.NO_VOY_FLIGHT=".$NO_VOY_FLIGHT."
						AND A.TGL_TIBA=".$TGL_TIBA." AND A.NO_BC11=".$NO_BC11." AND A.TGL_BC11=".$TGL_BC11;
				$Query = $conn->query($SQL);
				if ($Query->size() != 0) {
					while ($Query->next()) {
						$ID_CFS = $Query->get("ID");
					}
				} else {
					$ID_CFS = "";
				}
				$detil = $cocostscont['DETIL']['_c'];
				$countCONT = count($detil['CONT']);
				$countKMS = count($detil['KMS']);
				if ($countCONT > 1) {
					for ($d = 0; $d < $countCONT; $d++) {
						$CONT = $detil['CONT'][$d]['_c'];
						$return = InsertKontainer($ID, $CONT, $ID_CFS);
						if($return!='true'){
							$return = explode('|',$return);
							$sqlerror .= $return[1];
						}
					}
				} elseif ($countCONT == 1) {
					$CONT = $detil['CONT']['_c'];
					$return = InsertKontainer($ID, $CONT, $ID_CFS);
					if($return!='true'){
						$return = explode('|',$return);
						$sqlerror .= $return[1];
					}
				}elseif ($countKMS > 1) {
					for ($d = 0; $d < $countKMS; $d++) {
						$KMS = $detil['KMS'][$d]['_c'];
						$return = InsertKemasan($ID, $KMS);
						if($return!='true'){
							$return = explode('|',$return);
							$sqlerror .= $return[1];
						}
					}
				} elseif ($countKMS == 1) {
					$KMS = $detil['KMS']['_c'];
					$return = InsertKemasan($ID, $KMS);
					if($return!='true'){
						$return = explode('|',$return);
						$sqlerror .= $return[1];
					}
				}else{
					$sqlerror='Data kosong;';
				}
				if($sqlerror==''){
					echo 'sukses';
					$SQL = "INSERT INTO app_log_services_test_cfs SELECT * FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);

					$SQL = "UPDATE app_log_services_test_cfs SET RESPONSE = 'sukses' WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);

					if($Execute){
					$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);
					}
				}else{
					echo $sqlerror;
					$responseerror='Query Error: Cannot Insert '. $sqlerror;
					$SQL = "INSERT INTO app_log_services_test_cfs SELECT * FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);

					$SQL = 'UPDATE app_log_services_test_cfs SET RESPONSE = "' . $responseerror . '" WHERE ID = "' . $ID_LOG . '"';
					$Execute = $conn->execute($SQL);

					if($Execute){
					$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);
					}
				}
			}
		}else{
			$sqlerror='Query Error: Cannot Insert t_request_plp_hdr; '. $SQL;
			echo $sqlerror;
			$SQL = "INSERT INTO app_log_services_test_cfs SELECT * FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = 'UPDATE app_log_services_test_cfs SET RESPONSE = "' . $sqlerror . '" WHERE ID = "' . $ID_LOG . '"';
			$Execute = $conn->execute($SQL);

			if($Execute){
			$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);
			}
		}
	} else{
		$sqlerror='Query Error: Duplicate REFF NUMBER; '. $REF_NUMBER;
		echo $sqlerror;
		$SQL = "INSERT INTO app_log_services_test_cfs SELECT * FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
		$Execute = $conn->execute($SQL);

		$SQL = 'UPDATE app_log_services_test_cfs SET RESPONSE = "' . $sqlerror . '" WHERE ID = "' . $ID_LOG . '"';
		$Execute = $conn->execute($SQL);

		if($Execute){
		$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
		$Execute = $conn->execute($SQL);
		}
    }
}

function InsertKontainer($ID, $CONT, $CFS="") {
    global $CONF, $conn;
	$NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
	$UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
		$SQL = "INSERT INTO t_request_plp_cont (ID, NO_CONT, KD_CONT_UKURAN)
				VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ");";
	$Execute = $conn->execute($SQL);
	if($CFS!=""){
		$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='200', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
		$Execute1 = $conn->execute($sqlupdateCont);
	}else{
		$Execute1= $Execute;
		$sqlupdateCont="";
	}
	return ($Execute1!='')? 'true':'false|t_request_plp_cont; '.$SQL.$sqlupdateCont;
}

function InsertKemasan($ID, $CONT) {
    global $CONF, $conn;
	$KD_KEMASAN = trim($CONT['JNS_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JNS_KMS']['_v'])) . "'";
	$JML_KMS = trim($CONT['JML_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JML_KMS']['_v'])) . "'";
	$NO_BL_AWB = trim($CONT['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($CONT['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";
		$SQL = "INSERT INTO t_request_plp_kms (ID, KD_KEMASAN, JML_KMS,NO_BL_AWB,TGL_BL_AWB)
				VALUES (" . $ID . ", " . $KD_KEMASAN . ", " . $JML_KMS . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ");";
	$Execute = $conn->execute($SQL);
	return ($Execute!='')? 'true':'false|t_request_plp_kms; '.$SQL;
}
 */?>
