<?php

set_time_limit(3600);
require_once("config.php");
$CONF['url.wsdl'] = 'http://103.29.187.109/TPSServices/services.php';
$method = 'GetBC23Permit_FASP';
$KdAPRF = 'GETBC23PERMIT';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
    $main->connect();

    //BEGIN
    $SOAPAction = 'http://services.beacukai.go.id/' . $method;
    $SQL = "SELECT DISTINCT B.KD_TPS, C.KD_GUDANG, B.USERNAME_TPSONLINE_BC, B.PASSWORD_TPSONLINE_BC, 
                   A.KD_ORG_SENDER, A.KD_ORG_RECEIVER
            FROM app_setting A INNER JOIN t_organisasi B ON A.KD_ORG_RECEIVER = B.ID
                               INNER JOIN app_user C ON B.ID = C.KD_ORGANISASI
            WHERE A.KD_APRF = '" . $KdAPRF . "'
                  AND A.KD_STATUS = 'Y'
                  AND B.KD_TIPE_ORGANISASI IN ('TPS','TPS1','TPS2')";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $KD_TPS = $Query->get("KD_TPS");
            $KD_GUDANG = $Query->get("KD_GUDANG");
            $USERNAME_TPSONLINE_BC = $Query->get("USERNAME_TPSONLINE_BC");
            $PASSWORD_TPSONLINE_BC = $Query->get("PASSWORD_TPSONLINE_BC");
            $KD_ORG_SENDER = $Query->get("KD_ORG_SENDER");
            $KD_ORG_RECEIVER = $Query->get("KD_ORG_RECEIVER");

            /*$xml = '<?xml version="1.0" encoding="utf-8"?>
                    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                      <soap:Body>
                        <GetBC23Permit_FASP xmlns="http://services.beacukai.go.id/">
                          <UserName>' . $USERNAME_TPSONLINE_BC . '</UserName>
                          <Password>' . $PASSWORD_TPSONLINE_BC . '</Password>
                          <Kd_ASP>' . $KD_TPS . '</Kd_ASP>
                        </GetBC23Permit_FASP>
                      </soap:Body>
                    </soap:Envelope>';*/
			$xml = '<?xml version="1.0" encoding="utf-8"?>
					<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <ser:GetBC23Permit_FASP soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
						 <UserName xsi:type="xsd:string">' . $USERNAME_TPSONLINE_BC . '</UserName>
						 <Password xsi:type="xsd:string">' . $PASSWORD_TPSONLINE_BC . '</Password>
						 <Kd_ASP xsi:type="xsd:string">' . $KD_TPS . '</Kd_ASP>
					  </ser:GetBC23Permit_FASP>
				   </soapenv:Body>
				</soapenv:Envelope>';
            $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport']);
            echo '<pre>';
            print_r($Send);
            echo '</pre>';
            if ($Send['response'] != '') {
                //$arr1 = 'GetBC23Permit_FASPResponse';
                $arr1 = 'ns1:GetBC23Permit_FASPResponse';
                $arr2 = 'GetBC23Permit_FASPResult';
                $response = xml2ary($Send['response']);
                //$response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                $response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];

                $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER, STR_DATA, KD_STATUS, TGL_STATUS)
                        VALUES (NULL, '" . $KdAPRF . "','" . $KD_ORG_SENDER . "','" . $KD_ORG_RECEIVER . "','" . $response . "','100',NOW())";
                $Execute = $conn->execute($SQL);
            } else {
                $response = '';
            }

            $SQL = "CALL create_log_services('" . $CONF['url.wsdl'] . "','" . $method . "','" . str_replace("'", "''", $xml) . "','" . str_replace("'", "''", $response) . "')";
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