<?php

set_time_limit(3600);
require_once("config.php");

$method = 'READGETRESPONPLPASAL';
$KdAPRF = 'GETRESPLPASAL';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    #$createFile = $main->createFile($filename);
    $main->connect();
    //BEGIN
	//READ MAILBOX RESPON PLP
/*     $SQL = "SELECT ID, STR_DATA
            FROM mailbox A 
            WHERE A.KD_STATUS = '100'
                  AND KD_APRF = '" . $KdAPRF . "'
            LIMIT 0,10"; */
$SQL = "SELECT a.ID, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('GetResponPLP') AND a.RESPONSE LIKE '%xml%' 
		AND a.FL_USED='0' order by a.WK_REKAM ASC limit 10";
	$Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $ID_MAILBOX = $Query->get("ID");
            $STR_DATA = $Query->get("RESPONSE");
            $xml = xml2ary($STR_DATA);
            if (count($xml) > 0) {
                $xml = $xml['DOCUMENT']['_c'];
                $countPLP = count($xml['RESPONPLP']);
                if ($countPLP > 1) {
                    for ($c = 0; $c < $countPLP; $c++) {
                        $RESPONPLP = $xml['RESPONPLP'][$c]['_c'];
                        InsertPLPResponAsal($RESPONPLP,$ID_MAILBOX);
                    }
                } elseif ($countPLP == 1) {
                    $RESPONPLP = $xml['RESPONPLP']['_c'];
                    InsertPLPResponAsal($RESPONPLP,$ID_MAILBOX);
                }else {
					$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_MAILBOX . "'";
					$Execute = $conn->execute($SQL);

					$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_MAILBOX . "'";
					$Execute = $conn->execute($SQL);

					$SQL = "UPDATE app_log_services_failed SET REQUEST = 'Data XML salah' WHERE ID = '" . $ID_MAILBOX . "'";
					$Execute = $conn->execute($SQL);

					/* if($Execute){
					  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_MAILBOX . "'";
					  $Execute = $conn->execute($SQL);
					  } */
				}
			} else {
				$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_MAILBOX . "'";
				$Execute = $conn->execute($SQL);

				$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_MAILBOX . "'";
				$Execute = $conn->execute($SQL);

				$SQL = "UPDATE app_log_services_failed SET REQUEST = 'Data tidak ada' WHERE ID = '" . $ID_MAILBOX . "'";
				$Execute = $conn->execute($SQL);

				/* if($Execute){
				  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_MAILBOX . "'";
				  $Execute = $conn->execute($SQL);
				  } */
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

function InsertPLPResponAsal($RESPONPLP,$ID_LOG) {
	global $CONF, $conn;
    $header = $RESPONPLP['HEADER']['_c'];
    $KD_KANTOR = trim($header['KD_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_KANTOR']['_v'])) . "'";
    $KD_TPS = trim($header['KD_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS']['_v'])) . "'";
	$REF_NUMBER = trim($header['REF_NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['REF_NUMBER']['_v'])) . "'";
	$NO_PLP = trim($header['NO_PLP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_PLP']['_v'])) . "'";
    $TGL_PLP = trim($header['TGL_PLP']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_PLP']['_v'])) . "','%Y%m%d')";
    $ALASAN_REJECT = trim($header['ALASAN_REJECT']['_v']) == "" ? "'-'" : "'" . strtoupper(trim($header['ALASAN_REJECT']['_v'])) . "'";
    #echo $NO_PLP . '-' . $TGL_PLP . '<br>';
    $SQL = "SELECT ID
            FROM t_respon_plp_asal_hdr
            WHERE NO_PLP = ".$NO_PLP." 
                  AND TGL_PLP = ".$TGL_PLP."";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0){
        $SQL = "INSERT INTO t_respon_plp_asal_hdr(KD_KPBC, KD_TPS, NO_PLP, TGL_PLP, ALASAN_REJECT, REF_NUMBER, KD_STATUS, TGL_STATUS)
                VALUES (".$KD_KANTOR.", ".$KD_TPS.", ".$NO_PLP.", ".$TGL_PLP.", ".$ALASAN_REJECT.", ".$REF_NUMBER.", '100', NOW())";
        $Execute = $conn->execute($SQL);
        if ($Execute) {
			echo $SQL . '<br>';
            $ID = mysql_insert_id();
			if ($ID != '') {
				
				$SQL = "SELECT B.NM_ANGKUT, B.NO_VOY_FLIGHT, B.TGL_TIBA, B.NO_BC11, B.TGL_BC11
						FROM t_respon_plp_asal_hdr A INNER JOIN t_request_plp_hdr B ON A.REF_NUMBER = B.REF_NUMBER
						WHERE A.REF_NUMBER=".$REF_NUMBER;
				$Query = $conn->query($SQL);
				if ($Query->size() != 0) {
					while ($Query->next()) {
						$NM_ANGKUT = $Query->get("NM_ANGKUT");
						$NO_VOY_FLIGHT = $Query->get("NO_VOY_FLIGHT");
						$TGL_TIBA = $Query->get("TGL_TIBA");
						$NO_BC11 = $Query->get("NO_BC11");
						$TGL_BC11 = $Query->get("TGL_BC11");
					}
				}
				$SQL = "select A.ID from t_permohonan_cfshdr A WHERE A.NAMA_KAPAL='".$NM_ANGKUT."' AND A.NO_VOY_FLIGHT='".$NO_VOY_FLIGHT."'
						AND A.TGL_TIBA='".$TGL_TIBA."' AND A.NO_BC11='".$NO_BC11."' AND A.TGL_BC11='".$TGL_BC11."'";
				$Query = $conn->query($SQL);
				if ($Query->size() != 0) {
					while ($Query->next()) {
						$ID_CFS = $Query->get("ID");
					}
				}
			   $detil = $RESPONPLP['DETIL']['_c'];
				$countCONT = count($detil['CONT']);
				if ($countCONT > 1) {
					for ($d = 0; $d < $countCONT; $d++) {
						$CONT = $detil['CONT'][$d]['_c'];
						$return = InsertKontainer($ID, $CONT, $ID_CFS);
						if ($return != 'true') {
							$return = explode('|', $return);
							$sqlerror .= $return[1];
						}
					}
				} elseif ($countCONT == 1) {
					$CONT = $detil['CONT']['_c'];
					$return = InsertKontainer($ID, $CONT, $ID_CFS);
					if ($return != 'true') {
						$return = explode('|', $return);
						$sqlerror .= $return[1];
					}
				} else {
					$sqlerror = 'Data kontainer kosong;';
				}
				if ($sqlerror == '') {
					//UPDATE AFTER GET RESPON
					$SQL = "SELECT B.ID FROM t_respon_plp_asal_hdr A
							INNER JOIN t_request_plp_hdr B ON B.REF_NUMBER=A.REF_NUMBER
							WHERE B.KD_STATUS = '400'";
					$Execute = $conn->query($SQL);
					if ($Execute->size() > 0) {
						while ($Execute->next()){
							$REQ_ID = $Execute->get("ID");
							$SQL = "UPDATE t_request_plp_hdr SET KD_STATUS = '600', TGL_STATUS = NOW() WHERE ID = '".$REQ_ID."'";
							$Query = $conn->execute($SQL);
						}
					}
					$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);

					$SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);
					echo 'OK';
				} else {
					$responseerror = 'Query Error: Cannot Insert t_respon_plp_asal_cont; ' . $sqlerror;
					echo $sqlerror;
					$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);

					$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);

					$SQL = 'UPDATE app_log_services_failed SET REQUEST = "' . $responseerror . '" WHERE ID = "' . $ID_LOG . '"';
					$Execute = $conn->execute($SQL);
				}			
			}
        } else {
            echo 'Cannot execute query t_respon_plp_asal_hdr. ' . $SQL . '<hr>';
            $sqlerror = 'Query Error: Cannot Insert t_respon_plp_asal_hdr; ' . $SQL;
            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = 'UPDATE app_log_services_failed SET REQUEST = "' . $sqlerror . '" WHERE ID = "' . $ID_LOG . '"';
            $Execute = $conn->execute($SQL);
        }
    }
}
function InsertKontainer($ID, $CONT, $CFS) {
    global $CONF, $conn;
    $NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
    //add tag element
    $FL_SETUJU = trim($CONT['FL_SETUJU']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['FL_SETUJU']['_v'])) . "'";
    $JNS_CONT = trim($CONT['JNS_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JNS_CONT']['_v'])) . "'";
    $SQL = "INSERT INTO t_respon_plp_asal_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_STATUS)
            VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " .$FL_SETUJU.")";
    $Execute = $conn->execute($SQL);
	$STAT=($CONT['FL_SETUJU']['_v']=='Y')?"400":"500";
	$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='".$STAT."', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
	$Execute1 = $conn->execute($sqlupdateCont);
    //echo $SQL . '<br>';
	return ($Execute!='')? 'true':'false|'.$SQL;


?>