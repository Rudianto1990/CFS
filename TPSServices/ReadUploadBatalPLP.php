<?php

set_time_limit(3600);
require_once("config.php");

$KodeDokBC = '1';
$sqlerror='';
$main = new main($CONF, $conn);
  $main->connect();

  //BEGIN
  $SQL = "SELECT a.ID, a.REQUEST, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('UploadBatalPLP') 
		AND a.FL_USED='0' AND a.REQUEST is not null order by a.WK_REKAM ASC limit 10";
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
			$countSPPB = count($xml['BATALPLP']);
			echo $ID_LOG . '<br>';
			if ($countSPPB > 1) {
			  for ($c = 0; $c < $countSPPB; $c++) {
				$cocostscont = $xml['BATALPLP'][$c]['_c'];
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
			  $cocostscont = $xml['BATALPLP']['_c'];
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
				echo 'XML tidak ada<br>';
				$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);

				$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);

				$SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'XML tidak ada' WHERE ID = '" . $ID_LOG . "'";
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
    }
  } else {
    echo 'data tidak ada.<br>';
  }
  //END

  $main->connect(false);
  //$main->removeFile($filename);
//} else {
  //  echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
//}

function Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG) {
    global $CONF, $conn;
	$sqlerror='';
    $header = $cocostscont['HEADER']['_c'];
    $KD_KANTOR = trim($header['KD_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR']['_v'])) . "'";
    $TIPE_DATA = trim($header['TIPE_DATA']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['TIPE_DATA']['_v'])) . "'";
    $KD_TPS = trim($header['KD_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS']['_v'])) . "'";
    $REF_NUMBER = trim($header['REF_NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['REF_NUMBER']['_v'])) . "'";
    $NO_SURAT = trim($header['NO_SURAT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_SURAT']['_v'])) . "'";
    $TGL_SURAT = trim($header['TGL_SURAT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_SURAT']['_v'])) . "','%Y%m%d')";
    $ALASAN = trim($header['ALASAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['ALASAN']['_v'])) . "'";
    $NM_PEMOHON = trim($header['NM_PEMOHON']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_PEMOHON']['_v'])) . "'";

    echo $REF_NUMBER . '<br>';
    $SQL = "SELECT REF_NUMBER FROM t_request_batal_plp_hdr WHERE REF_NUMBER = " . $REF_NUMBER;
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_request_batal_plp_hdr (TIPE_DATA, KD_KPBC, NO_SURAT, TGL_SURAT, KD_TPS,NM_PEMOHON, ALASAN, REF_NUMBER, KD_STATUS, TGL_STATUS)
                VALUES (" . $TIPE_DATA . "," . $KD_KANTOR . ", " . $NO_SURAT . ", " . $TGL_SURAT . ", " . $KD_TPS . ", " . $NM_PEMOHON . ", " . $ALASAN . ", " . $REF_NUMBER . ", '200',NOW());";
        $Execute = $conn->execute($SQL);
		if($Execute!=''){
			$ID = mysql_insert_id();
			echo $ID . '<br>';
			if ($ID != '') {
				$detil = $cocostscont['DETIL']['_c'];
				$countCONT = count($detil['CONT']);
				$countKMS = count($detil['KMS']);
				if ($countCONT > 1) {
					for ($d = 0; $d < $countCONT; $d++) {
						$CONT = $detil['CONT'][$d]['_c'];
						$return = InsertKontainer($ID, $CONT);
						if($return!='true'){
							$return = explode('|',$return);
							$sqlerror .= $return[1];
						}
					}
				} elseif ($countCONT == 1) {
					$CONT = $detil['CONT']['_c'];
					$return = InsertKontainer($ID, $CONT);
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
					$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);

					$SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);

					if($Execute){
					$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);
					}
				}else{
					echo $sqlerror;
					$responseerror='Query Error: Cannot Insert t_cocostscont; '. $sqlerror;
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
		}else{
			$sqlerror='Query Error: Cannot Insert t_cocostshdr; '. $SQL;
			echo $sqlerror;
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
		$sqlerror='Query Error: Duplicate REFF NUMBER; '. $REF_NUMBER;
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
}

function InsertKontainer($ID, $CONT) {
    global $CONF, $conn;
	$NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
	$UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
		$SQL = "INSERT INTO t_request_batal_plp_cont (ID, NO_CONT, KD_CONT_UKURAN)
				VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ");";
	$Execute = $conn->execute($SQL);
	return ($Execute!='')? 'true':'false|'.$SQL;
}

function InsertKemasan($ID, $CONT) {
    global $CONF, $conn;
	$KD_KEMASAN = trim($CONT['JNS_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JNS_KMS']['_v'])) . "'";
	$JML_KMS = trim($CONT['JML_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JML_KMS']['_v'])) . "'";
	$NO_BL_AWB = trim($CONT['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($CONT['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";
		$SQL = "INSERT INTO t_request_batal_plp_kms (ID, KD_KEMASAN, JML_KMS,NO_BL_AWB,TGL_BL_AWB)
				VALUES (" . $ID . ", " . $KD_KEMASAN . ", " . $JML_KMS . ", " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ");";
	$Execute = $conn->execute($SQL);
	return ($Execute!='')? 'true':'false|'.$SQL;
}

?>
