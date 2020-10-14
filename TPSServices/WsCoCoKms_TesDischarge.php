<?php

set_time_limit(3600);
require_once("config.php");

$method = 'CoCoKms_Tes';
$KdAPRF = 'SENTDISCHBC';
$SufixMethod = 'Discharge';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . "" . $SufixMethod . ".txt";
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
            $xml = '<?xml version="1.0" encoding="utf-8"?>
                    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                      <soap:Body>
                        <CoCoKms_Tes xmlns="http://services.beacukai.go.id/">
                          <fStream>' . htmlspecialchars($STR_DATA) . '</fStream>
                          <Username>TES</Username>
                          <Password>1234</Password>
                        </CoCoKms_Tes>
                      </soap:Body>
                    </soap:Envelope>';
            $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport']);
            print_r($Send);
            if ($Send['response'] != '') {
                $arr1 = 'CoCoKms_TesResponse';
                $arr2 = 'CoCoKms_TesResult';
                $response = xml2ary($Send['response']);
                $response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                $KD_STATUS = '200';
            } else {
                $response = '';
                $KD_STATUS = '300';
            }

            $SQL = "UPDATE postbox SET KD_STATUS = '" . $KD_STATUS . "', TGL_STATUS = NOW()
                    WHERE ID = '" . $ID . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "CALL create_log_services('" . $CONF['url.wsdl'] . "','" . $method . "" . $SufixMethod . "','" . str_replace("'", "''", $xml) . "','" . str_replace("'", "''", $response) . "')";
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