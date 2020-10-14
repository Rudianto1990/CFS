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
$err=0;
//BEGIN
$SOAPAction = 'urn:portalintegrasiipc#pollServer'; 
/* $SQL = "SELECT A.ID, A.JENIS_BILLING, A.NO_ORDER,A.NO_INVOICE, C.BANK, B.CUSTOMER_NUMBER AS ID_ORGANISASI,
IFNULL(B.NAMA_FORWARDER,B.CONSIGNEE) AS NAMA, IFNULL(B.ALAMAT_FORWARDER,B.ALAMAT_CONSIGNEE) AS ALAMAT,
IFNULL(B.NPWP_FORWARDER,B.NPWP_CONSIGNEE) AS NPWP, A.SUBTOTAL, A.PPN, A.TOTAL, 
DATE_FORMAT(C.TGL_TERIMA, '%d/%m/%Y %H:%i:%s') AS TGL_TERIMA, C.APPR_CODE, C.REFF_NO, B.NM_ANGKUT, 
B.NO_VOYAGE, DATE_FORMAT(B.TGL_TIBA, '%d/%m/%Y') AS TGL_TIBA, B.NO_DO, B.NO_BL_AWB, 
func_name(B.KD_GUDANG_TUJUAN, 'GUDANG') AS GUDANG_TUJUAN, B.KD_GUDANG_TUJUAN, 
DATE_FORMAT(B.TGL_KELUAR, '%d/%m/%Y') AS TGL_KELUAR,A.STATUS_AR,A.STATUS_RECEIPT,A.STATUS_AP
FROM t_billing_cfshdr A INNER JOIN t_order_hdr B ON A.NO_ORDER = B.NO_ORDER
INNER JOIN t_edc_payment_bank C ON A.NO_INVOICE = C.NO_INVOICE
WHERE A.IS_SENDSIMKEU = '300' AND-- (A.STATUS_AR <> 'S' OR A.STATUS_AR IS NULL)-- OR 
-- (A.STATUS_RECEIPT <> 'S' OR A.STATUS_RECEIPT IS NULL) OR 
(A.STATUS_AP <> 'S' OR A.STATUS_AP IS NULL)
ORDER BY A.NO_INVOICE ASC LIMIT 10";
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
	//echo $xmlRequest;
} */
//print_r($xmlRequest);die();
$xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
				<soapenv:Header/>
					<soapenv:Body>
					   <ser:getAP soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
						  <in_param xsi:type="xsd:string">tes</in_param>
					   </ser:getAP>
					</soapenv:Body>
				 </soapenv:Envelope>';
$Send = $main->SendCurl($xml, 'http://103.19.80.243/cfs_dev/server.php', $SOAPAction);
//RESPONSE
if ($Send['response'] != '') {
	//echo $Send['response'];
	$arr1 = 'ns1:getAPResponse';
	$arr2 = 'return';
	$response = xml2ary($Send['response']);
	$response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
	//print_r($response);die();
	$xml = xml2ary($response);
	//print_r($xml);die();
	if($response != 'Data Tidak Ada'){
		$root = $xml['root']['_c'];
		//print_r($root);die();
		$group = $root['group']['_c'];
		
		$countgroup = count($group);
		$component = $group['component'];
		$countcomponent = count($component);
		//print_r($countcomponent);die();
		if ($countcomponent > 1) {
			//loop
			for ($i=0; $i < $countcomponent; $i++) { 
				$istrue = "true";
				$message = "";
				$transaction = $component[$i]['_c'];
				//print_r($transaction);die();
				$invoice_number = trim($transaction['invoice_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['invoice_number']['_v'])) . "'";
				$invoice_date = trim($transaction['invoice_date']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($transaction['invoice_date']['_v'])) . "','%d-%b-%y')";
				$gl_date_invoice = trim($transaction['gl_date_invoice']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($transaction['gl_date_invoice']['_v'])) . "','%d-%b-%y')";
				$invoice_created_by = trim($transaction['invoice_created_by']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['invoice_created_by']['_v'])) . "'";
				$vendor_number = trim($transaction['vendor_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['vendor_number']['_v'])) . "'";
				$vendor_name = trim($transaction['vendor_name']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['vendor_name']['_v'])) . "'";
				$vendor_site_code = trim($transaction['vendor_site_code']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['vendor_site_code']['_v'])) . "'";
				$bank_name = trim($transaction['bank_name']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['bank_name']['_v'])) . "'";
				$bank_account = trim($transaction['bank_account']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['bank_account']['_v'])) . "'";
				$payment_number = trim($transaction['payment_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['payment_number']['_v'])) . "'";
				$payment_date = trim($transaction['payment_date']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($transaction['payment_date']['_v'])) . "','%d-%b-%y')";
				$gl_date_payment = trim($transaction['gl_date_payment']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($transaction['gl_date_payment']['_v'])) . "','%d-%b-%y')";
				$payment_created_by = trim($transaction['payment_created_by']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['payment_created_by']['_v'])) . "'";
				$currency_code = trim($transaction['currency_code']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['currency_code']['_v'])) . "'";
				$amount_paid = trim($transaction['amount_paid']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['amount_paid']['_v'])) . "'";
				
				$SQLDel = "DELETE FROM xpi2_ap_payment_priok_v WHERE INVOICE_NUMBER = ". $invoice_number ."";
				//echo $SQL;
				$ExecuteDel = $conn->execute($SQLDel);
				if(!$ExecuteDel){
					$err++;
					$err_message = 'delete error '.mysql_error();
				}

				$SQL = "INSERT INTO xpi2_ap_payment_priok_v(INVOICE_NUMBER,INVOICE_DATE,GL_DATE_INVOICE,INVOICE_CREATED_BY,VENDOR_NUMBER,VENDOR_NAME,VENDOR_SITE_CODE,BANK_NAME
				,BANK_ACCOUNT,PAYMENT_NUMBER,PAYMENT_DATE,GL_DATE_PAYMENT,PAYMENT_CREATED_BY,CURRENCY_CODE,AMOUNT_PAID) 
				VALUES (". $invoice_number .",". $invoice_date .",". $gl_date_invoice .",". $invoice_created_by .",". $vendor_number .",". $vendor_name .",". $vendor_site_code .",
				". $bank_name .",". $bank_account .",". $payment_number .",". $payment_date .",". $gl_date_payment .",". $payment_created_by .",". $currency_code .",
				". $amount_paid .")";
				//echo $SQL;
				$Execute = $conn->execute($SQL);
				if(!$Execute){
					$err++;
					$err_message = 'insert error '.mysql_error();
				}
			}
			
		}elseif ($countcomponent == 1) {
			$istrue = "true";
			$message = "";
			$transaction = $component['_c'];
			$invoice_number = trim($transaction['invoice_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['invoice_number']['_v'])) . "'";
			$invoice_date = trim($transaction['invoice_date']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($transaction['invoice_date']['_v'])) . "','%d-%b-%y')";
			$gl_date_invoice = trim($transaction['gl_date_invoice']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($transaction['gl_date_invoice']['_v'])) . "','%d-%b-%y')";
			$invoice_created_by = trim($transaction['invoice_created_by']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['invoice_created_by']['_v'])) . "'";
			$vendor_number = trim($transaction['vendor_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['vendor_number']['_v'])) . "'";
			$vendor_name = trim($transaction['vendor_name']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['vendor_name']['_v'])) . "'";
			$vendor_site_code = trim($transaction['vendor_site_code']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['vendor_site_code']['_v'])) . "'";
			$bank_name = trim($transaction['bank_name']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['bank_name']['_v'])) . "'";
			$bank_account = trim($transaction['bank_account']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['bank_account']['_v'])) . "'";
			$payment_number = trim($transaction['payment_number']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['payment_number']['_v'])) . "'";
			$payment_date = trim($transaction['payment_date']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($transaction['payment_date']['_v'])) . "','%d-%b-%y')";
			$gl_date_payment = trim($transaction['gl_date_payment']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($transaction['gl_date_payment']['_v'])) . "','%d-%b-%y')";
			$payment_created_by = trim($transaction['payment_created_by']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['payment_created_by']['_v'])) . "'";
			$currency_code = trim($transaction['currency_code']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['currency_code']['_v'])) . "'";
			$amount_paid = trim($transaction['amount_paid']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($transaction['amount_paid']['_v'])) . "'";
			
			$SQLDel = "DELETE FROM xpi2_ap_payment_priok_v WHERE INVOICE_NUMBER = ". $invoice_number ."";
			//echo $SQL;
			$ExecuteDel = $conn->execute($SQLDel);
			if(!$ExecuteDel){
				$err++;
				$err_message = 'delete error '.mysql_error();
			}

			$SQL = "INSERT INTO xpi2_ap_payment_priok_v(INVOICE_NUMBER,INVOICE_DATE,GL_DATE_INVOICE,INVOICE_CREATED_BY,VENDOR_NUMBER,VENDOR_NAME,VENDOR_SITE_CODE,BANK_NAME
			,BANK_ACCOUNT,PAYMENT_NUMBER,PAYMENT_DATE,GL_DATE_PAYMENT,PAYMENT_CREATED_BY,CURRENCY_CODE,AMOUNT_PAID) 
			VALUES (". $invoice_number .",". $invoice_date .",". $gl_date_invoice .",". $invoice_created_by .",". $vendor_number .",". $vendor_name .",". $vendor_site_code .",
			". $bank_name .",". $bank_account .",". $payment_number .",". $payment_date .",". $gl_date_payment .",". $payment_created_by .",". $currency_code .",
			". $amount_paid .")";
			//echo $SQL;
			$Execute = $conn->execute($SQL);
			if(!$Execute){
				$err++;
				$err_message = 'insert error '.mysql_error();
			} 
		}
		$KODE = '200';
	}
} else {
	//print_r($Send);die();
	$response = 'Tidak Dapat Respon';
	$KODE = '100';
	$err++;
	$err_message = $response;
}

$ipAddress = $ip;
$userName = 'SIMKEU';
$Password = 'SIMKEU';
$url = 'http://ipccfscenter.com/TPSServices/GetAP.php';
$method = 'getAP';
$KdAPRF = 'SENTSIMKEU';
if($xmlRequest != 'Data Tidak Ada'){
	$SQL = "INSERT INTO mailbox(SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER, STR_DATA, KD_STATUS, TGL_STATUS)
			VALUES (NULL, '" . $KdAPRF . "','1','1','" . mysql_real_escape_string($response) . "','".$KODE."',NOW())";
	$Execute = $conn->execute($SQL);
	if(!$Execute){
		$err++;
		$err_message = 'mailbox = '.mysql_error();
	}

	$SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
			VALUES ('" . $userName . "','" . $Password . "','" . $url . "','" . $method . "','" . mysql_real_escape_string($xmlRequest) . "','" . mysql_real_escape_string($response) . "','" . $ipAddress . "', NOW())";
	$Execute = $conn->execute($SQL);
	if(!$Execute){
		$err++;
		$err_message = 'app_log_services = '.mysql_error();
	}		
}
//END
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http"); 
$base_url .= "://".$_SERVER['HTTP_HOST']; 
if($err>0)
	echo "MSG#ERR#" . $$err_message . "#";
else
	echo "MSG#OK#Berhasil update data#".$base_url."/index.php/report/laporanAP/post";
$main->connect(false);
?>