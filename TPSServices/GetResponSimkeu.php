<?php
//ini buat scedhuler
set_time_limit(3600);
require_once("config.php");

$main = new main($CONF, $conn);
$main->connect();

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
}

//BEGIN
$SOAPAction = 'urn:portalintegrasiipc#pollServer'; 
//$SQL = 'url:portalintegrasiipc#pollServer';
$SQL = "SELECT A.ID, A.JENIS_BILLING, A.NO_ORDER,A.NO_INVOICE, C.BANK, B.CUSTOMER_NUMBER AS ID_ORGANISASI,
IFNULL(B.NAMA_FORWARDER,B.CONSIGNEE) AS NAMA, IFNULL(B.ALAMAT_FORWARDER,B.ALAMAT_CONSIGNEE) AS ALAMAT,
IFNULL(B.NPWP_FORWARDER,B.NPWP_CONSIGNEE) AS NPWP, A.SUBTOTAL, A.PPN, A.TOTAL, 
DATE_FORMAT(C.TGL_TERIMA, '%d/%m/%Y %H:%i:%s') AS TGL_TERIMA, C.APPR_CODE, C.REFF_NO, B.NM_ANGKUT, 
B.NO_VOYAGE, DATE_FORMAT(B.TGL_TIBA, '%d/%m/%Y') AS TGL_TIBA, B.NO_DO, B.NO_BL_AWB, 
func_name(B.KD_GUDANG_TUJUAN, 'GUDANG') AS GUDANG_TUJUAN, B.KD_GUDANG_TUJUAN, 
DATE_FORMAT(B.TGL_KELUAR, '%d/%m/%Y') AS TGL_KELUAR,A.STATUS_AR,A.STATUS_RECEIPT,A.STATUS_AP
FROM t_billing_cfshdr A INNER JOIN t_order_hdr B ON A.NO_ORDER = B.NO_ORDER
INNER JOIN t_edc_payment_bank C ON A.NO_INVOICE = C.NO_INVOICE
WHERE A.IS_SENDSIMKEU = '300' AND ((A.STATUS_AR <> 'S' OR A.STATUS_AR IS NULL) OR 
(A.STATUS_RECEIPT <> 'S' OR A.STATUS_RECEIPT IS NULL)) -- OR 
-- (A.STATUS_AP <> 'S' OR A.STATUS_AP IS NULL))
ORDER BY A.NO_INVOICE ASC LIMIT 200";
$Query = $conn->query($SQL);
if ($Query->size() > 0) {
	$message = '<?xml version="1.0" encoding="UTF-8"?>';
	$message .= '<root>';
	$message .= '<group>';
	while ($Query->next()) {
		$ID = $Query->get("ID");
		$NO_INVOICE = $Query->get("NO_INVOICE");
		$message .= '<transaction_number>'. $NO_INVOICE .'</transaction_number>';
	}
	$message .= '</group>';
	$message .= '</root>';
	$xmlRequest = $message;
} else {
	$SQL = "SELECT A.ID,A.NO_INVOICE
	FROM t_billing_cfshdr A INNER JOIN t_order_hdr B ON A.NO_ORDER = B.NO_ORDER
	INNER JOIN t_edc_payment_bank C ON A.NO_INVOICE = C.NO_INVOICE
	WHERE A.IS_SENDSIMKEU = '300' AND (A.STATUS_AP <> 'S' OR A.STATUS_AP IS NULL)
	ORDER BY A.NO_INVOICE ASC LIMIT 200";
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {
		$message = '<?xml version="1.0" encoding="UTF-8"?>';
		$message .= '<root>';
		$message .= '<group>';
		while ($Query->next()) {
			$ID = $Query->get("ID");
			$NO_INVOICE = $Query->get("NO_INVOICE");
			$message .= '<transaction_number>'. $NO_INVOICE .'</transaction_number>';
		}
		$message .= '</group>';
		$message .= '</root>';
		$xmlRequest = $message;
	} else {
		$xmlRequest = 'Data Tidak Ada';
		echo $xmlRequest;
	}
}

$xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
				<soapenv:Header/>
					<soapenv:Body>
					   <ser:getMessage soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
						  <in_param xsi:type="xsd:string"><![CDATA['.$xmlRequest.']]></in_param>
					   </ser:getMessage>
					</soapenv:Body>
				 </soapenv:Envelope>';
$Send = $main->SendCurl($xml, 'http://103.19.80.243/cfs_dev/server.php', $SOAPAction);
//RESPONSE
if ($Send['response'] != '') {
	echo $Send['response'];
	$arr1 = 'ns1:getMessageResponse';
	$arr2 = 'return';
	$response = xml2ary($Send['response']);
	$response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
	$xml = xml2ary($response);
	if($response != 'Data Tidak Ada'){
		$root = $xml['root']['_c'];
		$group = $root['group']['_c'];
		
		$countgroup = count($group);
		$component = $group['component'];
		$countcomponent = count($component);
		if ($countcomponent > 1) {
			//loop
			for ($i=0; $i < $countcomponent; $i++) { 
				$istrue = "true";
				$message = "";
				$transaction = $component[$i]['_c']['transaction']['_c'];
				$transaction_numbertrx = trim($transaction['transaction_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['transaction_number']['_v'])) . "'";
				$statustrx = trim($transaction['status']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['status']['_v'])) . "'";
				$messagetrx = trim($transaction['message']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($transaction['message']['_v']))) . "'";
				$istrue .= $statustrx == "F" ? "false" : "true";
				$message .= $messagetrx.",";

				$receipt = $component[$i]['_c']['receipt']['_c'];
				$receipt_number = trim($receipt['receipt_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($receipt['receipt_number']['_v'])) . "'";
				$statusrcpt = trim($receipt['status']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($receipt['status']['_v'])) . "'";
				$messagercpt = trim($receipt['message']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($receipt['message']['_v']))) . "'";
				$istrue .= $statusrcpt == "F" ? "false" : "true";
				$message .= $messagercpt.",";

				$payable = $component[$i]['_c']['payable']['_c'];
				$transaction_numberpay = trim($payable['transaction_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($payable['transaction_number']['_v'])) . "'";
				$statuspay = trim($payable['status']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($payable['status']['_v'])) . "'";
				$messagepay = trim($payable['message']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($payable['message']['_v']))) . "'";
				$istrue .= $statuspay == "F" ? "false" : "true";
				$message .= $messagepay;

				
				$SQL = "UPDATE t_billing_cfshdr SET STATUS_AR = ".$statustrx.", STATUS_RECEIPT = ".$statusrcpt.", STATUS_AP = ".$statuspay.", MESSAGE_AR = ". $messagetrx .", MESSAGE_RECEIPT = ". $messagercpt .", MESSAGE_AP = ". $messagepay ." WHERE NO_INVOICE = " . $transaction_numbertrx . "";
				$Execute = $conn->execute($SQL);
			}
			
		}elseif ($countcomponent == 1) {
			$istrue = "true";
			$message = "";
			$transaction = $component['_c']['transaction']['_c'];
			$transaction_numbertrx = trim($transaction['transaction_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['transaction_number']['_v'])) . "'";
			$statustrx = trim($transaction['status']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['status']['_v'])) . "'";
			$messagetrx = trim($transaction['message']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($transaction['message']['_v']))) . "'";
			$istrue .= $statustrx == "F" ? "false" : "true";
			$message .= $messagetrx.",";

			$receipt = $component['_c']['receipt']['_c'];
			$receipt_number = trim($receipt['receipt_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($receipt['receipt_number']['_v'])) . "'";
			$statusrcpt = trim($receipt['status']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($receipt['status']['_v'])) . "'";
			$messagercpt = trim($receipt['message']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($receipt['message']['_v']))) . "'";
			$istrue .= $statusrcpt == "F" ? "false" : "true";
			$message .= $messagercpt.",";

			$payable = $component['_c']['payable']['_c'];
			$transaction_numberpay = trim($payable['transaction_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($payable['transaction_number']['_v'])) . "'";
			$statuspay = trim($payable['status']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($payable['status']['_v'])) . "'";
			$messagepay = trim($payable['message']['_v']) == "" ? "NULL" : "'" . mysql_real_escape_string(strtoupper(trim($payable['message']['_v']))) . "'";
			$istrue .= $statuspay == "F" ? "false" : "true";
			$message .= $messagepay;
			
			$SQL = "UPDATE t_billing_cfshdr SET STATUS_AR = ".$statustrx.", STATUS_RECEIPT = ".$statusrcpt.", STATUS_AP = ".$statuspay.", MESSAGE_AR = ". $messagetrx .", MESSAGE_RECEIPT = ". $messagercpt .", MESSAGE_AP = ". $messagepay ." WHERE NO_INVOICE = " . $transaction_numbertrx . "";
			$Execute = $conn->execute($SQL);			
		}
		$KODE = '200';
	}
} else {
	$response = 'Tidak Dapat Respon';
	$KODE = '100';
	echo $response;
}

$ipAddress = $ip;
$userName = 'SIMKEU';
$Password = 'SIMKEU';
$url = 'http://ipccfscenter.com/TPSServices/GetResponSimkeu.php';
$method = 'getTransaction';
$KdAPRF = 'SENTSIMKEU';
if($xmlRequest != 'Data Tidak Ada'){
	$SQL = "INSERT INTO mailbox(SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER, STR_DATA, KD_STATUS, TGL_STATUS)
			VALUES (NULL, '" . $KdAPRF . "','1','1','" . mysql_real_escape_string($response) . "','".$KODE."',NOW())";
	$Execute = $conn->execute($SQL);
	if(!$Execute){
		echo 'mailbox = '.mysql_error();
	}

	$SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
			VALUES ('" . $userName . "','" . $Password . "','" . $url . "','" . $method . "','" . mysql_real_escape_string($xmlRequest) . "','" . mysql_real_escape_string($response) . "','" . $ipAddress . "', NOW())";
	$Execute = $conn->execute($SQL);
	if(!$Execute){
		echo 'app_log_services = '.mysql_error();
	}		
}else{
	$SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
			VALUES ('" . $userName . "','" . $Password . "','" . $url . "','" . $method . "','" . mysql_real_escape_string($xmlRequest) . "','" . mysql_real_escape_string($response) . "','" . $ipAddress . "', NOW())";
	$Execute = $conn->execute($SQL);
	if(!$Execute){
		echo 'app_log_services = '.mysql_error();
	}
}
//END

$main->connect(false);
?>