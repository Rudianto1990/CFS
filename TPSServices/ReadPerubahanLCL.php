<?php
set_time_limit(3600);
require_once("config.php");


$method = 'RESPONLCL';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);


if (!$CheckFile) {
	global $CONF, $conn;
	$main->connect();
$SQL = "SELECT * FROM app_log_server WHERE METHOD='".$method."' AND XML_RESPONSE IS NOT NULL AND REMARKS IS NULL";
$Query = $conn->query($SQL);
 if ($Query->size() > 0) {
while ($Query->next()) {
	
$ID_SERVER = $Query->get("ID");
$XML_RESPONSE = $Query->get("XML_RESPONSE");
$xml = xml2ary($XML_RESPONSE);

if (count($xml) > 0) {
	
                $xml = $xml['DOCUMENT']['_c'];
                $countLCL = count($xml['RESPONLCL']);
                if ($countLCL > 1) {
                    for ($c = 0; $c < $countLCL; $c++) {
                        $RESPONLCL = $xml['RESPONLCL'][$c]['_c'];
						UpdateRESPONLCL($RESPONLCL);
						
                    }
                } 
				elseif ($countLCL == 1) {
                    $RESPONLCL = $xml['RESPONLCL']['_c'];
                    UpdateRESPONLCL($RESPONLCL);
                }
}
else
{
	echo 'kosong';
}


$SQL = "UPDATE app_log_server SET REMARKS = 'DATA BERHASIL DI EKSTRAK', WK_REKAM = NOW()
                    WHERE ID = '" . $ID_SERVER . "'";
            $Execute = $conn->execute($SQL);
		
        }
	}
	  else {
        echo 'data tidak ada.';
    }
    //END

    $main->connect(false);
    $main->removeFile($filename);
}
else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}


function UpdateRESPONLCL($RESPONLCL) {
    global $CONF, $conn;
    $header = $RESPONLCL['HEADER']['_c'];
    $KD_GUDANG_ASAL = trim($header['KD_GUDANG_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_GUDANG_ASAL']['_v'])) . "'";
    $KD_GUDANG_TUJUAN = trim($header['KD_GUDANG_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_GUDANG_TUJUAN']['_v'])) . "'";
    $KD_ORGANISASI = trim($header['KD_ORGANISASI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_ORGANISASI']['_v'])) . "'";
    $EMAIL = trim($header['EMAIL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['EMAIL']['_v'])) . "'";
    $NAMA_KAPAL = trim($header['NAMA_KAPAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_KAPAL']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $NO_BC11 = trim($header['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BC11']['_v'])) . "'";
    $ALASAN_TOLAK = trim($header['ALASAN_TOLAK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['ALASAN_TOLAK']['_v'])) . "'";
	
	$SQL = "SELECT NO_UBAH_STATUS FROM t_ubah_status 
	WHERE KD_GUDANG_ASAL=".$KD_GUDANG_ASAL." 
	AND KD_GUDANG_TUJUAN=".$KD_GUDANG_TUJUAN."
	AND NAMA_KAPAL=".$NAMA_KAPAL." 
	AND NO_VOY_FLIGHT = ".$NO_VOY_FLIGHT." 
	AND NO_BC11 = ".$NO_BC11; #die($SQL);
$Query = $conn->query($SQL);
 if ($Query->size() > 0) {
	 while ($Query->next()) {
		 
		 

			$detil = $RESPONLCL['DETAIL']['_c'];
            //PERUBAHAN KONTAINER
            $countCONT = count($detil['KONTAINER']);
            if ($countCONT > 1) {
                for ($d = 0; $d < $countCONT; $d++) {
                    $CONT = $detil['KONTAINER'][$d]['_c'];
                    UpdateKontainerLCL($Query->get("NO_UBAH_STATUS"),$ALASAN_TOLAK,$CONT);
                }
            } 
			elseif ($countCONT == 1) {
                $CONT = $detil['KONTAINER']['_c'];
                UpdateKontainerLCL($Query->get("NO_UBAH_STATUS"),$ALASAN_TOLAK,$CONT);
            }  
	 
	 
	 }
 }
else
{
return false;
}	

}

function UpdateKontainerLCL($KODE,$ALASAN_TOLAK,$CONT) {
    global $CONF, $conn;
    $NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $FL_SETUJU = trim($CONT['FL_SETUJU']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['FL_SETUJU']['_v'])) . "'";
if($FL_SETUJU == "'Y'")
{
	$STATUS = '1';
	$ALASAN = "'-'";
}
elseif($FL_SETUJU == "'T'")
{
	$STATUS = '2';
	$ALASAN = $ALASAN_TOLAK;
}


       $SQL2 = "UPDATE t_no_kontainer SET WK_REKAM=NOW() , STATUS='".$STATUS."' ,KETERANGAN=".$ALASAN."
	   WHERE NO_UBAH_STATUS='".$KODE."' AND NO_CONT=".$NO_CONT; 
	   #die($SQL2);
        $UPDATE = $conn->execute($SQL2);		 
		 		 

}
	
    
?>