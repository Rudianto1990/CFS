<?php
set_time_limit(3600);
require_once("config.php");
#$CONF['url.wsdl'] = 'http://10.1.5.109/TPSServices/services.php';
ini_set("error_reporting","0");
$method = 'UploadMohonPLP';
$KdAPRF = 'SENTAJUPLP';
$filename = $CONF['root.dir'] . "CheckScheduler/".$method.".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    #$createFile = $main->createFile($filename);
    $main->connect();

    //BEGIN
    $SOAPAction = 'http://services.beacukai.go.id/'.$method;
    $SQL = "SELECT A.ID, A.STR_DATA, B.USERNAME_TPSONLINE_BC, B.PASSWORD_TPSONLINE_BC, A.SNRF
            FROM postbox A 
			INNER JOIN t_organisasi B ON A.KD_ORG_SENDER = B.ID
            WHERE A.KD_APRF = '" . $KdAPRF . "'
                  AND B.USERNAME_TPSONLINE_BC IS NOT NULL
                  AND B.PASSWORD_TPSONLINE_BC IS NOT NULL
                  AND A.KD_STATUS = '100'
            LIMIT 0,20";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $ID = $Query->get("ID");
			$REF_NUMBER = $Query->get("SNRF");
            $STR_DATA = $Query->get("STR_DATA");
            $USERNAME_TPSONLINE_BC = $Query->get("USERNAME_TPSONLINE_BC");
            $PASSWORD_TPSONLINE_BC = $Query->get("PASSWORD_TPSONLINE_BC");
            $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
                    <soapenv:Header/>
                    <soapenv:Body>
                       <ser:UploadMohonPLP>
                          <!--Optional:-->
                          <ser:fStream>' . htmlspecialchars($STR_DATA) . '</ser:fStream>
                          <!--Optional:-->
                          <ser:Username>' . $USERNAME_TPSONLINE_BC . '</ser:Username>
                          <!--Optional:-->
                          <ser:Password>' . $PASSWORD_TPSONLINE_BC . '</ser:Password>
                       </ser:UploadMohonPLP>
                    </soapenv:Body>
                 </soapenv:Envelope>';
			/*$xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <ser:UploadMohonPLP soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
						 <fStream xsi:type="xsd:string">' . htmlspecialchars($STR_DATA) . '</fStream>
						 <Username xsi:type="xsd:string">' . $USERNAME_TPSONLINE_BC . '</Username>
						 <Password xsi:type="xsd:string">' . $PASSWORD_TPSONLINE_BC . '</Password>
					  </ser:UploadMohonPLP>
				   </soapenv:Body>
				</soapenv:Envelope>';*/
            $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport'],'80');
           	print_r($Send);
            if ($Send['response'] != '') {
                $arr1 = 'UploadMohonPLPResponse';
				#$arr1 = 'ns1:UploadMohonPLPResponse';
                $arr2 = 'UploadMohonPLPResult';
                $response = xml2ary($Send['response']);
                $response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
				//$response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
				#echo '<br>';
				#echo '<pre>';
				print_r($response);
				#echo '</pre>';
				$pos = strpos(strtolower($response), 'berhasil');
				if ($pos === false){
					$STATUS_POST = '300';
                	$STATUS_HDR = '500';
				}else{
					$STATUS_POST = '200';
               		$STATUS_HDR = '400';
				}
            } else {
                $response = '';
				$STATUS_POST = '300';
                $STATUS_HDR = '500';
            }
            $SQL = "UPDATE postbox SET KD_STATUS = '".$STATUS_POST."', KETERANGAN = '".$Send['response']."', TGL_STATUS = NOW()
                    WHERE ID = '" . $ID . "'";
           	$Execute = $conn->execute($SQL);
			
			$SQL = "UPDATE t_request_plp_hdr SET KD_STATUS = '".$STATUS_HDR."', TGL_STATUS = NOW()
                    WHERE REF_NUMBER = '" . $REF_NUMBER . "'";
            $Execute = $conn->execute($SQL);
           
        }
    } else {
		echo "tidak ada data";
        $response =  "Data " . $method . " tidak ada.";
    }
	
	$SQL = "CALL create_log_services('" . $CONF['url.wsdl'] . "','" . $method . "','" . str_replace("'", "''", $xml) . "','" . str_replace("'", "''", $response) . "')";
    $Execute = $conn->execute($SQL);
    //END

    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}
?>