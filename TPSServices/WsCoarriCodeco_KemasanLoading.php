<?php

set_time_limit(3600);
require_once("config.php");
$CONF['url.wsdl'] = 'http://103.29.187.109/TPSServices/services.php';
$method = 'CoarriCodeco_Kemasan';
$KdAPRF = 'SENTLOADBC';
$SufixMethod = 'Loading';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . "Kms" . $SufixMethod . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
    $main->connect();

    //BEGIN
    $SOAPAction = 'http://services.beacukai.go.id/' . $method;
    $SQL = "SELECT A.ID, A.STR_DATA, B.USERNAME_TPSONLINE_BC, B.PASSWORD_TPSONLINE_BC
            FROM postbox A INNER JOIN t_organisasi B ON A.KD_ORG_SENDER = B.ID
            WHERE A.KD_APRF = '" . $KdAPRF . "'
                  AND B.USERNAME_TPSONLINE_BC IS NOT NULL
                  AND B.PASSWORD_TPSONLINE_BC IS NOT NULL
                  AND A.KD_STATUS = '100'
            LIMIT 0,20";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $ID = $Query->get("ID");
            $STR_DATA = $Query->get("STR_DATA");
            $USERNAME_TPSONLINE_BC = $Query->get("USERNAME_TPSONLINE_BC");
            $PASSWORD_TPSONLINE_BC = $Query->get("PASSWORD_TPSONLINE_BC");
            /* $xml = '<?xml version="1.0" encoding="utf-8"?>
              <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
              <CoarriCodeco_Kemasan xmlns="http://services.beacukai.go.id/">
              <fStream>' . htmlspecialchars($STR_DATA) . '</fStream>
              <Username>' . $USERNAME_TPSONLINE_BC . '</Username>
              <Password>' . $PASSWORD_TPSONLINE_BC . '</Password>
              </CoarriCodeco_Kemasan>
              </soap:Body>
              </soap:Envelope>'; */
            $xml = '<?xml version="1.0" encoding="utf-8"?>
                    <soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
                    <soapenv:Header/>
                    <soapenv:Body>
                       <ser:CoarriCodeco_Kemasan soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                          <fStream xsi:type="xsd:string">' . htmlspecialchars($STR_DATA) . '</fStream>
                          <Username xsi:type="xsd:string">' . $USERNAME_TPSONLINE_BC . '</Username>
                          <Password xsi:type="xsd:string">' . $PASSWORD_TPSONLINE_BC . '</Password>
                       </ser:CoarriCodeco_Kemasan>
                    </soapenv:Body>
                 </soapenv:Envelope>';
            $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport'],'80');
            print_r($Send);
            if ($Send['response'] != '') {
                //$arr1 = 'CoarriCodeco_KemasanResponse';
                $arr1 = 'ns1:CoarriCodeco_KemasanResponse';
                $arr2 = 'CoarriCodeco_KemasanResult';
                $response = xml2ary($Send['response']);
                //$response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                $response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                $KD_STATUS = '200';
            } else {
                $response = '';
                $KD_STATUS = '300';
            }

            $SQL = "UPDATE postbox SET KD_STATUS = '" . $KD_STATUS . "', TGL_STATUS = NOW()
                    WHERE ID = '" . $ID . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "CALL create_log_services('" . $CONF['url.wsdl'] . "','" . $method . "" . $SufixMethod . "','" . $xml . "','" . $response . "')";
            $Execute = $conn->execute($SQL);
        }
    } else {
        echo "Data " . $method . "" . $SufixMethod . " tidak ada.";
    }
    //END

    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '' . $SufixMethod . '.txt yang ada difolder CheckScheduler.';
}
?>