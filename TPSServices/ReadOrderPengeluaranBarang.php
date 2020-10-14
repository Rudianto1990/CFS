<?php

set_time_limit(3600);
require_once("config.php");

$sqlerror='';
$main = new main($CONF, $conn);
$main->connect();

/* Read all log*/
echo OrderPengeluaranBarang();
echo '<hr>';

function OrderPengeluaranBarang(){
    global $CONF, $conn;
	$sukses=0;$failed=0;
	$SQL = "SELECT a.ID,a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('OrderPengeluaranBarang') order by a.WK_REKAM ASC limit 10";
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {
		while ($Query->next()) {
			$ID_LOG = $Query->get("ID");
			$RESPONSE = $Query->get("RESPONSE");
			if($RESPONSE == '<?xml version=\"1.0\" encoding=\"UTF-8\"?><DOCUMENT><ORDERPENGELUARANBARANG><HEADER><STATUS>FALSE</STATUS><RESPON>Data Tidak Ada</RESPON></HEADER></ORDERPENGELUARANBARANG></DOCUMENT>'){
				$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);

				$SQL = "UPDATE app_log_services_failed SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);
				$failed++;

				if($Execute){
					$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);
				}
			}else{
				$SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);

				$SQL = "UPDATE app_log_services_success SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);
				$sukses++;

				if($Execute){
					$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
					$Execute = $conn->execute($SQL);
				}
			}
		}
		$return = 'jumlah data : '.$Query->size().' <br> sukses : '.$sukses.' <br> failed : '.$failed.' <br> ';
	} else {
		$return = 'Data Not Found.';
	}
	return $return;
}

$main->connect(false);