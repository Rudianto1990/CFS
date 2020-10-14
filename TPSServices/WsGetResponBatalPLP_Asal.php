<?php
set_time_limit(3600);
require_once("config.php");
$method = 'GetResponBatalPLP';
$KdAPRF = 'GETRESBTLPLPASAL';
//$CONF['url.wsdl'] = 'http://10.1.5.109/TPSServices/services.php';
$filename = $CONF['root.dir']."CheckScheduler/".$method.".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    #$createFile = $main->createFile($filename);
    $main->connect();
    //BEGIN
    $SOAPAction = 'http://services.beacukai.go.id/'.$method;
    $SQL = "SELECT DISTINCT B.KD_TPS, B.USERNAME_TPSONLINE_BC, B.PASSWORD_TPSONLINE_BC, A.KD_ORG_SENDER, A.KD_ORG_RECEIVER
            FROM app_setting A INNER JOIN t_organisasi B ON A.KD_ORG_RECEIVER = B.ID
            WHERE A.KD_APRF = '" . $KdAPRF . "'
                  AND A.KD_STATUS = 'Y'
                  AND B.KD_TIPE_ORGANISASI IN ('TPS','TPS1','TPS2')";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $KD_TPS = $Query->get("KD_TPS");
            $USERNAME_TPSONLINE_BC = $Query->get("USERNAME_TPSONLINE_BC");
            $PASSWORD_TPSONLINE_BC = $Query->get("PASSWORD_TPSONLINE_BC");
            $KD_ORG_SENDER = $Query->get("KD_ORG_SENDER");
            $KD_ORG_RECEIVER = $Query->get("KD_ORG_RECEIVER");
			$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
						<soapenv:Header/>
						<soapenv:Body>
						  <ser:GetResponBatalPLP>
							 <ser:Username>' . $USERNAME_TPSONLINE_BC . '</ser:Username>
							 <ser:Password>' . $PASSWORD_TPSONLINE_BC . '</ser:Password>
							 <ser:Kd_asp>' . $KD_TPS . '</ser:Kd_asp>
						  </ser:GetResponBatalPLP>
						</soapenv:Body>
					</soapenv:Envelope>';
			$Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport']);
            echo '<pre>';
            print_r($Send);
            echo '</pre>';
            if ($Send['response'] != '') {
				$arr1 = 'GetResponBatalPLPResponse';
                //$arr1 = 'ns1:GetResponBatalPLPResponse';
                $arr2 = 'GetResponBatalPLPResult';
                $response = xml2ary($Send['response']);
                $response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                //$response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER, STR_DATA, KD_STATUS, TGL_STATUS)
                        VALUES (NULL, '" . $KdAPRF . "','" . $KD_ORG_SENDER . "','" . $KD_ORG_RECEIVER . "','" . $response . "','100',NOW())";
                $Execute = $conn->execute($SQL);
            } else {
                $response = '';
            }
            $SQL = "CALL create_log_services('" . $CONF['url.wsdl'] . "','" . $method . "','" . $xml . "','" . $response . "')";
            $Execute = $conn->execute($SQL);
        }
    } else {
        echo 'Data user TPS tidak ada.';
    }
    //END

    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}
?>