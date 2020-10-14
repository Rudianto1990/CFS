<?php

set_time_limit(3600);
require_once("config.php");

$sqlerror='';
$main = new main($CONF, $conn);
$main->connect();

/* Read all log*/
echo GetOrderExpired();
echo '<hr>';

function GetOrderExpired(){
    global $CONF, $conn;
	$mm='';
	$SQL = "select * from t_order_hdr A where A.NO_ORDER like '10%' and A.KD_STATUS in ('500','400') order by A.WK_REKAM asc limit 10;";
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {$i=0;
		while ($Query->next()) {
			$ID = $Query->get("NO_ORDER");
			$SQL = "update t_order_hdr A set A.KD_STATUS='600', A.TGL_STATUS=now() where A.NO_ORDER='" . $ID . "'";
			$Execute = $conn->execute($SQL);
			if($Execute){
				$mm .= $ID.'<br>';
				$i++;
			}
		}
		if($i>0){
			$return = $mm.'Order Kadaluwarsa adalah '.$i.' order.';
		}else{
			$return = 'Error Update Data.';
		}
	} else {
		$return = 'Belum ada penundaan pembayaran order.';
	}
	return $return;
}

$main->connect(false);