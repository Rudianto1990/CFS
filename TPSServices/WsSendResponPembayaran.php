<?php

set_time_limit(3600);
require_once("config.php");
$CONF['url.wsdl'] = 'Https://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
//$CONF['url.wsdl'] = 'Http://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
$main = new main($CONF, $conn);
$main->connect();

$ipAddress = getIP();
$SOAPAction = '';
$SQLUSER = "SELECT A.ID,A.NO_ORDER,A.NO_INVOICE,B.TGL_TERIMA AS TGL_UPDATE,A.TOTAL FROM t_billing_cfshdr A 
			join t_edc_payment_bank B on A.NO_INVOICE=B.NO_INVOICE WHERE A.NO_ORDER LIKE '1001%' AND A.FLAG_APPROVE='Y' 
			AND A.KD_ALASAN_BILLING='ACCEPT' AND A.FL_SEND='100'";
$QueryUser = $conn->query($SQLUSER);

if ($QueryUser->size() > 0) {//echo 'oke';
	while ($QueryUser->next()) {
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<DOCUMENT>';
		$xml .= '<RESPONPEMBAYARANCFS>';
		$xml .= '<NO_ORDER>' . $QueryUser->get("NO_ORDER") . '</NO_ORDER>';
		$xml .= '<NO_INVOICE>' . $QueryUser->get("NO_INVOICE") . '</NO_INVOICE>';
		$xml .= '<TGL_BAYAR>' . $QueryUser->get("TGL_UPDATE") . '</TGL_BAYAR>';
		$xml .= '<TOTAL_BAYAR>' . $QueryUser->get("TOTAL") . '</TOTAL_BAYAR>';
		$xml .= '</RESPONPEMBAYARANCFS>';
		$xml .= '</DOCUMENT>';
		$Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
		/* echo $xml.'<pre>';
		print_r($Send);
		echo '</pre>'; */
		if ($Send['response'] != '') {
			$arr1 = 'CheckConnectionResponse';
			$arr2 = 'CheckConnectionResult';
			$response = $Send['response'];
			$SQL = "UPDATE t_billing_cfshdr SET FL_SEND='200' WHERE ID='". $QueryUser->get("ID") ."'";
			$Execute = $conn->execute($SQL);
		} else {
			$response = $Send['info'];
		}
		$SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
				VALUES ('RAYA', 'RAYA', '" . $CONF['url.wsdl'] . "', 'SendResponPembayaranCFS', '" . $xml . "', '" . $response . "', '" . $ipAddress . "', NOW())";
		$Execute = $conn->execute($SQL);
		echo $QueryUser->get("NO_ORDER").'<br>'.$QueryUser->get("NO_INVOICE").'<br>';
		echo $response.'<hr>';
	}
}else{
	echo 'Belum ada data invoice baru';
}
$main->connect(false);

function getIP($type = 0) {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else {
        $ip = "unknown";
        return $ip;
    }
    if ($type == 1) {
        return md5($ip);
    }
    if ($type == 0) {
        return $ip;
    }
}
?>