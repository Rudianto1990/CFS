<?php

ob_start();
// call library
require_once ('config.php' );
$CONF['url.wsdl'] = 'http://103.29.187.215/cfs-center/TPSServices/server_billing.php';
require_once ($CONF['root.dir'] . 'Libraries/nusoap/nusoap.php' );
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

// create instance sdf
$server = new soap_server(); 

// initialize WSDL support
$server->configureWSDL('BillingService', 'urn:BillingService');

// place schema at namespace with prefix tns
//$server->wsdl->schemaTargetNamespace = 'http://services.beacukai.go.id/';
$server->register('billingLiniDua', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('return' => 'xsd:string'), // output
        'urn:billingLiniDua', // namespace 
		'urn:billingLiniDua#billingLiniDua', // soapaction
	    'rpc', // style
	    'encoded', // use 
	    'Fungsi Billing lini Dua' // documentation
);

$server->register('GetBillingLiniSatu', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('return' => 'xsd:string'), // output
        'urn:GetBillingLiniSatu', // namespace 
		'urn:GetBillingLiniSatu#GetBillingLiniSatu', // soapaction
	    'rpc', // style
	    'encoded', // use 
	    'Fungsi Get Billing lini Satu' // documentation
);

function billingLiniDua($fStream, $Username, $Password) {
	global $CONF, $conn;
    $conn->connect();
    $returnXML = '';
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'BillingLiniDua', $fStream);
    if($Username == 'BAND' && $Password=='pass123abc'){
$CONF['root.dir'] = '/var/www/html/dev/cfs-center/TPSServices/';
    	$array_xml = xml2ary($fStream);
    	$array_header = $array_xml['billing']['_c'];
    	$array_detail = $array_xml['billing']['_c']['detail']['_c'];
    	$sender = $array_header['sender']['_v'];    	
    	$totDetail = count($array_detail['rowData']);     	
    	if($totDetail>0){
    		if($totDetail==1){
    			$noSP = strtoupper(trim($array_detail['rowData']['_c']['noSP']['_v']));
	    			$tglSP = "STR_TO_DATE('".$array_detail['rowData']['_c']['tglSP']['_v']."','%Y%m%d')";
	    			$noNota = $array_detail['rowData']['_c']['noNota']['_v'];
	    			$noFaktur = $array_detail['rowData']['_c']['noFaktur']['_v'];
	    			$namaPemilik = strtoupper(trim($array_detail['rowData']['_c']['namaPemilik']['_v']));

	    			$penumpukan = $array_detail['rowData']['_c']['penumpukan']['_v'];
	    			$receivingDelivery = $array_detail['rowData']['_c']['receivingDelivery']['_v'];
	    			$mekStripping = $array_detail['rowData']['_c']['mekStripping']['_v'];
	    			$kebersihanKeamanan = $array_detail['rowData']['_c']['kebersihanKeamanan']['_v'];
	    			$behandleSurcharge = $array_detail['rowData']['_c']['behandleSurcharge']['_v'];
	    			$liftoffLifton = $array_detail['rowData']['_c']['liftoffLifton']['_v'];
	    			$administrasi = $array_detail['rowData']['_c']['administrasi']['_v'];

	    			$jumlah = $array_detail['rowData']['_c']['jumlah']['_v'];
	    			$ppn = $array_detail['rowData']['_c']['ppn']['_v'];
	    			$jumlahTagih = $array_detail['rowData']['_c']['jumlahTagih']['_v'];
	    			$noContAsal = $array_detail['rowData']['_c']['noContAsal']['_v'];
	    			$BC11Number = $array_detail['rowData']['_c']['BC11Number']['_v']; 
	    			$BC11Date = "STR_TO_DATE('".$array_detail['rowData']['_c']['BC11Date']['_v']."','%Y%m%d')";

	    			$SQL = "INSERT INTO t_billing_hdr(KD_GUDANG,NO_SP, TGL_NOTA, NO_NOTA, NO_FAKTUR, PEMILIK,JUMLAH,PPN,TOT_TAGIHAN,NO_CONT,NO_BC11,TGL_BC11)
	            VALUES ('".$sender."','".$noSP."', ".$tglSP.",'". $noNota."','".$noFaktur."','".$namaPemilik."',".$jumlah.",".$ppn.",".$jumlahTagih.",'".$noContAsal."','".$BC11Number."',".$BC11Date.")";
	            
				    $Execute = $conn->execute($SQL);			    
				    if($Execute){
				    	$ID = mysql_insert_id();
				    	$SQLDetil = "INSERT INTO t_billing_dtl(ID_HDR,ID_REFF,COST)VALUES(".$ID.",'1',".$penumpukan."),(".$ID.",'2',".$receivingDelivery."),(".$ID.",'3',".$mekStripping."),(".$ID.",'4',".$kebersihanKeamanan."),(".$ID.",'5',".$behandleSurcharge."),(".$ID.",'6',".$liftoffLifton."),(".$ID.",'7',".$administrasi.");";
				    	$Executedtl = $conn->execute($SQLDetil);

				    	if($Executedtl){
							$returnXML = '<?xml version="1.0" encoding="UTF-8"?>
										  <billing>
												<status>berhasil</status>							
										  </billing>';    		    		
				    	}
				    }
    		}else{	
	    		for($i=0;$i<$totDetail;$i++){    			
	    			$noSP = strtoupper(trim($array_detail['rowData'][$i]['_c']['noSP']['_v']));
	    			$tglSP = "STR_TO_DATE('".$array_detail['rowData'][$i]['_c']['tglSP']['_v']."','%Y%m%d')";
	    			$noNota = $array_detail['rowData'][$i]['_c']['noNota']['_v'];
	    			$noFaktur = $array_detail['rowData'][$i]['_c']['noFaktur']['_v'];
	    			$namaPemilik = strtoupper(trim($array_detail['rowData'][$i]['_c']['namaPemilik']['_v']));

	    			$penumpukan = $array_detail['rowData'][$i]['_c']['penumpukan']['_v'];
	    			$receivingDelivery = $array_detail['rowData'][$i]['_c']['receivingDelivery']['_v'];
	    			$mekStripping = $array_detail['rowData'][$i]['_c']['mekStripping']['_v'];
	    			$kebersihanKeamanan = $array_detail['rowData'][$i]['_c']['kebersihanKeamanan']['_v'];
	    			$behandleSurcharge = $array_detail['rowData'][$i]['_c']['behandleSurcharge']['_v'];
	    			$liftoffLifton = $array_detail['rowData'][$i]['_c']['liftoffLifton']['_v'];
	    			$administrasi = $array_detail['rowData'][$i]['_c']['administrasi']['_v'];

	    			$jumlah = $array_detail['rowData'][$i]['_c']['jumlah']['_v'];
	    			$ppn = $array_detail['rowData'][$i]['_c']['ppn']['_v'];
	    			$jumlahTagih = $array_detail['rowData'][$i]['_c']['jumlahTagih']['_v'];
	    			$noContAsal = $array_detail['rowData'][$i]['_c']['noContAsal']['_v'];
	    			$BC11Number = $array_detail['rowData'][$i]['_c']['BC11Number']['_v']; 
	    			$BC11Date = "STR_TO_DATE('".$array_detail['rowData'][$i]['_c']['BC11Date']['_v']."','%Y%m%d')";

	    			$SQL = "INSERT INTO t_billing_hdr(KD_GUDANG,NO_SP, TGL_NOTA, NO_NOTA, NO_FAKTUR, PEMILIK,JUMLAH,PPN,TOT_TAGIHAN,NO_CONT,NO_BC11,TGL_BC11)
	            VALUES ('".$sender."','".$noSP."', ".$tglSP.",'". $noNota."','".$noFaktur."','".$namaPemilik."',".$jumlah.",".$ppn.",".$jumlahTagih.",'".$noContAsal."','".$BC11Number."',".$BC11Date.")";
	            
				    $Execute = $conn->execute($SQL);			    
				    if($Execute){
				    	$ID = mysql_insert_id();
				    	$SQLDetil = "INSERT INTO t_billing_dtl(ID_HDR,ID_REFF,COST)VALUES(".$ID.",'1',".$penumpukan."),(".$ID.",'2',".$receivingDelivery."),(".$ID.",'3',".$mekStripping."),(".$ID.",'4',".$kebersihanKeamanan."),(".$ID.",'5',".$behandleSurcharge."),(".$ID.",'6',".$liftoffLifton."),(".$ID.",'7',".$administrasi.");";
				    	$Executedtl = $conn->execute($SQLDetil);

				    	if($Executedtl){
							$returnXML = '<?xml version="1.0" encoding="UTF-8"?>
										  <billing>
												<status>berhasil</status>							
										  </billing>';    		    		
				    	}
				    }

	    		}	
	    	}
    	}    	
    }else{
    	$returnXML = '<?xml version="1.0" encoding="UTF-8"?>
					  <billing>
							<status>failed</status>							
					  </billing>'; 
    }
    updateLogServices($IDLogServices, $returnXML);
return $returnXML;die();    
}

function GetBillingLiniSatu($fStream, $Username, $Password) {
	global $CONF, $conn; 
    $conn->connect();

    $SQL = "SELECT KD_GUDANG, NO_CONT FROM t_billing_hdr WHERE KD_GUDANG='".$Username."' limit 0,1";
    
    $Query = $conn->query($SQL);
    $total = $Query->size(); 
    $Query->next();
    echo $Query->get('NO_CONT');die();

    // while ($Query->next()) {

    // }



    $returnXML = '';
    //$IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GettBillingLiniSatu', $fStream);
    if($Username == 'BAND' && $Password=='pass123abc'){
    	$array_xml = xml2ary($fStream);
    	$array_header = $array_xml['billing']['_c'];
    	$array_detail = $array_xml['billing']['_c']['BillDetail']['_c'];
    	//$array_header['sender']['_v'];
    	$totDetail = count($array_detail['detail']);    	
    	
    	if($totDetail>0){
    		for($i=0;$i<$totDetail;$i++){
    			$billdesc = $array_detail['detail'][$i]['_c']['billdesc']['_v'];
    			$cost = $array_detail['detail'][$i]['_c']['cost']['_v'];
    			
    		}	
    	}

    	$returnXML = '<?xml version="1.0" encoding="UTF-8"?>
					  <billing>
							<status>berhasil</status>							
					  </billing>';    	
    	
    }else{
    	$returnXML = '<?xml version="1.0" encoding="UTF-8"?>
					  <billing>
							<status>failed</status>							
					  </billing>'; 
    }
    //updateLogServices($IDLogServices, $returnXML);
return $returnXML;die();    
}


function insertLogServices($userName, $Password, $url, $method, $xmlRequest = '', $xmlResponse = '') {
    global $CONF, $conn;
    $ipAddress = getIP();
    $userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
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

function updateLogServices($ID, $xmlResponse = '') {
    global $CONF, $conn;
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "UPDATE app_log_services SET RESPONSE = " . $xmlResponse . "
            WHERE ID = '" . $ID . "'";
    $Execute = $conn->execute($SQL);
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

function SendCurl($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
    $header[] = 'Content-Type: text/xml';
    $header[] = 'SOAPAction: "' . $SOAPAction . '"';
    $header[] = 'Content-length: ' . strlen($xml);
    $header[] = 'Connection: close';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //        curl_setopt($ch, CURLOPT_PORT, $port);
    //        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $response = curl_exec($ch);
    if (!curl_errno($ch)) {
        $return['return'] = TRUE;
        $return['info'] = curl_getinfo($ch);
        $return['response'] = $response;
    } else {
        $return['return'] = FALSE;
        $return['info'] = curl_error($ch);
        $return['response'] = '';
    }
    return $return;
}

function checkUser($user, $password, $IDLogServices) {
    global $CONF, $conn;
    $SQL = "SELECT B.KD_TIPE_ORGANISASI,B.ID
            FROM app_user_ws A INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
            WHERE A.USERLOGIN = '" . trim($user) . "'
                  AND A.PASSWORD = '" . trim($password) . "'";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $return['return'] = false;
        $return['message'] = '<?xml version="1.0" encoding="UTF-8"?>';
        $return['message'] .= '<DOCUMENT>';
        $return['message'] .= '<RESPON>USERNAME ATAU PASSWORD SALAH.</RESPON>';
        $return['message'] .= '</DOCUMENT>';
        $logServices = updateLogServices($IDLogServices, $return['message'], 'USERNAME ATAU PASSWORD SALAH.');
    } else {
    	$Query->next();        
        $return['return'] = true;
        $return['kdorganisasi'] = $Query->get("ID");
    }
    return $return;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>