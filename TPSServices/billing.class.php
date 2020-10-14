<?php


require_once("config.php");
$main = new main($CONF, $conn);
  $main->connect();

function getPenumpukan($GATEIN, $GATEOUT, $NO_ORDER){

}

function BillingCont($NO_CONT, $UK_CONT, $JML_CONT){
	$SQL = "SELECT TARIF_DASAR, KODE_BILL FROM reff_billing_cfs";
	$Query = $conn->query($SQL);
	if($Query->size() > 0){
		while($Query->next()){
			$KODE_BILL[$Query->get("KODE_BILL")] = $Query->get("KODE_BILL");
			$TARIF_DASAR[$Query->get("KODE_BILL")] = $Query->get("TARIF_DASAR");
		}
	}
	if($JML_CONT > 1){
		for ($j=0; $j < $JML_CONT; $j++) { 
			if ($UK_CONT == 20) {
				$datakode = array("LODPTP2","MOV12","LORPGCC2","STRP2","LODPECC2","MOV22","LORPE2","LODPE2");
			}elseif($UK_CONT == 40){
				$datakode = array("LODPTP4","MOV14","LORPGCC4","STRP4","LODPECC4","MOV24","LORPE4","LODPE4");
				$datakode4 = array("LODPE4","LODPE4","LODPE4");
			}
			$countkode = count($datakode);
			for ($i=0; $i < $countkode; $i++) { 
				$TOTAL = $TARIF_DASAR[$datakode[$i]]*$JML_CONT;
				$SQLInsert = "INSERT INTO t_biling_cfsdtl(KODE_BILL,NO_CONT,KD_UK_CONT,TARIF_DASAR,TOTAL,QTY,SATUAN,WEIGHT,MEASURE) VALUES(
					". $KODE_BILL[$datakode[$i]] .",". $NO_CONT .",". $UK_CONT .",". $TARIF_DASAR[$datakode[$i]] .",". $TOTAL .",". $JML_CONT .",NULL,NULL,NULL)";
				$Execute = $conn->execute($SQLInsert);
				if($Execute){
					//TRUE
					$message = '<?xml version="1.0" encoding="UTF-8"?>';
					$message .= '<BILLING>';
					$message .= '<STATUS>TRUE</STATUS>';
					$message .= '<MESSAGE>SUDAH DI INSERT KE DALAM TABLE</MESSAGE>';
					$message .= '</BILLING>';
				}else{
					//FALSE
					$message = '<?xml version="1.0" encoding="UTF-8"?>';
					$message .= '<BILLING>';
					$message .= '<STATUS>FALSE</STATUS>';
					$message .= '<MESSAGE>GAGAL INSERT KE DALAM TABLE</MESSAGE>';
					$message .= '</BILLING>';
				}
			}
		}
	}elseif($JML_CONT == 1){
		if ($UK_CONT == 20) {
			$datakode = array("LODPTP2","MOV12","LORPGCC2","STRP2","LODPECC2","MOV22","LORPE2","LODPE2");
		}elseif($UK_CONT == 40){
			$datakode = array("LODPTP4","MOV14","LORPGCC4","STRP4","LODPECC4","MOV24","LORPE4","LODPE4");
		}
		$countkode = count($datakode);
		for ($i=0; $i < $countkode; $i++) { 
			$TOTAL = $TARIF_DASAR[$datakode[$i]]*$JML_CONT;
			$SQLInsert = "INSERT INTO t_biling_cfsdtl(KODE_BILL,NO_CONT,KD_UK_CONT,TARIF_DASAR,TOTAL,QTY,SATUAN,WEIGHT,MEASURE) VALUES(
				". $KODE_BILL[$datakode[$i]] .",". $NO_CONT .",". $UK_CONT .",". $TARIF_DASAR[$datakode[$i]] .",". $TOTAL .",1,NULL,NULL,NULL)";
			$Execute = $conn->execute($SQLInsert);
			if($Execute){
				//TRUE
				$message = '<?xml version="1.0" encoding="UTF-8"?>';
				$message .= '<BILLING>';
				$message .= '<STATUS>TRUE</STATUS>';
				$message .= '<MESSAGE>SUDAH DI INSERT KE DALAM TABLE</MESSAGE>';
				$message .= '</BILLING>';
			}else{
				//FALSE
				$message = '<?xml version="1.0" encoding="UTF-8"?>';
				$message .= '<BILLING>';
				$message .= '<STATUS>FALSE</STATUS>';
				$message .= '<MESSAGE>GAGAL INSERT KE DALAM TABLE</MESSAGE>';
				$message .= '</BILLING>';
			}
		}
	}
	return $message;
}

function getSelisihTanggal($date1, $date2) {
    $unixNowDate = strtotime($date1);
    $unixOriginalDate = strtotime($date2);
    $difference = $unixNowDate - $unixOriginalDate;
    $days = (int) ($difference / 86400);
    $hours = (int) ($difference / 3600);
    $minutes = (int) ($difference / 60);
    $seconds = $difference;
    return $days;
}


 ?>