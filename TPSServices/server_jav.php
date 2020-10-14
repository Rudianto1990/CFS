<?php

ob_start();
// call library
require_once ('config.php' );
//require_once ($CONF['root.dir'].'Libraries/soaplib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/nusoap-lokal/lib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

// create instance
$server = new soap_server();

// initialize WSDL support
$server->configureWSDL('CFSwsdl', 'urn:CFSwsdl');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'urn:sendCFSwsdl';

// register method
$server->register('getDataBilling', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:getDataBillingwsdl', // namespace
        'urn:getDataBillingwsdl#getDataBilling', // soapaction
        'rpc', // style
        'encoded', // use
        'getDataBilling'// documentation
);

$server->register('getDataVoid', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:getDataVoidwsdl', // namespace
        'urn:getDataVoidwsdl#getDataVoid', // soapaction
        'rpc', // style
        'encoded', // use
        'getDataVoid'// documentation
);

$server->register('insertEDC', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:insertEDCwsdl', // namespace
        'urn:insertEDCwsdl#insertEDC', // soapaction
        'rpc', // style
        'encoded', // use
        'insertEDC'// documentation
);

$server->register('voidEDC', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:voidEDCwsdl', // namespace
        'urn:voidEDCwsdl#voidEDC', // soapaction
        'rpc', // style
        'encoded', // use
        'voidEDC'// documentation
);

$server->register('getQueueBilling', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:getQueueBillingwsdl', // namespace
        'urn:getQueueBillingwsdl#getQueueBilling', // soapaction
        'rpc', // style
        'encoded', // use
        'getQueueBilling'// documentation
);

$server->register('getQueueCS', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:getQueueCSwsdl', // namespace
        'urn:getQueueCSwsdl#getQueueCS', // soapaction
        'rpc', // style
        'encoded', // use
        'getQueueCS'// documentation
);

$server->register('QueueBilling', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:QueueBillingwsdl', // namespace
        'urn:QueueBillingwsdl#QueueBilling', // soapaction
        'rpc', // style
        'encoded', // use
        'QueueBilling'// documentation
);

$server->register('QueueCS', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:QueueCSwsdl', // namespace
        'urn:QueueCSwsdl#QueueCS', // soapaction
        'rpc', // style
        'encoded', // use
        'QueueCS'// documentation
);

$server->register('DisplayQueue', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:DisplayQueuewsdl', // namespace
        'urn:DisplayQueuewsdl#DisplayQueue', // soapaction
        'rpc', // style
        'encoded', // use
        'DisplayQueue'// documentation
);

$server->register('CheckConnection', // method name
        array('String0' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:CheckConnectionwsdl', // namespace
        'urn:CheckConnectionwsdl#CheckConnection', // soapaction
        'rpc', // style
        'encoded', // use
        'CheckConnection'// documentation
);

$server->register('LoadBillingGudang', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('LoadBillingGudangResult' => 'xsd:string'), // output
        'urn:LoadBillingGudangwsdl', // namespace
        'urn:TPSServices#LoadBillingGudang', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk pengiriman data billing dari Gudang'// documentation
);

$server->register('UploadCustomerData', // method name
        array('fStream' => 'xsd:string', 'Type' => 'xsd:string'),
        // input parameter
        array('UploadCustomerDataResult' => 'xsd:string'), // output
        'urn:UploadCustomerDatawsdl', // namespace
        'urn:TPSServices#UploadCustomerData', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk Upload data Costumer dari CDM ke CFS Portal '// documentation
);

function LoadBillingGudang($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    // print_r("ok");die();
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'LoadBillingGudang', $fStream);
	if($Username=="TES" && $Password=="TES"){
		return $fStream;
	}

    $STR_DATA = $fStream;
    $message = '<?xml version="1.0" encoding="UTF-8"?>';
    $message .= '<DOCUMENT>';
    $xml = xml2ary($STR_DATA);
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        $countBilling = 0;
        $countBilling = count($xml['LOADBILLINGGUDANG']);
        if ($countBilling > 1) {
            for ($c = 0; $c < $countBilling; $c++) {
                $billing = $xml['LOADBILLINGGUDANG'][$c]['_c'];
                $message .= insertorder($billing, $IDLogServices);
            }
        } elseif ($countBilling == 1) {
            $billing = $xml['LOADBILLINGGUDANG']['_c'];
            $message .= insertorder($billing, $IDLogServices);
        } else {
            $message .= '<LOADBILLING>';
            $message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
            $message .= '</LOADBILLING>';
        }
    } else {
        $message .= '<LOADBILLING>';
        $message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
        $message .= '</LOADBILLING>';
    }
    $message .= '</DOCUMENT>';
    $return = $message;
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function CheckConnection($String0) {
    $return = '<?xml version="1.0"?>
				   <DOCUMENT>	
						<SPJM>		
							<RESULT>TRUE</RESULT>
							<MESSAGES>Connection Success. Parameter : ' . $String0 . '</MESSAGES>
						</SPJM>	
				   </DOCUMENT>';
    // $return = "test";
    return $return;
}

function voidEDC($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'voidEDC', $fStream);
    $xml = str_replace('&', '', $fStream);
    $STR_DATA = $fStream;
    $xml = xml2ary($STR_DATA);
    // print_r($xml);die();
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        // print_r($xml);die();
        $OrderPB = $xml['VOIDEDC']['_c'];
        // print_r($OrderPB);die();
        $NO_PROFORMA_INVOICE = trim($OrderPB['NO_PROFORMA_INVOICE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['NO_PROFORMA_INVOICE']['_v'])) . "";
        $USERNAME = trim($OrderPB['USERNAME']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['USERNAME']['_v'])) . "";
        // print_r($NO_ORDER);die();
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $SQLUpdatePayment = "UPDATE t_billing_cfshdr SET IS_VOID = 'X', VOID_BY = '". $USERNAME ."', TGL_VOID = NOW() WHERE NO_PROFORMA_INVOICE = '". $NO_PROFORMA_INVOICE ."'";
        $Execute = $conn->execute($SQLUpdatePayment);
        $SQLUpdatePayment1 = "UPDATE t_edc_payment_bank SET IS_VOID = 'X' WHERE NO_PROFORMA_INVOICE = '". $NO_PROFORMA_INVOICE ."'";
        $Execute1 = $conn->execute($SQLUpdatePayment1);
        if($Execute){
            if($Execute1){
                $message .= '<STATUS>TRUE</STATUS>';
                $message .= '<MESSAGE>SUKSES</MESSAGE>';
				$SQLUpdateOrder = "UPDATE t_order_hdr A JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER SET A.KD_STATUS = '800' WHERE B.NO_PROFORMA_INVOICE = '". $NO_PROFORMA_INVOICE ."'";
				$Execute2 = $conn->execute($SQLUpdateOrder);
            }else{
				$message .= '<STATUS>FALSE</STATUS>';
				$message .= '<MESSAGE>'.$SQLUpdatePayment1.'</MESSAGE>';
            }
        }else{
			$message .= '<STATUS>FALSE</STATUS>';
			$message .= '<MESSAGE>'.$SQLUpdatePayment.'</MESSAGE>';
        }
        $message .= '</DOCUMENT>';
    }


    $og = simplexml_load_string($message);

    $return = json_encode($og);
    // print_r($return);die();
    updateLogServices($IDLogServices, $return);
    // $return = $message;
    $conn->disconnect();
    return $return;
}

function insertEDC($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'insertEDC', $fStream);
    $xml = str_replace('&', '', $fStream);
    $STR_DATA = $fStream;
    $xml = xml2ary($STR_DATA);
	$null_response=0;
    // print_r($xml);die();
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        // print_r($xml);die();
        $OrderPB = $xml['INSERTEDC']['_c'];
        // print_r($OrderPB);die();
        $NO_ORDER = trim($OrderPB['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['NO_ORDER']['_v'])) . "";
        $BANK = trim($OrderPB['BANK']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['BANK']['_v'])) . "";
        $NAMA_PEMILIK = trim($OrderPB['NAMA_PEMILIK']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['NAMA_PEMILIK']['_v'])) . "";
        $NPWP_PEMILIK = trim($OrderPB['NPWP_PEMILIK']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['NPWP_PEMILIK']['_v'])) . "";
        $AMOUNT = trim($OrderPB['AMOUNT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['AMOUNT']['_v'])) . "";
        $TGL_PEMILIK = trim($OrderPB['TGL_PEMILIK']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['TGL_PEMILIK']['_v'])) . "";
        $REFF_NO = trim($OrderPB['REFF_NO']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['REFF_NO']['_v'])) . "";
        $TRACE_NO = trim($OrderPB['TRACE_NO']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['TRACE_NO']['_v'])) . "";
        $APPR_CODE = trim($OrderPB['APPR_CODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['APPR_CODE']['_v'])) . "";
        $TID = trim($OrderPB['TID']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['TID']['_v'])) . "";
        $POS_APP = trim($OrderPB['POS_APP']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['POS_APP']['_v'])) . "";
        $USERNAME = trim($OrderPB['USERNAME']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['USERNAME']['_v'])) . "";
        // print_r($NO_ORDER);die();
        $SQLHeader = "SELECT A.ID AS ID, A.TOTAL AS TOTAL, A.NO_PROFORMA_INVOICE AS NO_PROFORMA_INVOICE 
                    FROM t_billing_cfshdr A WHERE A.NO_ORDER = '". $NO_ORDER ."' AND A.KD_ALASAN_BILLING = 'ACCEPT' AND A.FLAG_APPROVE = 'Y' ORDER BY A.ID DESC LIMIT 1";
        // print_r($SQLHeader);die();
        $QueryHeader = $conn->query($SQLHeader);

        // $SQLUser = "SELECT A.ID_USER FROM t_order_hdr A WHERE A.NO_ORDER = '". $NO_ORDER ."'";
        // $QueryUser = $conn->query($SQLUser);
        // $QueryUser->next();
        // $ID_USER = $QueryUser->get("ID_USER");

        if ($QueryHeader->size() > 0) {
			$null_response=1;
            $QueryHeader->next();
            $ID = $QueryHeader->get("ID");
            $NO_PROFORMA_INVOICE = $QueryHeader->get("NO_PROFORMA_INVOICE");
			do{
				$cekinverror=0;
				$SQLinv = "SELECT substr(A.NO_INVOICE, 15) AS NO_INVOICE, A.NO_INVOICE AS INVOICE_BEF FROM t_edc_payment_bank A WHERE A.ID = (SELECT MAX(ID) FROM t_edc_payment_bank)";
				// print_r($SQLHeader);die();
				$Queryinv = $conn->query($SQLinv);
				if($Queryinv->size() > 0){
					$Queryinv->next();
					$invbef = $Queryinv->get("NO_INVOICE");
					$cekinvbef = $Queryinv->get("INVOICE_BEF");
					$year = date('y');
					$yearsebelum = substr($cekinvbef,8,2);
					if($year>$yearsebelum){
						$invnew = "1";
					}else{
						$invnew = $invbef+1;
					}
				}else{
					$invnew = "1";
				}

				$SQLcheckRest = "SELECT A.EX_NOTA FROM t_order_hdr A WHERE A.NO_ORDER = '". $NO_ORDER ."'";
				$QuerycheckRest = $conn->query($SQLcheckRest);
				$QuerycheckRest->next();
				if($QuerycheckRest->get("EX_NOTA") != ''){
					$faktur = '011.010';
				}else{
					$faktur = '010.010';
				}
				

				// $faktur = '010.010';
				//$faktur = '011.010';
				$year = date('y');
				$layanan = '23';

				if ($invnew <= 9) {
					$inv = "00000";
				} else if (99 >= $invnew && $invnew > 9) {
					$inv = "0000";
				} else if (999 >= $invnew && $invnew > 99) {
					$inv = "000";
				} else if (9999 >= $invnew && $invnew > 999) {
					$inv = "00";
				} else if (99999 >= $invnew && $invnew > 9999) {
					$inv = "0";
				} else if (999999 >= $invnew && $invnew > 99999) {
					$inv = "";
				}
				
				$NOINV = $faktur."-".$year.".".$layanan.".".$inv.$invnew;

				$message = '<?xml version="1.0" encoding="UTF-8"?>';
				$message .= '<DOCUMENT>';
				$SQLEDCPayment = "INSERT INTO t_edc_payment_bank(BANK,NO_ORDER,NAMA_PEMILIK,NPWP_PEMILIK,AMOUNT,TGL_TERIMA,REFF_NO,TRACE_NO,APPR_CODE,NO_PROFORMA_INVOICE,NO_INVOICE,FL_EDC,TID,POS_APP) 
								VALUES('". $BANK ."','" .$NO_ORDER. "','".$NAMA_PEMILIK."','" .$NPWP_PEMILIK. "','" .$AMOUNT. "',STR_TO_DATE('". $TGL_PEMILIK ."', '%Y-%m-%d %H:%i:%s'),'" . $REFF_NO ."','" .$TRACE_NO . "','" . $APPR_CODE
								. "','" . $NO_PROFORMA_INVOICE ."','" .$NOINV. "','Y','". $TID ."','". $POS_APP ."')";
				$Execute = $conn->execute($SQLEDCPayment);
				if($Execute){
					$null_response=3;
					$cekinverror=0;
					$SP2 = substr($NO_ORDER, 12);
					$SQLUpdatePayment = "UPDATE t_billing_cfshdr SET STATUS_BAYAR='SETTLED', NO_INVOICE='" .$NOINV. "', NO_SP2='" .$SP2."' WHERE NO_ORDER='" .$NO_ORDER."' AND NO_PROFORMA_INVOICE = '". $NO_PROFORMA_INVOICE ."'";
					$Execute1 = $conn->execute($SQLUpdatePayment);

					if($Execute1){
						$null_response=5;
						$cekgudang = substr($NO_ORDER, 2, 2);
						if($cekgudang=="01"){
							$xml = '<?xml version="1.0" encoding="UTF-8"?>';
							$xml .= '<DOCUMENT>';
							$xml .= '<RESPONPEMBAYARANCFS>';
							$xml .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
							$xml .= '<NO_INVOICE>' . $NOINV . '</NO_INVOICE>';
							$xml .= '<TGL_BAYAR>' . $TGL_PEMILIK . '</TGL_BAYAR>';
							$xml .= '<TOTAL_BAYAR>' . $AMOUNT . '</TOTAL_BAYAR>';
							$xml .= '</RESPONPEMBAYARANCFS>';
							$xml .= '</DOCUMENT>';
							$WSDLSOAPAPW = 'Https://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
							//$WSDLSOAPAPW = 'Http://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
							$IDLogResCFS = insertLogServices('RAYA', 'RAYA', $WSDLSOAPAPW, 'SendResponPembayaranCFS', $xml);
							$Send = SendCurl($xml, $WSDLSOAPAPW, '');
							if ($Send['return'] != FALSE) {
								$null_response='true return';
								if($Send['response'] != ''){
									$null_response='true response';
									$response = $Send['response'];
								}else{
									$null_response='empty';
									$response = 'Response is empty';
								}
								$SQL = "UPDATE t_billing_cfshdr SET FL_SEND='200' WHERE ID='". $ID ."'";
								$Execute = $conn->execute($SQL);
							} else {
								$null_response='false return';
								$response = 'Cannot get response; Error No '.implode("; ",$Send['errno']).'; '.implode("; ",$Send['info']);
							}
							//updateLogServices($IDLogResCFS, $response);
							if(!updateLogServices($IDLogResCFS, $response)){
								updateLogServices($IDLogResCFS, $null_response);
							}
						}
						$SQLUpdateOrder = "UPDATE t_order_hdr SET KD_STATUS = '700', TGL_STATUS = NOW() WHERE NO_ORDER='" .$NO_ORDER."'";
						$Execute2 = $conn->execute($SQLUpdateOrder);
						if($Execute2){
							$null_response='true';
							$message .= '<STATUS>TRUE</STATUS>';
							$message .= '<MESSAGE>SUKSES</MESSAGE>';
						}else{
							$null_response='false; '.$SQLUpdateOrder;
							$message .= '<STATUS>FALSE</STATUS>';
							$message .= '<MESSAGE>'.$SQLUpdateOrder.'</MESSAGE>';
						}
					}else{
						$null_response='false; '.$SQLUpdatePayment;
						$message .= '<STATUS>FALSE</STATUS>';
						$message .= '<MESSAGE>'.$SQLUpdatePayment.'</MESSAGE>';
					}
				}else{
					$null_response='false; '.$SQLEDCPayment;
					$message .= '<STATUS>FALSE</STATUS>';
					$message .= '<MESSAGE>'.$SQLEDCPayment.'</MESSAGE>';
					$cekinverror=mysql_errno();
				}
				$message .= '</DOCUMENT>';
			}while($cekinverror=="1062");
        } else {
			$null_response='false; '.$SQLHeader;
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<STATUS>FALSE</STATUS>';
            $message .= '<MESSAGE>' . $SQLHeader . '</MESSAGE>';
            $message .= '</DOCUMENT>';
        }    
    }


    $og = simplexml_load_string($message);

    $return = json_encode($og);
    // print_r($return);die();
	//updateLogServices($IDLogServices, $return);
    if(!updateLogServices($IDLogServices, $return)){
		updateLogServices($IDLogServices, $null_response);
	}

    $conn->disconnect();
    return $return;
}

function QueueBilling($Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'QueueBilling', $fStream);
    $SQLantrian = "SELECT MAX(CAST(SUBSTR(NO_ANTRIAN,3) AS UNSIGNED)) AS NO_ANTRIAN FROM t_antrian_hdr 
                WHERE NO_ANTRIAN LIKE '%B%' AND DATE_FORMAT(TANGGAL_ANTRIAN,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d')";
    $Queryantrian = $conn->query($SQLantrian);
    $Queryantrian->next();
    $antrianlama = $Queryantrian->get("NO_ANTRIAN");
    if ($antrianlama == null) {
        $antrianbaru = "B-1";
    }else{
        $iantrianbaru = $antrianlama+1;
        $antrianbaru = "B-".$iantrianbaru;
    }

    $SQLcount = "SELECT COUNT(FL_USED) AS JUMLAH FROM t_antrian_hdr 
                WHERE FL_USED = 'N' AND DATE_FORMAT(TANGGAL_ANTRIAN,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d') AND NO_ANTRIAN LIKE '%B%'";
    // print_r($SQLcount);die();
    $Querycount = $conn->query($SQLcount);
    $Querycount->next();
    $countantri = $Querycount->get("JUMLAH");
    // print_r($countantri);die();

    $SQLinsertantrian = "INSERT INTO t_antrian_hdr(NO_ANTRIAN) VALUES('". $antrianbaru ."')";
    $Execute = $conn->execute($SQLinsertantrian);
    if($Execute){
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<STATUS>TRUE</STATUS>';
        $message .= '<MESSAGE>SUKSES</MESSAGE>';
        $message .= '<NO_ANTRIAN>'. $antrianbaru .'</NO_ANTRIAN>';
        $message .= '<DIF_ANTRIAN>'. $countantri .'</DIF_ANTRIAN>';
        $message .= '</DOCUMENT>';
    }else{
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<STATUS>FALSE</STATUS>';
        $message .= '<MESSAGE>'. $SQLinsertantrian .'</MESSAGE>';
        $message .= '</DOCUMENT>';
    }

    $og = simplexml_load_string($message);

    $return = json_encode($og);
    // print_r($return);die();
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function UploadCustomerData($fStream, $Type) {
    global $CONF, $conn;
    //return "masuk sini";
    $conn->connect();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_plp.php';
    $IDLogServices = insertLogServices("CDM", $Type, $WSDLSOAP, 'UploadCustomerData', $fStream);

    $STR_DATA = $fStream;
    $message = '';$mess = array();
    $xml = xml2ary($STR_DATA);
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        $countCDM = 0;
        $countCDM = count($xml['CDM']);
        if ($countCDM > 1) {
            for ($c = 0; $c < $countCDM; $c++) {
                $CDM = $xml['CDM'][$c]['_c'];
                $mess[] = insertCDM($CDM, $Type, $IDLogServices);
            }
            $vals = array_count_values($mess);
            $message = 'Berhasil insert: '.$vals[1]." dari ".count($countCDM).' data';
        } elseif ($countCDM == 1) {
            $CDM = $xml['CDM']['_c'];
            $messa = insertCDM($CDM, $Type, $IDLogServices);
            if($messa == 1){
                $message = 'Berhasil insert data';
            }else{
                $message = 'Gagal insert data';
            }
        } else {
            $message = 'Format fStream SALAH!!!';
        }
    } else {
        $message = 'Format fStream SALAH!!!';
    }
    $return = $message; //"Proses Berhasil Tersimpan di Portal CFS";//$message;
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function QueueCS($Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'QueueCS', $fStream);
    $SQLantrian = "SELECT MAX(CAST(SUBSTR(NO_ANTRIAN,3) AS UNSIGNED)) AS NO_ANTRIAN FROM t_antrian_hdr 
                WHERE NO_ANTRIAN LIKE '%C%' AND DATE_FORMAT(TANGGAL_ANTRIAN,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d')";
    $Queryantrian = $conn->query($SQLantrian);
    $Queryantrian->next();
    $antrianlama = $Queryantrian->get("NO_ANTRIAN");
    if ($antrianlama == null) {
        $antrianbaru = "C-1";
    }else{
        $iantrianbaru = $antrianlama+1;
        $antrianbaru = "C-".$iantrianbaru;
    }

    $SQLcount = "SELECT COUNT(FL_USED) AS JUMLAH FROM t_antrian_hdr 
                WHERE FL_USED = 'N' AND DATE_FORMAT(TANGGAL_ANTRIAN,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d') AND NO_ANTRIAN LIKE '%C%'";
    $Querycount = $conn->query($SQLcount);
    $Querycount->next();
    $countantri = $Querycount->get("JUMLAH");

    $SQLinsertantrian = "INSERT INTO t_antrian_hdr(NO_ANTRIAN) VALUES('". $antrianbaru ."')";
    $Execute = $conn->execute($SQLinsertantrian);
    if($Execute){
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<STATUS>TRUE</STATUS>';
        $message .= '<MESSAGE>SUKSES</MESSAGE>';
        $message .= '<NO_ANTRIAN>'. $antrianbaru .'</NO_ANTRIAN>';
        $message .= '<DIF_ANTRIAN>'. $countantri .'</DIF_ANTRIAN>';
        $message .= '</DOCUMENT>';
    }else{
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<STATUS>FALSE</STATUS>';
        $message .= '<MESSAGE>'. $SQLinsertantrian .'</MESSAGE>';
        $message .= '</DOCUMENT>';
    }


    $og = simplexml_load_string($message);

    $return = json_encode($og);
    // print_r($return);die();
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function DisplayQueue($Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'DisplayQueue', $fStream);
    $message = '<?xml version="1.0" encoding="UTF-8"?>';
    $message .= '<DOCUMENT>';
    $message .= '<STATUS>TRUE</STATUS>';
    $message .= '<MESSAGE>SUKSES</MESSAGE>';
    $SQLloket1 = "SELECT NO_ANTRIAN FROM t_antrian_user WHERE KD_LOKET = 1";
    $Queryloket1 = $conn->query($SQLloket1);
    if ($Queryloket1->size() > 0) {
        $Queryloket1->next();
        $loket1 = $Queryloket1->get("NO_ANTRIAN");
        $message .= '<LOKET1>'. $loket1 .'</LOKET1>'; 
    }else{
        $message .= '<LOKET1>-</LOKET1>';
    }
    $SQLloket2 = "SELECT NO_ANTRIAN FROM t_antrian_user WHERE KD_LOKET = 2";
    $Queryloket2 = $conn->query($SQLloket2);
    if ($Queryloket2->size() > 0) {
        $Queryloket2->next();
        $loket2 = $Queryloket2->get("NO_ANTRIAN");
        $message .= '<LOKET2>'. $loket2 .'</LOKET2>'; 
    }else{
        $message .= '<LOKET2>-</LOKET2>';
    }
    $SQLloket3 = "SELECT NO_ANTRIAN FROM t_antrian_user WHERE KD_LOKET = 3";
    $Queryloket3 = $conn->query($SQLloket3);
    if ($Queryloket3->size() > 0) {
        $Queryloket3->next();
        $loket3 = $Queryloket3->get("NO_ANTRIAN");
        $message .= '<LOKET3>'. $loket3 .'</LOKET3>'; 
    }else{
        $message .= '<LOKET3>-</LOKET3>';
    }
    $SQLloket4 = "SELECT NO_ANTRIAN FROM t_antrian_user WHERE KD_LOKET = 4";
    $Queryloket4 = $conn->query($SQLloket4);
    if ($Queryloket4->size() > 0) {
        $Queryloket4->next();
        $loket4 = $Queryloket4->get("NO_ANTRIAN");
        $message .= '<LOKET4>'. $loket4 .'</LOKET4>'; 
    }else{
        $message .= '<LOKET4>-</LOKET4>';
    }
    $SQLloket5 = "SELECT NO_ANTRIAN FROM t_antrian_user WHERE KD_LOKET = 5";
    $Queryloket5 = $conn->query($SQLloket5);
    if ($Queryloket5->size() > 0) {
        $Queryloket5->next();
        $loket5 = $Queryloket5->get("NO_ANTRIAN");
        $message .= '<LOKET5>'. $loket5 .'</LOKET5>'; 
    }else{
        $message .= '<LOKET5>-</LOKET5>';
    }
    $SQLloket6 = "SELECT NO_ANTRIAN FROM t_antrian_user WHERE KD_LOKET = 6";
    $Queryloket6 = $conn->query($SQLloket6);
    if ($Queryloket6->size() > 0) {
        $Queryloket6->next();
        $loket6 = $Queryloket6->get("NO_ANTRIAN");
        $message .= '<LOKET6>'. $loket6 .'</LOKET6>'; 
    }else{
        $message .= '<LOKET6>-</LOKET6>';
    }
    $message .= '</DOCUMENT>';


    $og = simplexml_load_string($message);

    $return = json_encode($og);
    // print_r($return);die();
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function getDataBilling($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'getDataBilling', $fStream);
    $xml = str_replace('&', '', $fStream);
    $STR_DATA = $fStream;
    $xml = xml2ary($STR_DATA);
    // print_r($xml);die();
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        // print_r($xml);die();
        $OrderPB = $xml['TAGIHANEDC']['_c'];
        // print_r($OrderPB);die();
        $NO_ORDER = trim($OrderPB['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['NO_ORDER']['_v'])) . "";
        // print_r($NO_ORDER);die();
        $SQLHeader = "SELECT A.ID AS IDBILLING, B.ID AS IDORDER, A.JENIS_BILLING, A.NO_ORDER, IFNULL(B.CONSIGNEE,B.NPWP_FORWARDER) AS CONSIGNEE, IFNULL(B.NPWP_CONSIGNEE,B.NPWP_FORWARDER) AS NPWP_CONSIGNEE, B.NO_BL_AWB, A.SUBTOTAL, A.PPN, A.TOTAL, A.NO_PROFORMA_INVOICE
                FROM t_billing_cfshdr A INNER JOIN t_order_hdr B ON A.NO_ORDER = B.NO_ORDER
                WHERE A.NO_ORDER = '". $NO_ORDER ."' AND A.FLAG_APPROVE = 'Y' AND A.KD_ALASAN_BILLING = 'ACCEPT' AND 
                DATE_FORMAT(TGL_UPDATE,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d') AND NO_INVOICE IS NULL ORDER BY A.ID DESC LIMIT 1";
        // print_r($SQLHeader);die();
        $QueryHeader = $conn->query($SQLHeader);

        if ($QueryHeader->size() > 0) {
        	$message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<STATUS>TRUE</STATUS>';
            $message .= '<MESSAGE>SUKSES</MESSAGE>';
            $message .= '<HEADERFIELD>JENIS_BILLING,NO_ORDER,CONSIGNEE,NPWP_CONSIGNEE,NO_BL_AWB,SUBTOTAL,ADMINISTRASI,PPN,TOTAL</HEADERFIELD>';
            $message .= '<DETAILFIELD>NO_CONT,MRK_KMS,DESKRIPSI,QTY,SATUAN,TARIF_DASAR,TOTAL</DETAILFIELD>';
            $QueryHeader->next();
            $IDBILLING = $QueryHeader->get("IDBILLING");
            $IDORDER = $QueryHeader->get("IDORDER");
            $JENIS_BILLING = $QueryHeader->get("JENIS_BILLING");
            $NO_ORDER = $QueryHeader->get("NO_ORDER");
            $CONSIGNEE = $QueryHeader->get("CONSIGNEE");
            $NPWP_CONSIGNEE = $QueryHeader->get("NPWP_CONSIGNEE");
            $NO_BL_AWB = $QueryHeader->get("NO_BL_AWB");
            $SUBTOTAL = $QueryHeader->get("SUBTOTAL");
            $ADMINISTRASI = $QueryHeader->get("ADMINISTRASI");
            $PPN = $QueryHeader->get("PPN");
            $TOTAL = $QueryHeader->get("TOTAL");
            $NO_PROFORMA_INVOICE = $QueryHeader->get("NO_PROFORMA_INVOICE");

            // $message .= '<HEADER>';

            $message .= '<JENIS_BILLING>' . $JENIS_BILLING . '</JENIS_BILLING>';
            $message .= '<IDBILLING>' . $IDBILLING . '</IDBILLING>';
            $message .= '<IDORDER>' . $IDORDER . '</IDORDER>';
            $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
        	$message .= '<CONSIGNEE>' . htmlspecialchars($CONSIGNEE) . '</CONSIGNEE>';
        	$message .= '<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>';
            $message .= '<NO_BL_AWB>' . htmlspecialchars($NO_BL_AWB) . '</NO_BL_AWB>';
            $message .= '<SUBTOTAL>' . $SUBTOTAL . '</SUBTOTAL>';
            $message .= '<ADMINISTRASI>' . $ADMINISTRASI . '</ADMINISTRASI>';
            $message .= '<PPN>' . $PPN . '</PPN>';
            $message .= '<TOTAL>' . $TOTAL . '</TOTAL>';
            $message .= '<NO_PROFORMA_INVOICE>' . $NO_PROFORMA_INVOICE . '</NO_PROFORMA_INVOICE>';
            $message .= '</DOCUMENT>';
        } else {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<STATUS>FALSE</STATUS>';
            $message .= '<MESSAGE>' . $SQLHeader . '</MESSAGE>';
            $message .= '</DOCUMENT>';
        }    
    }


    $og = simplexml_load_string($message);

    $return = json_encode($og);
    // print_r($return);die();
    updateLogServices($IDLogServices, $return);
    // $return = $message;
    $conn->disconnect();
    return $return;
}

function getDataVoid($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'getDataVoid', $fStream);
    $xml = str_replace('&', '', $fStream);
    $STR_DATA = $fStream;
    $xml = xml2ary($STR_DATA);
    // print_r($xml);die();
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        // print_r($xml);die();
        $OrderPB = $xml['TAGIHANEDC']['_c'];
        // print_r($OrderPB);die();
        $NO_ORDER = trim($OrderPB['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['NO_ORDER']['_v'])) . "";
        // print_r($NO_ORDER);die();
        $SQLHeader = "SELECT A.ID AS IDBILLING, B.ID AS IDORDER, A.JENIS_BILLING, A.NO_ORDER, IFNULL(B.CONSIGNEE,B.NPWP_FORWARDER) AS CONSIGNEE, IFNULL(B.NPWP_CONSIGNEE,B.NPWP_FORWARDER) AS NPWP_CONSIGNEE, B.NO_BL_AWB, A.SUBTOTAL, A.PPN, A.TOTAL, A.NO_PROFORMA_INVOICE
                FROM t_billing_cfshdr A INNER JOIN t_order_hdr B ON A.NO_ORDER = B.NO_ORDER
                WHERE A.NO_ORDER = '". $NO_ORDER ."' AND A.FLAG_APPROVE = 'Y' AND A.KD_ALASAN_BILLING = 'ACCEPT' AND A.IS_VOID IS NULL ORDER BY A.ID DESC LIMIT 1";
        // print_r($SQLHeader);die();
        $QueryHeader = $conn->query($SQLHeader);

        if ($QueryHeader->size() > 0) {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<STATUS>TRUE</STATUS>';
            $message .= '<MESSAGE>SUKSES</MESSAGE>';
            $message .= '<HEADERFIELD>JENIS_BILLING,NO_ORDER,CONSIGNEE,NPWP_CONSIGNEE,NO_BL_AWB,SUBTOTAL,ADMINISTRASI,PPN,TOTAL</HEADERFIELD>';
            $message .= '<DETAILFIELD>NO_CONT,MRK_KMS,DESKRIPSI,QTY,SATUAN,TARIF_DASAR,TOTAL</DETAILFIELD>';
            $QueryHeader->next();
            $IDBILLING = $QueryHeader->get("IDBILLING");
            $IDORDER = $QueryHeader->get("IDORDER");
            $JENIS_BILLING = $QueryHeader->get("JENIS_BILLING");
            $NO_ORDER = $QueryHeader->get("NO_ORDER");
            $CONSIGNEE = $QueryHeader->get("CONSIGNEE");
            $NPWP_CONSIGNEE = $QueryHeader->get("NPWP_CONSIGNEE");
            $NO_BL_AWB = $QueryHeader->get("NO_BL_AWB");
            $SUBTOTAL = $QueryHeader->get("SUBTOTAL");
            $ADMINISTRASI = $QueryHeader->get("ADMINISTRASI");
            $PPN = $QueryHeader->get("PPN");
            $TOTAL = $QueryHeader->get("TOTAL");
            $NO_PROFORMA_INVOICE = $QueryHeader->get("NO_PROFORMA_INVOICE");

            // $message .= '<HEADER>';

            $message .= '<JENIS_BILLING>' . $JENIS_BILLING . '</JENIS_BILLING>';
            $message .= '<IDBILLING>' . $IDBILLING . '</IDBILLING>';
            $message .= '<IDORDER>' . $IDORDER . '</IDORDER>';
            $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
            $message .= '<CONSIGNEE>' . htmlspecialchars($CONSIGNEE) . '</CONSIGNEE>';
            $message .= '<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>';
            $message .= '<NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>';
            $message .= '<SUBTOTAL>' . $SUBTOTAL . '</SUBTOTAL>';
            $message .= '<ADMINISTRASI>' . $ADMINISTRASI . '</ADMINISTRASI>';
            $message .= '<PPN>' . $PPN . '</PPN>';
            $message .= '<TOTAL>' . $TOTAL . '</TOTAL>';
            $message .= '<NO_PROFORMA_INVOICE>' . $NO_PROFORMA_INVOICE . '</NO_PROFORMA_INVOICE>';
            $message .= '</DOCUMENT>';
        } else {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<STATUS>FALSE</STATUS>';
            $message .= '<MESSAGE>' . $SQLHeader . '</MESSAGE>';
            $message .= '</DOCUMENT>';
        }    
    }


    $og = simplexml_load_string($message);

    $return = json_encode($og);
    // print_r($return);die();
    updateLogServices($IDLogServices, $return);
    // $return = $message;
    $conn->disconnect();
    return $return;
}

function getQueueBilling($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'getQueueBilling', $fStream);
    $xml = str_replace('&', '', $fStream);
    $STR_DATA = $fStream;
    $xml = xml2ary($STR_DATA);
    // print_r($xml);die();
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        // print_r($xml);die();
        $OrderPB = $xml['QUEUEBILLING']['_c'];
        // print_r($OrderPB);die();
        $KD_LOKET = trim($OrderPB['KD_LOKET']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['KD_LOKET']['_v'])) . "";
        $JNS_LOKET = trim($OrderPB['JNS_LOKET']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['JNS_LOKET']['_v'])) . "";
        // print_r($NO_ORDER);die();
        if($JNS_LOKET == "DOKUMEN"){
            $SQLantrian = "SELECT NO_ANTRIAN FROM t_antrian_hdr WHERE NO_ANTRIAN LIKE '%B%' AND FL_USED = 'N' AND 
                        DATE_FORMAT(TANGGAL_ANTRIAN,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d') ORDER BY TANGGAL_ANTRIAN ASC LIMIT 1";
            // print_r($SQLHeader);die();
            $Queryantrian = $conn->query($SQLantrian);
        }else if($JNS_LOKET == "BAYAR"){
            $SQLantrian = "SELECT NO_ANTRIAN FROM t_antrian_hdr WHERE NO_ANTRIAN LIKE '%B%' AND FL_USED = 'Y' AND FL_BAYAR = 'N' AND 
                        DATE_FORMAT(TANGGAL_ANTRIAN,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d') ORDER BY TANGGAL_ANTRIAN ASC LIMIT 1";
            // print_r($SQLHeader);die();
            $Queryantrian = $conn->query($SQLantrian);
        }

        if ($Queryantrian->size() > 0) {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<STATUS>TRUE</STATUS>';
            $message .= '<MESSAGE>SUKSES</MESSAGE>';
            $Queryantrian->next();
            $NO_ANTRIAN = $Queryantrian->get("NO_ANTRIAN");

            $message .= '<NO_ANTRIAN>' . $NO_ANTRIAN . '</NO_ANTRIAN>';
            $message .= '</DOCUMENT>';
            if($JNS_LOKET == "DOKUMEN"){
                $SQLUpdateAntrian = "UPDATE t_antrian_hdr SET FL_USED = 'Y', TGL_USED = NOW(), LOKET_USED = 'LOKET ". $KD_LOKET ."' WHERE NO_ANTRIAN = '". $NO_ANTRIAN ."'";
                $Execute = $conn->execute($SQLUpdateAntrian);
            }else if($JNS_LOKET == "BAYAR"){
                $SQLUpdateAntrian = "UPDATE t_antrian_hdr SET FL_BAYAR = 'Y', TGL_USED = NOW(), LOKET_BAYAR = 'LOKET ". $KD_LOKET ."' WHERE NO_ANTRIAN = '". $NO_ANTRIAN ."'";
                $Execute = $conn->execute($SQLUpdateAntrian);
            }
            $SQLinsertantrian = "UPDATE t_antrian_user SET NO_ANTRIAN = '". $NO_ANTRIAN ."' WHERE KD_LOKET = '". $KD_LOKET ."'";
            $Execute = $conn->execute($SQLinsertantrian);
        } else {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<STATUS>FALSE</STATUS>';
            $message .= '<SQL>' . $SQLantrian . '</SQL>';
            $message .= '<MESSAGE>TIDAK ADA ANTRIAN LAGI!!!</MESSAGE>';
            $message .= '</DOCUMENT>';
        }    
    }


    $og = simplexml_load_string($message);

    $return = json_encode($og);
    // print_r($return);die();
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function getQueueCS($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_jav.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'getQueueCS', $fStream);
    $xml = str_replace('&', '', $fStream);
    $STR_DATA = $fStream;
    $xml = xml2ary($STR_DATA);
    // print_r($xml);die();
    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        // print_r($xml);die();
        $OrderPB = $xml['QUEUEBILLING']['_c'];
        // print_r($OrderPB);die();
        $KD_LOKET = trim($OrderPB['KD_LOKET']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['KD_LOKET']['_v'])) . "";
        $JNS_LOKET = trim($OrderPB['JNS_LOKET']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['JNS_LOKET']['_v'])) . "";
        // print_r($NO_ORDER);die();
        $SQLantrian = "SELECT NO_ANTRIAN FROM t_antrian_hdr WHERE NO_ANTRIAN LIKE '%C%' AND FL_USED = 'N' AND 
                    DATE_FORMAT(TANGGAL_ANTRIAN,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d') ORDER BY TANGGAL_ANTRIAN ASC LIMIT 1";
        // print_r($SQLHeader);die();
        $Queryantrian = $conn->query($SQLantrian);

        if ($Queryantrian->size() > 0) {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<STATUS>TRUE</STATUS>';
            $message .= '<MESSAGE>SUKSES</MESSAGE>';
            $Queryantrian->next();
            $NO_ANTRIAN = $Queryantrian->get("NO_ANTRIAN");

            $message .= '<NO_ANTRIAN>' . $NO_ANTRIAN . '</NO_ANTRIAN>';
            $message .= '</DOCUMENT>';
            $SQLUpdateAntrian = "UPDATE t_antrian_hdr SET FL_USED = 'Y', TGL_USED = NOW(), LOKET_USED = 'LOKET ". $KD_LOKET ."' WHERE NO_ANTRIAN = '". $NO_ANTRIAN ."'";
            $Execute = $conn->execute($SQLUpdateAntrian);
            $SQLinsertantrian = "UPDATE t_antrian_user SET NO_ANTRIAN = '". $NO_ANTRIAN ."' WHERE KD_LOKET = '". $KD_LOKET ."'";
            $Execute = $conn->execute($SQLinsertantrian);
        } else {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<STATUS>FALSE</STATUS>';
            $message .= '<SQL>' . $SQLantrian . '</SQL>';
            $message .= '<MESSAGE>TIDAK ADA ANTRIAN LAGI!!!</MESSAGE>';
            $message .= '</DOCUMENT>';
        }    
    }


    $og = simplexml_load_string($message);

    $return = json_encode($og);
    // print_r($return);die();
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function insertLogServices($userName, $Password, $url, $method, $xmlRequest = '', $xmlResponse = '') {
    global $CONF, $conn;
    $ipAddress = getIP();
    $userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
    // print_r($userName);die();
    $Password = $Password == '' ? 'NULL' : "'" . $Password . "'";
    $url = $url == '' ? 'NULL' : "'" . $url . "'";
    $method = $method == '' ? 'NULL' : "'" . $method . "'";
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
            VALUES (" . $userName . ", " . $Password . ", " . $url . ", " . $method . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', NOW())";
    
    $Execute = $conn->execute($SQL);
    $ID = mysql_insert_id();
    return $ID;
}

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

function updateLogServices($ID, $xmlResponse = '') {
    global $CONF, $conn;
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . mysql_escape_string($xmlResponse) . "'";
    $SQL = "UPDATE app_log_services SET RESPONSE = " . $xmlResponse . "
            WHERE ID = '" . $ID . "'";
    $Execute = $conn->execute($SQL);
	return $Execute;
}

function SendCurl($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
    $header[] = 'Content-Type: text/xml';
    $header[] = 'SOAPAction: "' . $SOAPAction . '"';
    $header[] = 'Content-length: ' . strlen($xml);
    $header[] = 'Connection: close';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_PORT, $port);
    //curl_setopt($ch, CURLOPT_PROXY, $proxy);
    //curl_setopt($ch, CURLOPT_VERBOSE, 0);
    //curl_setopt($ch, CURLOPT_HEADER, 0);
    //curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    //curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $response = curl_exec($ch);
    if (!curl_errno($ch)) {
        $return['return'] = TRUE;
        $return['info'] = curl_getinfo($ch);
        $return['response'] = $response;
    } else {
        $return['return'] = FALSE;
		$return['errno'] = curl_errno($ch);
        $return['info'] = curl_error($ch);
        $return['response'] = '';
    }
    return $return;
}

function insertCDM($CDM, $Type, $ID_LOG) {
    global $CONF, $conn;
    $message = 0;

    /* Begin Generate data */
        $CUSTOMER_ID_SEQ = trim($CDM['CUSTOMER_ID_SEQ']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_ID_SEQ']['_v'])) . "'";
        $CUSTOMER_ID = trim($CDM['CUSTOMER_ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_ID']['_v'])) . "'";
        $CUSTOMER_LABEL = trim($CDM['CUSTOMER_LABEL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_LABEL']['_v'])) . "'";
        $NAME = trim($CDM['NAME']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['NAME']['_v'])) . "'";
        $ADDRESS = trim($CDM['ADDRESS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['ADDRESS']['_v'])) . "'";
        $NPWP = trim($CDM['NPWP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['NPWP']['_v'])) . "'";
        $EMAIL = trim($CDM['EMAIL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EMAIL']['_v'])) . "'";
        $WEBSITE = trim($CDM['WEBSITE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['WEBSITE']['_v'])) . "'";
        $PHONE = trim($CDM['PHONE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['PHONE']['_v'])) . "'";
        $COMPANY_TYPE = trim($CDM['COMPANY_TYPE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['COMPANY_TYPE']['_v'])) . "'";
        $ALT_NAME = trim($CDM['ALT_NAME']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['ALT_NAME']['_v'])) . "'";
        $DEED_ESTABLISHMENT = trim($CDM['DEED_ESTABLISHMENT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['DEED_ESTABLISHMENT']['_v'])) . "','%Y%m%d')";
        $CUSTOMER_GROUP = trim($CDM['CUSTOMER_GROUP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_GROUP']['_v'])) . "'";
        $CUSTOMER_TYPE = trim($CDM['CUSTOMER_TYPE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CUSTOMER_TYPE']['_v'])) . "'";
        $SVC_VESSEL = trim($CDM['SVC_VESSEL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['SVC_VESSEL']['_v'])) . "'";
        $SVC_CARGO = trim($CDM['SVC_CARGO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['SVC_CARGO']['_v'])) . "'";
        $SVC_CONTAINER = trim($CDM['SVC_CONTAINER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['SVC_CONTAINER']['_v'])) . "'";
        $SVC_MISC = trim($CDM['SVC_MISC']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['SVC_MISC']['_v'])) . "'";
        $IS_SUBSIDIARY = trim($CDM['IS_SUBSIDIARY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_SUBSIDIARY']['_v'])) . "'";
        $HOLDING_NAME = trim($CDM['HOLDING_NAME']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['HOLDING_NAME']['_v'])) . "'";
        $EMPLOYEE_COUNT = trim($CDM['EMPLOYEE_COUNT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EMPLOYEE_COUNT']['_v'])) . "'";
        $IS_MAIN_BRANCH = trim($CDM['IS_MAIN_BRANCH']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_MAIN_BRANCH']['_v'])) . "'";
        $PARTNERSHIP_DATE = trim($CDM['PARTNERSHIP_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['PARTNERSHIP_DATE']['_v'])) . "','%Y%m%d')";
        $PROVINCE = trim($CDM['PROVINCE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['PROVINCE']['_v'])) . "'";
        $CITY = trim($CDM['CITY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CITY']['_v'])) . "'";
        $CITY_TYPE = trim($CDM['CITY_TYPE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CITY_TYPE']['_v'])) . "'";
        $KECAMATAN = trim($CDM['KECAMATAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['KECAMATAN']['_v'])) . "'";
        $KELURAHAN = trim($CDM['KELURAHAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['KELURAHAN']['_v'])) . "'";
        $POSTAL_CODE = trim($CDM['POSTAL_CODE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['POSTAL_CODE']['_v'])) . "'";
        $FAX = trim($CDM['FAX']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['FAX']['_v'])) . "'";
        $PARENT_ID = trim($CDM['PARENT_ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['PARENT_ID']['_v'])) . "'";
        $CREATE_BY = trim($CDM['CREATE_BY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CREATE_BY']['_v'])) . "'";
        $CREATE_DATE = trim($CDM['CREATE_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['CREATE_DATE']['_v'])) . "','%Y%m%d')";
        $CREATE_VIA = trim($CDM['CREATE_VIA']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CREATE_VIA']['_v'])) . "'";
        $CREATE_IP = trim($CDM['CREATE_IP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CREATE_IP']['_v'])) . "'";
        $EDIT_BY = trim($CDM['EDIT_BY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EDIT_BY']['_v'])) . "'";
        $EDIT_DATE = trim($CDM['EDIT_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['EDIT_DATE']['_v'])) . "','%Y%m%d')";
        $EDIT_VIA = trim($CDM['EDIT_VIA']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EDIT_VIA']['_v'])) . "'";
        $EDIT_IP = trim($CDM['EDIT_IP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['EDIT_IP']['_v'])) . "'";
        $IS_SHIPPING_AGENT = trim($CDM['IS_SHIPPING_AGENT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_SHIPPING_AGENT']['_v'])) . "'";
        $IS_SHIPPING_LINE = trim($CDM['IS_SHIPPING_LINE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_SHIPPING_LINE']['_v'])) . "'";
        $REG_TYPE = trim($CDM['REG_TYPE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['REG_TYPE']['_v'])) . "'";
        $IS_PBM = trim($CDM['IS_PBM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_PBM']['_v'])) . "'";
        $IS_FF = trim($CDM['IS_FF']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_FF']['_v'])) . "'";
        $IS_EMKL = trim($CDM['IS_EMKL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_EMKL']['_v'])) . "'";
        $IS_PPJK = trim($CDM['IS_PPJK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_PPJK']['_v'])) . "'";
        $IS_CONSIGNEE = trim($CDM['IS_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['IS_CONSIGNEE']['_v'])) . "'";
        $REGISTRATION_COMPANY_ID = trim($CDM['REGISTRATION_COMPANY_ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['REGISTRATION_COMPANY_ID']['_v'])) . "'";
        $HEADQUARTERS_ID = trim($CDM['HEADQUARTERS_ID']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['HEADQUARTERS_ID']['_v'])) . "'";
        $HEADQUARTERS_NAME = trim($CDM['HEADQUARTERS_NAME']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['HEADQUARTERS_NAME']['_v'])) . "'";
        $STATUS_APPROVAL = trim($CDM['STATUS_APPROVAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['STATUS_APPROVAL']['_v'])) . "'";
        $TYPE_APPROVAL = trim($CDM['TYPE_APPROVAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['TYPE_APPROVAL']['_v'])) . "'";
        $STATUS_CUSTOMER = trim($CDM['STATUS_CUSTOMER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['STATUS_CUSTOMER']['_v'])) . "'";
        $CONFIRM_DATE = trim($CDM['CONFIRM_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['CONFIRM_DATE']['_v'])) . "','%Y%m%d')";
        $APPROVE_DATE = trim($CDM['APPROVE_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['APPROVE_DATE']['_v'])) . "','%Y%m%d')";
        $ACCEPTANCE_DOC = trim($CDM['ACCEPTANCE_DOC']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['ACCEPTANCE_DOC']['_v'])) . "'";
        $ACCEPTANCE_DOC_DATE = trim($CDM['ACCEPTANCE_DOC_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['ACCEPTANCE_DOC_DATE']['_v'])) . "','%Y%m%d')";
        $REJECT_NOTES = trim($CDM['REJECT_NOTES']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['REJECT_NOTES']['_v'])) . "'";
        $REJECT_USER = trim($CDM['REJECT_USER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['REJECT_USER']['_v'])) . "'";
        $REJECT_DATE = trim($CDM['REJECT_DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CDM['REJECT_DATE']['_v'])) . "','%Y%m%d')";
        $BRANCH_SIGN = trim($CDM['BRANCH_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['BRANCH_SIGN']['_v'])) . "'";
        $PASSPORT = trim($CDM['PASSPORT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['PASSPORT']['_v'])) . "'";
        $CITIZENSHIP = trim($CDM['CITIZENSHIP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CDM['CITIZENSHIP']['_v'])) . "'";
    /* End Generate data */

    if ($Type == "insert") {
        $SQLorder = "SELECT CUSTOMER_ID_SEQ FROM mst_customer WHERE CUSTOMER_ID_SEQ = " . $CUSTOMER_ID_SEQ . "";
        $Queryorder = $conn->query($SQLorder);
        if ($Queryorder->size() == 0) {
            $SQLHeaderorder = "INSERT INTO mst_customer VALUES(" . $CUSTOMER_ID_SEQ . "," . $CUSTOMER_ID . "," . $CUSTOMER_LABEL . ",
            " . $NAME . "," . $ADDRESS . "," . $NPWP . "," . $EMAIL . "," . $WEBSITE . "," . $PHONE . "," . $COMPANY_TYPE . ",
            " . $ALT_NAME . "," . $DEED_ESTABLISHMENT . "," . $CUSTOMER_GROUP . "," . $CUSTOMER_TYPE . "," . $SVC_VESSEL . ",
            " . $SVC_CARGO . "," . $SVC_CONTAINER . "," . $SVC_MISC . "," . $IS_SUBSIDIARY . "," . $HOLDING_NAME . ",
            " . $EMPLOYEE_COUNT . "," . $IS_MAIN_BRANCH . "," . $PARTNERSHIP_DATE . "," . $PROVINCE . "," . $CITY . ",
            " . $CITY_TYPE . "," . $KECAMATAN . "," . $KELURAHAN . "," . $POSTAL_CODE . "," . $FAX . "," . $PARENT_ID . ",
            " . $CREATE_BY . "," . $CREATE_DATE . "," . $CREATE_VIA . "," . $CREATE_IP . "," . $EDIT_BY . "," . $EDIT_DATE . ",
            " . $EDIT_VIA . "," . $EDIT_IP . "," . $IS_SHIPPING_AGENT . "," . $IS_SHIPPING_LINE . "," . $REG_TYPE . "," . $IS_PBM . ",
            " . $IS_FF . "," . $IS_EMKL . "," . $IS_PPJK . "," . $IS_CONSIGNEE . "," . $REGISTRATION_COMPANY_ID . ",
            " . $HEADQUARTERS_ID . "," . $HEADQUARTERS_NAME . "," . $STATUS_APPROVAL . "," . $TYPE_APPROVAL . ",
            " . $STATUS_CUSTOMER . "," . $CONFIRM_DATE . "," . $APPROVE_DATE . "," . $ACCEPTANCE_DOC . "," . $ACCEPTANCE_DOC_DATE . ",
            " . $REJECT_NOTES . "," . $REJECT_USER . "," . $REJECT_DATE . "," . $BRANCH_SIGN . "," . $PASSPORT . "," . $CITIZENSHIP . ");";
            $Execute = $conn->execute($SQLHeaderorder);
            if ($Execute == "") {
                $message = 0;
            }else{
                $message = 1;
            }
        }else{
            $Queryorder->next();
            $CUSTOMER_ID_SEQ = $Queryorder->get("CUSTOMER_ID_SEQ");
            $SQLHeaderorder = "UPDATE mst_customer SET CUSTOMER_ID=" . $CUSTOMER_ID . ", CUSTOMER_LABEL=" . $CUSTOMER_LABEL . ", 
            NAME=" . $NAME . ", ADDRESS=" . $ADDRESS . ", NPWP=" . $NPWP . ", EMAIL=" . $EMAIL . ", WEBSITE=" . $WEBSITE . ",
            PHONE=" . $PHONE . ", COMPANY_TYPE=" . $COMPANY_TYPE . ", ALT_NAME=" . $ALT_NAME . ", 
            DEED_ESTABLISHMENT=" . $DEED_ESTABLISHMENT . ", CUSTOMER_GROUP=" . $CUSTOMER_GROUP . ", 
            CUSTOMER_TYPE=" . $CUSTOMER_TYPE . ", SVC_VESSEL=" . $SVC_VESSEL . ", SVC_CARGO=" . $SVC_CARGO . ", 
            SVC_CONTAINER=" . $SVC_CONTAINER . ", SVC_MISC=" . $SVC_MISC . ", IS_SUBSIDIARY=" . $IS_SUBSIDIARY . ", 
            HOLDING_NAME=" . $HOLDING_NAME . ", EMPLOYEE_COUNT=" . $EMPLOYEE_COUNT . ", IS_MAIN_BRANCH=" . $IS_MAIN_BRANCH . ", 
            PARTNERSHIP_DATE=" . $PARTNERSHIP_DATE . ", PROVINCE=" . $PROVINCE . ", CITY=" . $CITY . ", CITY_TYPE=" . $CITY_TYPE . ", 
            KECAMATAN=" . $KECAMATAN . ", KELURAHAN=" . $KELURAHAN . ", POSTAL_CODE=" . $POSTAL_CODE . ", FAX=" . $FAX . ", 
            PARENT_ID=" . $PARENT_ID . ", CREATE_BY=" . $CREATE_BY . ", CREATE_DATE=" . $CREATE_DATE . ", 
            CREATE_VIA=" . $CREATE_VIA . ", CREATE_IP=" . $CREATE_IP . ", EDIT_BY=" . $EDIT_BY . ", EDIT_DATE=" . $EDIT_DATE . ", EDIT_VIA=" . $EDIT_VIA . ", EDIT_IP=" . $EDIT_IP . ", IS_SHIPPING_AGENT=" . $IS_SHIPPING_AGENT . ", 
            IS_SHIPPING_LINE=" . $IS_SHIPPING_LINE . ", REG_TYPE=" . $REG_TYPE . ", IS_PBM=" . $IS_PBM . ", IS_FF=" . $IS_FF . ", 
            IS_EMKL=" . $IS_EMKL . ", IS_PPJK=" . $IS_PPJK . ", IS_CONSIGNEE=" . $IS_CONSIGNEE . ", 
            REGISTRATION_COMPANY_ID=" . $REGISTRATION_COMPANY_ID . ", HEADQUARTERS_ID=" . $HEADQUARTERS_ID . ", 
            HEADQUARTERS_NAME=" . $HEADQUARTERS_NAME . ", STATUS_APPROVAL=" . $STATUS_APPROVAL . ", 
            TYPE_APPROVAL=" . $TYPE_APPROVAL . ", STATUS_CUSTOMER=" . $STATUS_CUSTOMER . ", CONFIRM_DATE=" . $CONFIRM_DATE . ", 
            APPROVE_DATE=" . $APPROVE_DATE . ", ACCEPTANCE_DOC=" . $ACCEPTANCE_DOC . ", 
            ACCEPTANCE_DOC_DATE=" . $ACCEPTANCE_DOC_DATE . ", REJECT_NOTES=" . $REJECT_NOTES . ", REJECT_USER=" . $REJECT_USER . ", REJECT_DATE=" . $REJECT_DATE . ", BRANCH_SIGN=" . $BRANCH_SIGN . ", PASSPORT=" . $PASSPORT . ", CITIZENSHIP=" . $CITIZENSHIP . " WHERE CUSTOMER_ID_SEQ=".$CUSTOMER_ID_SEQ.";";
            $Execute = $conn->execute($SQLHeaderorder);
            if ($Execute == "") {
                $message = 0;
            }else{
                $message = 1;
            }
        }
    } elseif($Type == "update") {
        $SQLHeaderorder = "UPDATE mst_customer SET CUSTOMER_ID=" . $CUSTOMER_ID . ", CUSTOMER_LABEL=" . $CUSTOMER_LABEL . ", 
        NAME=" . $NAME . ", ADDRESS=" . $ADDRESS . ", NPWP=" . $NPWP . ", EMAIL=" . $EMAIL . ", WEBSITE=" . $WEBSITE . ",
        PHONE=" . $PHONE . ", COMPANY_TYPE=" . $COMPANY_TYPE . ", ALT_NAME=" . $ALT_NAME . ", 
        DEED_ESTABLISHMENT=" . $DEED_ESTABLISHMENT . ", CUSTOMER_GROUP=" . $CUSTOMER_GROUP . ", 
        CUSTOMER_TYPE=" . $CUSTOMER_TYPE . ", SVC_VESSEL=" . $SVC_VESSEL . ", SVC_CARGO=" . $SVC_CARGO . ", 
        SVC_CONTAINER=" . $SVC_CONTAINER . ", SVC_MISC=" . $SVC_MISC . ", IS_SUBSIDIARY=" . $IS_SUBSIDIARY . ", 
        HOLDING_NAME=" . $HOLDING_NAME . ", EMPLOYEE_COUNT=" . $EMPLOYEE_COUNT . ", IS_MAIN_BRANCH=" . $IS_MAIN_BRANCH . ", 
        PARTNERSHIP_DATE=" . $PARTNERSHIP_DATE . ", PROVINCE=" . $PROVINCE . ", CITY=" . $CITY . ", CITY_TYPE=" . $CITY_TYPE . ", 
        KECAMATAN=" . $KECAMATAN . ", KELURAHAN=" . $KELURAHAN . ", POSTAL_CODE=" . $POSTAL_CODE . ", FAX=" . $FAX . ", 
        PARENT_ID=" . $PARENT_ID . ", CREATE_BY=" . $CREATE_BY . ", CREATE_DATE=" . $CREATE_DATE . ", 
        CREATE_VIA=" . $CREATE_VIA . ", CREATE_IP=" . $CREATE_IP . ", EDIT_BY=" . $EDIT_BY . ", EDIT_DATE=" . $EDIT_DATE . ", EDIT_VIA=" . $EDIT_VIA . ", EDIT_IP=" . $EDIT_IP . ", IS_SHIPPING_AGENT=" . $IS_SHIPPING_AGENT . ", 
        IS_SHIPPING_LINE=" . $IS_SHIPPING_LINE . ", REG_TYPE=" . $REG_TYPE . ", IS_PBM=" . $IS_PBM . ", IS_FF=" . $IS_FF . ", 
        IS_EMKL=" . $IS_EMKL . ", IS_PPJK=" . $IS_PPJK . ", IS_CONSIGNEE=" . $IS_CONSIGNEE . ", 
        REGISTRATION_COMPANY_ID=" . $REGISTRATION_COMPANY_ID . ", HEADQUARTERS_ID=" . $HEADQUARTERS_ID . ", 
        HEADQUARTERS_NAME=" . $HEADQUARTERS_NAME . ", STATUS_APPROVAL=" . $STATUS_APPROVAL . ", 
        TYPE_APPROVAL=" . $TYPE_APPROVAL . ", STATUS_CUSTOMER=" . $STATUS_CUSTOMER . ", CONFIRM_DATE=" . $CONFIRM_DATE . ", 
        APPROVE_DATE=" . $APPROVE_DATE . ", ACCEPTANCE_DOC=" . $ACCEPTANCE_DOC . ", 
        ACCEPTANCE_DOC_DATE=" . $ACCEPTANCE_DOC_DATE . ", REJECT_NOTES=" . $REJECT_NOTES . ", REJECT_USER=" . $REJECT_USER . ", REJECT_DATE=" . $REJECT_DATE . ", BRANCH_SIGN=" . $BRANCH_SIGN . ", PASSPORT=" . $PASSPORT . ", CITIZENSHIP=" . $CITIZENSHIP . " WHERE CUSTOMER_ID_SEQ=".$CUSTOMER_ID_SEQ.";";
        $Execute = $conn->execute($SQLHeaderorder);
        if ($Execute == "") {
            $message = 0;
        }else{
            $message = 1;
        }
    }
    return $message;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$server->service($HTTP_RAW_POST_DATA);
?>
